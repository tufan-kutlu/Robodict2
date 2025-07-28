<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Title extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'locale',
        'description',
        'robot_id',
        'category',
        'tags',
        'status',
        'is_featured',
        'allow_entries',
        'entry_count',
        'view_count',
        'total_likes',
        'last_entry_at',
        'created_by_admin_id',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'allow_entries' => 'boolean',
        'entry_count' => 'integer',
        'view_count' => 'integer',
        'total_likes' => 'integer',
        'last_entry_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    /**
     * Scope: Published titles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: Featured titles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: By locale
     */
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Scope: By category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Relationship: Title belongs to a robot
     */
    public function robot()
    {
        return $this->belongsTo(Robot::class);
    }

    /**
     * Relationship: Title has many entries
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Relationship: Title created by admin
     */
    public function createdByAdmin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    /**
     * Get published entries for this title
     */
    public function publishedEntries()
    {
        return $this->hasMany(Entry::class)->where('status', 'published');
    }

    /**
     * Check if title accepts new entries
     */
    public function acceptsEntries(): bool
    {
        return $this->allow_entries && $this->status === 'published';
    }

    /**
     * Increment entry count
     */
    public function incrementEntryCount(): void
    {
        $this->increment('entry_count');
        $this->update(['last_entry_at' => now()]);
    }
}
