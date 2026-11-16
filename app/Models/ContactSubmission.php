<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'source',
        'status',
        'contacted_at',
        'admin_notes',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];
}