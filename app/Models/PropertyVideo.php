<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyVideo extends Model
{
    protected $fillable = [
        'property_id', 'type', 'title', 'video_url', 'video_id',
        'video_path', 'thumbnail_path', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public static function extractVideoId(string $url, string $type): ?string
    {
        $url = trim($url);

        if ($type === 'youtube') {
            if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url)) return $url;
            if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
                return $m[1];
            }
        }

        if ($type === 'vimeo') {
            if (preg_match('/^\d+$/', $url)) return $url;
            if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
                return $m[1];
            }
        }

        return null;
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->video_id) {
            $origin = urlencode(config('app.url'));
            return "https://www.youtube.com/embed/{$this->video_id}?autoplay=1&rel=0&modestbranding=1&origin={$origin}";
        }
        if ($this->type === 'vimeo' && $this->video_id) {
            return "https://player.vimeo.com/video/{$this->video_id}?autoplay=1";
        }
        if ($this->type === 'mp4' && $this->video_path) {
            return asset('storage/' . $this->video_path);
        }
        return null;
    }

    public function getEmbedUrlWithMuteAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->video_id) {
            $origin = urlencode(config('app.url'));
            return "https://www.youtube.com/embed/{$this->video_id}?autoplay=1&mute=1&rel=0&modestbranding=1&playsinline=1&origin={$origin}";
        }
        if ($this->type === 'vimeo' && $this->video_id) {
            return "https://player.vimeo.com/video/{$this->video_id}?autoplay=1&muted=1";
        }
        if ($this->type === 'mp4' && $this->video_path) {
            return asset('storage/' . $this->video_path);
        }
        return null;
    }

    public function getPosterUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        if ($this->type === 'youtube' && $this->video_id) {
            return "https://img.youtube.com/vi/{$this->video_id}/hqdefault.jpg";
        }
        if ($this->property?->cover_image) {
            return asset('storage/' . $this->property->cover_image);
        }
        return null;
    }
}