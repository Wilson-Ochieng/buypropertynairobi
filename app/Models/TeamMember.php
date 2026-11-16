<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'type',
        'name',
        'role',
        'bio',
        'photo',
        'linkedin_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
    public function scopeBoard($q)
    {
        return $q->where('type', 'board');
    }
    public function scopeManagement($q)
    {
        return $q->where('type', 'management');
    }
}