<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

// Copy test images to a temporary directory
$testDir = storage_path('temp-test');
if (!is_dir($testDir)) {
    mkdir($testDir, 0755, true);
}

// Copy test images
for ($i = 1; $i <= 3; $i++) {
    copy(base_path("test-image-$i.png"), "$testDir/test-image-$i.png");
}

// Get the controller
$controller = new \App\Http\Controllers\ProductController();

// Create a fake request with multiple image files
$request = new \Illuminate\Http\Request();
$request->merge([
    'title' => 'Multiple Image Test',
    'description' => 'This product has multiple images',
    'price' => '49.99'
]);

// Create UploadedFile instances from our test images
$files = [];
for ($i = 1; $i <= 3; $i++) {
    $filePath = "$testDir/test-image-$i.png";
    $file = new UploadedFile(
        $filePath,
        "test-image-$i.png",
        'image/png',
        null,
        true // test flag
    );
    $files[] = $file;
}

// Set the files in the request
$request->files->set('images', $files);

// Validate
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'price' => 'required|numeric|min:0',
    'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
]);

// Store the product
$product = new Product();
$product->title = $request->title;
$product->description = $request->description;
$product->price = $request->price;

if ($request->hasFile('images')) {
    $images = $request->file('images');
    $slug = \Illuminate\Support\Str::slug($request->title);
    $timestamp = time();
    $imageArray = [];

    foreach ($images as $index => $image) {
        if (!$image->isValid()) {
            continue;
        }

        $extension = $image->getClientOriginalExtension();
        $uniqueFilename = $slug . '-' . $timestamp . '-' . ($index + 1) . '.' . $extension;

        $imagePath = $image->storeAs('uploads', $uniqueFilename, 'public');
        
        // Call the private method via reflection
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('createThumbnail');
        $method->setAccessible(true);
        $thumbnailPath = $method->invoke($controller, $image, $slug, $timestamp, $index + 1, $extension);

        $imageArray[] = [
            'original' => $imagePath,
            'thumbnail' => $thumbnailPath
        ];

        if ($index === 0) {
            $product->image = $imagePath;
            $product->thumbnail = $thumbnailPath;
        }
    }

    if (!empty($imageArray)) {
        $product->images = $imageArray;
    }
}

$product->save();

// Clean up test files
array_map('unlink', glob("$testDir/*.*"));
rmdir($testDir);

echo "✅ Product created successfully!\n";
echo "Product ID: " . $product->id . "\n";
echo "Title: " . $product->title . "\n";
echo "Images count: " . count($product->images) . "\n";
echo "\nImages stored:\n";
foreach ($product->images as $img) {
    echo "  - Original: " . $img['original'] . "\n";
    echo "  - Thumbnail: " . $img['thumbnail'] . "\n";
}
