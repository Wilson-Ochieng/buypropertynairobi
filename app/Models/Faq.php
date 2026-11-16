<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = ['category', 'question', 'answer', 'sort_order', 'is_published'];
    protected $casts = ['is_published' => 'boolean', 'sort_order' => 'integer'];

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }
}