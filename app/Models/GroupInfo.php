<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupInfo extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'intro_text',
        'careers_intro',
        'careers_advert_image',
        'careers_advert_url',
        'careers_cta_email',
        'brand_tenet',
        'registered_capital',
        'total_area',
        'planned_homes',
        'hotels_count',
        'founded_year',
        'hq_city',
        'origin_city',
    ];

    // Convenience: always fetch the single record
    public static function current(): ?self
    {
        return static::first();
    }
}