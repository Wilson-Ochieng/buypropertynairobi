<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'author_name',
        'excerpt',
        'body',
        'cover_image',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $post) {
            if (empty($post->slug))
                $post->slug = Str::slug($post->title);
            if (empty($post->published_at) && $post->is_published)
                $post->published_at = now();
        });
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true)
            ->where(function ($q2) {
                $q2->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}