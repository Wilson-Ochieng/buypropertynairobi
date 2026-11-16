<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KenyaDivisionPage extends Model
{
    protected $fillable = ['intro_text', 'hero_image'];

    public static function current(): ?self
    {
        return static::first();
    }
}