<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'country_id',
        'location',
        'city',
        'status',
        'use_id',
        'address',
        'description',
        'investment',
        'land_area',
        'construction_area',
        'unit_count',
        'distance_subway',
        'is_featured',
        'features',
        'whatsapp_number',
        'latitude',
        'longitude',
        'contact_email',
        'cover_image',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'features' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->name);
            }
        });
    }

    // ───────── Relations ─────────

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function unitTypes(): HasMany
    {
        return $this->hasMany(UnitType::class)->orderBy('sort_order');
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(ProjectHighlight::class)->orderBy('sort_order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
    public function useCategory(): BelongsTo
    {
        return $this->belongsTo(UseCategory::class, 'use_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProjectVideo::class)->orderBy('sort_order');
    }

    // ───────── Scopes ─────────
    public function scopeByStatus($q, ?string $status)
    {
        if (!$status)
            return $q;
        return $q->where('status', $status);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'off_plan' => 'Off-Plan',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }
    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true);
    }

    /** Match projects whose country matches the given slug ('kenya', 'china', etc.) */
    public function scopeInCountry($q, ?string $slug)
    {
        if (!$slug)
            return $q;
        return $q->whereHas('country', fn($c) => $c->where('slug', $slug));
    }

    public function scopeInLocation($q, ?string $location)
    {
        if (!$location)
            return $q;
        return $q->where('location', $location);
    }

    public function scopeByType($q, ?string $type)
    {
        if (!$type)
            return $q;
        return $q->whereHas('unitTypes', fn($u) => $u->where('category', $type));
    }

    public function scopeMinBedrooms($q, ?int $bedrooms)
    {
        if (!$bedrooms)
            return $q;
        return $q->whereHas('unitTypes', fn($u) => $u->where('bedrooms', '>=', $bedrooms));
    }

    public function scopeMaxPrice($q, ?float $price)
    {
        if (!$price)
            return $q;
        return $q->whereHas('unitTypes', fn($u) => $u->where('price_kes', '<=', $price));
    }
    public function getWhatsAppAttribute(): string
    {
        if ($this->whatsapp_number) {
            return preg_replace('/\D/', '', $this->whatsapp_number);
        }

        $primary = \App\Models\SiteContact::primary();
        return $primary ? preg_replace('/\D/', '', $primary->phone ?? '254710998888') : '254710998888';
    }
    public function getPriceSummaryAttribute(): array
    {
        $salePrices = $this->unitTypes
            ->filter(fn($u) => in_array($u->purpose, ['sale', 'both']) && $u->price_kes > 0)
            ->pluck('price_kes')
            ->map(fn($p) => (float) $p)
            ->sort()
            ->values();

        if ($salePrices->isEmpty()) {
            return [
                'label' => 'Price on request',
                'has_price' => false,
                'min' => null,
                'max' => null,
            ];
        }

        $min = $salePrices->first();
        $max = $salePrices->last();

        $format = fn($n) => $n >= 1_000_000
            ? 'KES ' . number_format($n / 1_000_000, $min >= 10_000_000 ? 0 : 1) . 'M'
            : 'KES ' . number_format($n, 0);

        $label = $min === $max
            ? $format($min)
            : $format($min) . ' – ' . $format($max);

        return [
            'label' => $label,
            'has_price' => true,
            'min' => $min,
            'max' => $max,
        ];
    }

    public function getWhatsAppUrlAttribute(): string
    {
        $msg = urlencode("Hi, I'm interested in {$this->name}. Could you share more details?");
        return "https://wa.me/{$this->whatsapp}?text={$msg}";
    }

    public function getWhatsAppEnquiryUrlAttribute(string $customMessage = ''): string
    {
        $msg = $customMessage ?: "Hi, I'm interested in {$this->name}. Could you share more details?";
        return "https://wa.me/{$this->whatsapp}?text=" . urlencode($msg);
    }
}