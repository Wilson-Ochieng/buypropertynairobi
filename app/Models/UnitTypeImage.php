<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitTypeImage extends Model
{
    protected $fillable = ['unit_type_id', 'path', 'sort_order'];

    protected $casts = ['sort_order' => 'integer'];

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(UnitType::class);
    }
}