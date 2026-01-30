<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'price',
        'sale_price',
        'short_description',
        'content',
        'status',
        'instructor_id',
        'category_id',
    ];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_PUBLISHED = 'published';

    protected static function booted()
    {
        static::creating(function (Course $course) {
            $course->slug = static::generateUniqueSlug($course->title);
        });

        static::updating(function (Course $course) {
            if ($course->isDirty('title')) {
                $course->slug = static::generateUniqueSlug($course->title, $course->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class)->orderBy('position');
    }

    public function students()
    {
        return $this->belongsToMany(\App\Models\User::class)->withTimestamps()->withPivot('created_at');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return round($this->reviews()->avg('rating') ?? 5, 1);
    }
}
