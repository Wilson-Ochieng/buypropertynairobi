<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContact extends Model
{
    protected $fillable = ['name', 'role', 'phone', 'email', 'is_primary'];

    protected $casts = ['is_primary' => 'boolean'];

    public static function primary(): ?self
    {
        return static::where('is_primary', true)->first() ?? static::first();
    }
}