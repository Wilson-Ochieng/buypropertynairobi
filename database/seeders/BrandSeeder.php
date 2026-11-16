<?php
namespace Database\Seeders;

use App\Models\GroupInfo;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        GroupInfo::updateOrCreate(['id' => 1], [
            'hero_title'          => 'Buy Property Nairobi',
            'hero_subtitle'       => 'Premium properties. Brighter futures.',
            'brand_tenet'         => 'Discover Exceptional Homes in Nairobi',
            'intro_text'          => "Buy Property Nairobi is your trusted partner for premium real estate in Nairobi's most desirable neighbourhoods. We help buyers, renters, and investors navigate the market with local expertise and personalised guidance — from Kilimani to Karen, Kileleshwa to Westlands.\n\nOur curated portfolio features apartments, villas, townhouses, and off-plan developments across Nairobi's prime residential areas. Each property is carefully presented with verified information, professional photography, and honest local advice.\n\nWhether you are buying your first home, upgrading to a family villa, or investing in rental property, our team is here to guide you from first viewing to ownership.",
            'careers_intro'       => 'Join a team passionate about Nairobi real estate. We are always looking for talented sales agents, property managers, and marketing professionals who share our commitment to quality and integrity.',
            'careers_cta_email'   => 'careers@buypropertynairobi.com',
            'registered_capital'  => 'Nairobi',
            'total_area'          => '100+ properties',
            'planned_homes'       => '100+',
            'hotels_count'        => '6',
            'founded_year'        => '2024',
            'hq_city'             => 'Nairobi',
            'origin_city'         => 'Nairobi, Kenya',
        ]);

        $this->command->info('Brand info seeded.');
    }
}