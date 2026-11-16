<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable = [
        'title',
        'type',
        'subtitle',
        'description',
        'cta_label',
        'cta_url',
        'benefits',
        'contact_name',
        'contact_email',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'benefits' => 'array',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
    public function scopeOfType($q, string $type)
    {
        return $q->where('type', $type);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'land' => 'Land Partnership',
            'agency' => 'Real Estate Agency',
            'freelancer' => 'Freelance Agent',
            default => ucfirst($this->type),
        };
    }
}