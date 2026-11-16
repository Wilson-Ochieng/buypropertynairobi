<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectVideo extends Model
{
    protected $fillable = [
        'project_id',
        'type',
        'title',
        'video_url',
        'video_id',
        'video_path',
        'thumbnail_path',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    /**
     * Extract video ID from YouTube or Vimeo URL.
     */
    public static function extractVideoId(string $url, string $type): ?string
    {
        if ($type === 'youtube') {
            if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
                return $m[1];
            }
        }

        if ($type === 'vimeo') {
            if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
                return $m[1];
            }
        }

        return null;
    }

    /** Public-facing embed URL (returns iframe src). */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->video_id) {
            $origin = urlencode(config('app.url') ?? request()->getSchemeAndHttpHost());
            return "https://www.youtube.com/embed/{$this->video_id}"
                . "?autoplay=1&rel=0&modestbranding=1"
                . "&origin={$origin}"
                . "&enablejsapi=0";
        }
        if ($this->type === 'vimeo' && $this->video_id) {
            return "https://player.vimeo.com/video/{$this->video_id}?autoplay=1";
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
        if ($this->project?->cover_image) {
            return asset('storage/' . $this->project->cover_image);
        }
        return null;
    }
}