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
        'user_id',
        'name',
        'slug',
        'locale',
        'description',
        'specifications',
        'personality_traits',
        'image_url',
        'status',
        'is_featured',
        'view_count',
        'created_by_admin_at',
        'created_by_admin_id',
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
        'created_by_admin_at' => 'datetime',
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

    /**
     * Scope: Filter by locale
     */
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Relationship: Robot belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Robot created by admin
     */
    public function createdByAdmin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    /**
     * Check if robot was created by admin
     */
    public function isAdminCreated(): bool
    {
        return !is_null($this->created_by_admin_at);
    }

    /**
     * Get robot owner name
     */
    public function getOwnerNameAttribute(): string
    {
        return $this->user ? $this->user->name : 'System';
    }
}
