<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $fillable = ['name', 'qualification', 'description', 'logo', 'sort_order'];
}