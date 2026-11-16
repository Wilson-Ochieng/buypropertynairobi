<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitType extends Model
{
    protected $fillable = [
        'project_id',
        'unit_type_lookup_id',
        'category',
        'purpose',
        'name',
        'slug',
        'bedrooms',
        'style_id',
        'size_min_sqm',
        'size_max_sqm',
        'price_kes',
        'price_negotiable',
        'features',
        'sort_order',
    ];

    protected $casts = [
        'size_min_sqm' => 'decimal:2',
        'size_max_sqm' => 'decimal:2',
        'price_kes' => 'decimal:2',
        'price_negotiable' => 'boolean',
        'bedrooms' => 'integer',
        'features' => 'array',
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    public function unitTypeLookup(): BelongsTo
    {
        return $this->belongsTo(UnitTypeLookup::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(UnitTypeImage::class)->orderBy('sort_order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(UnitTypeVideo::class)->orderBy('sort_order');
    }


    protected static function booted(): void
    {
        static::saving(function (UnitType $unit) {
            if (empty($unit->slug)) {
                $unit->slug = static::generateUniqueSlug($unit);
            }
        });
    }

    public static function generateUniqueSlug(UnitType $unit): string
    {
        $base = \Illuminate\Support\Str::slug($unit->name);
        $project = $unit->project;

        // Append project name for disambiguation
        if ($project) {
            $base .= '-' . \Illuminate\Support\Str::slug($project->name);
        }

        // Ensure uniqueness — append a counter if needed
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->where('id', '!=', $unit->id ?? 0)
                ->exists()
        ) {
            $counter++;
            $slug = $base . '-' . $counter;
        }

        return $slug;
    }

    // ───────── Scopes ─────────


    public function scopeForSale($q)
    {
        return $q->whereIn('purpose', ['sale', 'both']);
    }
    public function scopeForRent($q)
    {
        return $q->whereIn('purpose', ['rent', 'both']);
    }
}