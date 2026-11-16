<?php
namespace Database\Seeders;

use App\Models\UnitTypeLookup;
use Illuminate\Database\Seeder;

class UnitTypeLookupSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Apartment',   'slug' => 'apartment',   'sort_order' => 1, 'description' => 'Vertical residential units in multi-storey buildings.'],
            ['name' => 'Townhouse',   'slug' => 'townhouse',   'sort_order' => 2, 'description' => 'Multi-level homes sharing walls with neighbours.'],
            ['name' => 'Villa',       'slug' => 'villa',       'sort_order' => 3, 'description' => 'Standalone homes on private plots.'],
            ['name' => 'Maisonette',  'slug' => 'maisonette',  'sort_order' => 4, 'description' => 'Two-floor units in low-rise developments.'],
            ['name' => 'Studio',      'slug' => 'studio',      'sort_order' => 5, 'description' => 'Compact one-room units with kitchenette.'],
            ['name' => 'Bedsitter',   'slug' => 'bedsitter',   'sort_order' => 6, 'description' => 'Single-room units with basic amenities.'],
            ['name' => 'Retail',      'slug' => 'retail',      'sort_order' => 7, 'description' => 'Ground-floor shop or retail spaces.'],
            ['name' => 'Office',      'slug' => 'office',      'sort_order' => 8, 'description' => 'Commercial office units.'],
        ];

        foreach ($types as $t) {
            UnitTypeLookup::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}