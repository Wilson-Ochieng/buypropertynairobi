<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'job_listing_id',
        'name',
        'email',
        'phone',
        'current_location',
        'linkedin_url',
        'cover_letter',
        'cv_path',
        'cv_original_name',
        'status',
        'admin_notes',
    ];

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function scopeNew($q)
    {
        return $q->where('status', 'new');
    }
}