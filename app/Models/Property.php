<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description',
        'country_id', 'use_id',
        'category', 'purpose', 'status',
        'property_type', 'bedrooms', 'bathrooms', 'floors',
        'size_sqm', 'price_kes', 'price_negotiable',
        'location', 'city', 'address', 'latitude', 'longitude',
        'features', 'cover_image',
        'contact_email', 'whatsapp_number',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'price_negotiable' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'size_sqm' => 'decimal:2',
        'price_kes' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function booted(): void
    {
        static::creating(function (Property $property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });
    }

    // Relations
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function useCategory(): BelongsTo
    {
        return $this->belongsTo(UseCategory::class, 'use_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class)->orderBy('sort_order');
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(PropertyHighlight::class)->orderBy('sort_order');
    }

    // Scopes
    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true);
    }

    public function scopeInCountry($q, ?string $slug)
    {
        if (!$slug) return $q;
        return $q->whereHas('country', fn ($c) => $c->where('slug', $slug));
    }

    public function scopeByStatus($q, ?string $status)
    {
        if (!$status) return $q;
        return $q->where('status', $status);
    }

    public function scopeInLocation($q, ?string $location)
    {
        if (!$location) return $q;
        return $q->where('location', $location);
    }

    public function scopeByCategory($q, ?string $category)
    {
        if (!$category) return $q;
        return $q->where('category', $category);
    }

    public function scopeByPurpose($q, ?string $purpose)
    {
        if (!$purpose) return $q;
        return $q->whereIn('purpose', $purpose === 'rent' ? ['rent', 'both'] : ['sale', 'both']);
    }

    public function scopeMinBedrooms($q, ?int $n)
    {
        if (!$n) return $q;
        return $q->where('bedrooms', '>=', $n);
    }

    public function scopeMaxPrice($q, ?float $price)
    {
        if (!$price) return $q;
        return $q->where('price_kes', '<=', $price);
    }

    // Accessors
    public function getPriceLabelAttribute(): array
    {
        if (!$this->price_kes) {
            return ['label' => 'Price on request', 'has_price' => false];
        }

        $p = (float) $this->price_kes;
        $formatted = $p >= 1_000_000
            ? 'KES ' . number_format($p / 1_000_000, 1) . 'M'
            : 'KES ' . number_format($p, 0);

        return ['label' => $formatted, 'has_price' => true];
    }

    public function getWhatsAppAttribute(): string
    {
        if ($this->whatsapp_number) {
            return preg_replace('/\D/', '', $this->whatsapp_number);
        }

        $primary = SiteContact::primary();
        return $primary ? preg_replace('/\D/', '', $primary->phone ?? '254710998888') : '254710998888';
    }

    public function getWhatsAppUrlAttribute(): string
    {
        $msg = urlencode("Hi, I'm interested in {$this->title}. Could you share more details?");
        return "https://wa.me/{$this->whatsapp}?text={$msg}";
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Available',
            'sold' => 'Sold',
            'rented' => 'Rented',
            'off_plan' => 'Off-Plan',
            'under_construction' => 'Under Construction',
            default => ucfirst($this->status ?? 'Unknown'),
        };
    }
}