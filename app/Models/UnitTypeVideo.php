<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitTypeVideo extends Model
{
    protected $fillable = [
        'unit_type_id',
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

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->type === 'youtube' && $this->video_id) {
            $origin = urlencode(config('app.url') ?? request()->getSchemeAndHttpHost());
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

    public function getPosterUrlAttribute(): ?string
    {
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        if ($this->type === 'youtube' && $this->video_id) {
            return "https://img.youtube.com/vi/{$this->video_id}/hqdefault.jpg";
        }
        if ($this->unitType?->images?->first()) {
            return asset('storage/' . $this->unitType->images->first()->path);
        }
        return null;
    }
}