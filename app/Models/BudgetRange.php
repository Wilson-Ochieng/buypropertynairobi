<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRange extends Model
{
    protected $fillable = ['purpose', 'label', 'description', 'min_value', 'max_value', 'sort_order', 'is_active'];
    protected $casts = [
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }
    public function scopeForPurpose($q, string $purpose)
    {
        return $q->where('purpose', $purpose);
    }
}