<?php

namespace Database\Seeders;

use App\Models\GroupInfo;
use Illuminate\Database\Seeder;

class GroupInfoSeeder extends Seeder
{
    public function run(): void
    {
        GroupInfo::updateOrCreate(['id' => 1], [
            'hero_title' => 'Buy Property Nairobi',
            'hero_subtitle' => 'Premium properties. Trusted expertise. Brighter futures.',
            'brand_tenet' => 'Premium properties. Trusted expertise. Brighter futures.',

            'intro_text' => 'Buy Property Nairobi is a team of property specialists helping buyers, tenants and investors find premium homes and new developments across Nairobi, including Kilimani, Kileleshwa, Westlands and Karen.

We cover property sales, rentals and investments, and we guide every client from the first conversation to the day they get the keys. Our approach is simple: honest advice, clear information and local expertise you can trust.

Whether you are buying your first home, looking for the right rental or building an investment portfolio, we are here to help you make confident decisions and secure a brighter future.',

            // Previous group-level stats removed. Set to null so old values are cleared.
            'registered_capital' => null,
            'total_area' => null,
            'planned_homes' => null,
            'hotels_count' => null,
            'founded_year' => null,
            'hq_city' => 'Nairobi, Kenya',
            'origin_city' => null,
        ]);
    }
}
