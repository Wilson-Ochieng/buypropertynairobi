<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'flag_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Country $country) {
            if (empty($country->slug)) {
                $country->slug = Str::slug($country->name);
            }
        });
    }

    // ───────── Relations ─────────

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // ───────── Scopes ─────────

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    // ───────── Accessors ─────────

    /** Distinct locations of projects in this country */
    public function getLocationsAttribute(): array
    {
        return $this->projects()
            ->whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }
}