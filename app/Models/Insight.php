<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Insight extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'location',
        'summary',
        'body',
        'cover_image',
        'meta_title',
        'meta_description',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Insight $insight) {
            if (empty($insight->slug)) {
                $insight->slug = Str::slug($insight->title);
            }
        });
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    /** Projects whose 'location' matches this insight's location */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'location', 'location');
    }

    public function scopeAreaGuides($q)
    {
        return $q->where('category', 'area_guide');
    }
    public function scopeMarketInsights($q)
    {
        return $q->where('category', 'market');
    }
}