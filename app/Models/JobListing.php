<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JobListing extends Model
{
    protected $fillable = [
        'title', 'slug', 'department', 'location', 'employment_type',
        'summary', 'description', 'requirements', 'salary_range',
        'contact_email', 'expires_at', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'expires_at' => 'date',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $job) {
            if (empty($job->slug)) {
                $job->slug = Str::slug($job->title);
            }
        });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true)
                 ->where(function ($q2) {
                     $q2->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', today());
                 });
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}