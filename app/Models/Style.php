<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Style extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'show_in_type', 'sort_order', 'is_active'];
    protected $casts = ['show_in_type' => 'boolean', 'is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function unitTypes(): HasMany
    {
        return $this->hasMany(UnitType::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
    public function scopeInTypeColumn($q)
    {
        return $q->where('show_in_type', true);
    }
}