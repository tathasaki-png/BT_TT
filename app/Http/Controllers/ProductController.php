<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('product.index_new', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return view('product.create_new');
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $slug = Str::slug($request->title);
            $timestamp = time();
            $imageArray = [];

            foreach ($images as $index => $image) {
                // Skip if file is not valid
                if (!$image->isValid()) {
                    continue;
                }

                // Generate unique filename for each image
                $extension = $image->getClientOriginalExtension();
                $uniqueFilename = $slug . '-' . $timestamp . '-' . ($index + 1) . '.' . $extension;

                // Save original image to storage/app/public/uploads
                $imagePath = $image->storeAs('uploads', $uniqueFilename, 'public');
                
                // Create thumbnail
                $thumbnailPath = $this->createThumbnail($image, $slug, $timestamp, $index + 1, $extension);

                $imageArray[] = [
                    'original' => $imagePath,
                    'thumbnail' => $thumbnailPath
                ];

                // Set first image as main image and thumbnail for backward compatibility
                if ($index === 0) {
                    $product->image = $imagePath;
                    $product->thumbnail = $thumbnailPath;
                }
            }

            // Store all images as JSON
            if (!empty($imageArray)) {
                $product->images = $imageArray;
            }
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        // Handle image update
        if ($request->hasFile('images')) {
            // Delete old images
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $imageData) {
                    if (isset($imageData['original'])) {
                        Storage::disk('public')->delete($imageData['original']);
                    }
                    if (isset($imageData['thumbnail'])) {
                        Storage::disk('public')->delete($imageData['thumbnail']);
                    }
                }
            }

            $images = $request->file('images');
            $slug = Str::slug($request->title);
            $timestamp = time();
            $imageArray = [];

            foreach ($images as $index => $image) {
                // Generate unique filename for each image
                $extension = $image->getClientOriginalExtension();
                $uniqueFilename = $slug . '-' . $timestamp . '-' . ($index + 1) . '.' . $extension;

                // Save original image to storage/app/public/uploads
                $imagePath = $image->storeAs('uploads', $uniqueFilename, 'public');
                
                // Create thumbnail
                $thumbnailPath = $this->createThumbnail($image, $slug, $timestamp, $index + 1, $extension);

                $imageArray[] = [
                    'original' => $imagePath,
                    'thumbnail' => $thumbnailPath
                ];

                // Set first image as main image and thumbnail for backward compatibility
                if ($index === 0) {
                    $product->image = $imagePath;
                    $product->thumbnail = $thumbnailPath;
                }
            }

            // Store all images as JSON
            $product->images = $imageArray;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // Images will be deleted automatically via model event

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Create thumbnail from uploaded image
     */
    private function createThumbnail($file, $slug, $timestamp, $index, $extension)
    {
        try {
            $thumbnailFilename = $slug . '-' . $timestamp . '-' . $index . '-thumb.' . $extension;
            $thumbnailPath = 'uploads/thumbnails/' . $thumbnailFilename;

            // Get the full path to save thumbnail in storage/app/public
            $fullPath = storage_path('app/public/' . $thumbnailPath);

            // Create thumbnails directory if it doesn't exist
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Get image info
            $imageInfo = getimagesize($file->getRealPath());
            $mimeType = $imageInfo['mime'];

            // Create image resource based on type
            switch ($mimeType) {
                case 'image/jpeg':
                    $source = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($file->getRealPath());
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($file->getRealPath());
                    break;
                default:
                    return null;
            }

            // Get original dimensions
            $width = imagesx($source);
            $height = imagesy($source);

            // Calculate thumbnail dimensions (300x300)
            $thumbWidth = 300;
            $thumbHeight = 300;

            // Calculate scaling
            $scale = min($thumbWidth / $width, $thumbHeight / $height);
            $newWidth = floor($width * $scale);
            $newHeight = floor($height * $scale);

            // Create thumbnail
            $thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);

            // Preserve transparency for PNG and GIF
            if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
                imagefilledrectangle($thumb, 0, 0, $thumbWidth, $thumbHeight, $transparent);
            } else {
                // White background for JPEG
                $white = imagecolorallocate($thumb, 255, 255, 255);
                imagefilledrectangle($thumb, 0, 0, $thumbWidth, $thumbHeight, $white);
            }

            // Center the image
            $x = floor(($thumbWidth - $newWidth) / 2);
            $y = floor(($thumbHeight - $newHeight) / 2);

            // Resize and copy
            imagecopyresampled($thumb, $source, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);

            // Save thumbnail
            switch ($mimeType) {
                case 'image/jpeg':
                    imagejpeg($thumb, $fullPath, 90);
                    break;
                case 'image/png':
                    imagepng($thumb, $fullPath, 9);
                    break;
                case 'image/gif':
                    imagegif($thumb, $fullPath);
                    break;
            }

            // Free memory
            imagedestroy($source);
            imagedestroy($thumb);

            return $thumbnailPath;
        } catch (\Exception $e) {
            \Log::error('Thumbnail creation failed: ' . $e->getMessage());
            return null;
        }
    }
}
