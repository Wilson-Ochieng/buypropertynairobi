<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    protected $fillable = [
        'type',
        'title',
        'subtitle',
        'cta_label',
        'cta_url',
        'image_path',
        'video_url',
        'video_id',
        'poster_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    /**
     * Extract the video ID from a YouTube / Vimeo URL.
     * Supports youtube.com/watch?v=, youtu.be/, /embed/, vimeo.com/{id}, player.vimeo.com/video/{id}.
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
}