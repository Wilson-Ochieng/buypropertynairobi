<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $fillable = [
        'source',
        'author_name',
        'author_role',
        'author_photo',
        'quote',
        'rating',
        'location',
        'project_id',
        'google_review_id',
        'google_author_url',
        'google_profile_photo_url',
        'google_review_time',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'rating' => 'integer',
        'sort_order' => 'integer',
        'google_review_time' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }
    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true);
    }
    public function scopeManual($q)
    {
        return $q->where('source', 'manual');
    }
    public function scopeGoogle($q)
    {
        return $q->where('source', 'google');
    }

    public function getStarsAttribute(): string
    {
        $rating = $this->rating ?? 0;
        return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
    }
}