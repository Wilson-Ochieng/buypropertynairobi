<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UseCategory extends Model
{
    protected $table = 'uses';

  protected $fillable = ['name', 'slug', 'description', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'use_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
}