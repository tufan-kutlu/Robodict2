<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Robot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'specifications',
        'personality_traits',
        'image_url',
        'status',
        'is_featured',
        'view_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'specifications' => 'array',
        'personality_traits' => 'array',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
    ];

    /**
     * Get the robots that are active.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get featured robots.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
