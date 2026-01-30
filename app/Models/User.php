<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_INSTRUCTOR = 'instructor';
    public const ROLE_STUDENT = 'student';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'otp_code',
        'otp_expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isAdmin(): bool
    {
        return $this->isRole(self::ROLE_ADMIN);
    }

    public function isInstructor(): bool
    {
        return $this->isRole(self::ROLE_INSTRUCTOR);
    }

    public function isStudent(): bool
    {
        return $this->isRole(self::ROLE_STUDENT);
    }

    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class)->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(\App\Models\Lesson::class)->withPivot('completed_at')->withTimestamps();
    }

    public function hasPurchased(\App\Models\Course $course): bool
    {
        return $this->courses()->where('course_id', $course->id)->exists();
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
