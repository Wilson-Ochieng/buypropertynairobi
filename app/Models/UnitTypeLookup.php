<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UnitTypeLookup extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (empty($m->slug)) $m->slug = Str::slug($m->name);
        });
    }

    public function unitTypes(): HasMany
    {
        return $this->hasMany(UnitType::class);
    }

    public function scopeActive($q) { return $q->where('is_active', true); }
}