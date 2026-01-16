<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'thumbnail',
        'regular_price',
        'sale_price',
        'quantity',
        'description',
        'content',
        'status',
        'published_at',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        return "https://placehold.co/600x400?text=" . urlencode($this->name);
    }
}
