<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryPage extends Model
{
    protected $fillable = [
        'slug',
        'purpose',
        'category_type',
        'filter_value',
        'bedrooms',
        'h1',
        'description',
        'hero_image',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    protected $casts = ['is_published' => 'boolean', 'bedrooms' => 'integer'];

    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (empty($m->slug))
                $m->slug = Str::slug($m->h1);
        });
    }

    public function getBedroomsLabelAttribute(): ?string
    {
        return match ($this->bedrooms) {
            0 => 'Studio',
            1 => '1 Bedroom',
            2 => '2 Bedrooms',
            3 => '3 Bedrooms',
            4 => '4+ Bedrooms',
            default => null,
        };
    }

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }
}