<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'thumbnail',
        'images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Delete images when product is deleted
        static::deleting(function ($product) {
            // Delete original and thumbnail images
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            
            // Delete all multiple images and their thumbnails
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
        });
    }
}
