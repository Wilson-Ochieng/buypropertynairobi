<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\Style;
use App\Models\UnitTypeLookup;
use Illuminate\Database\Seeder;

class BpnUnitTypeSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            '2-bedroom-apartment-kileleshwa' => [
                'beds' => 2, 'baths' => 2, 'size' => 120, 'price' => 12_000_000,
                'style' => 'apartment', 'type' => 'apartment',
            ],
            '3-bedroom-luxury-apartment-kilimani' => [
                'beds' => 3, 'baths' => 3, 'size' => 160, 'price' => 18_500_000,
                'style' => 'apartment', 'type' => 'apartment',
            ],
            '4-bedroom-villa-karen' => [
                'beds' => 4, 'baths' => 5, 'size' => 450, 'price' => 85_000_000,
                'style' => 'villa', 'type' => 'villa',
            ],
            '1-bedroom-investment-apartment-westlands' => [
                'beds' => 1, 'baths' => 1, 'size' => 55, 'price' => 7_500_000,
                'style' => 'apartment', 'type' => 'apartment',
            ],
            '4-bedroom-townhouse-lavington' => [
                'beds' => 4, 'baths' => 4, 'size' => 300, 'price' => 39_000_000,
                'style' => 'townhouse', 'type' => 'townhouse',
            ],
            'luxury-penthouse-riverside' => [
                'beds' => 4, 'baths' => 4, 'size' => 400, 'price' => 68_000_000,
                'style' => 'penthouse', 'type' => 'apartment',
            ],
        ];

        foreach ($map as $slug => $u) {
            $project = Project::where('slug', $slug)->first();
            if (!$project) {
                $this->command->warn("Project {$slug} not found, skipping.");
                continue;
            }

            $style = Style::where('slug', $u['style'])->first();
            $type  = UnitTypeLookup::where('slug', $u['type'])->first();

            // Clean up any existing units for this project (safe for re-runs)
            $project->unitTypes()->delete();

            $project->unitTypes()->create([
                'unit_type_lookup_id' => $type?->id,
                'category'   => 'residential',
                'purpose'    => 'sale',
                'name'       => $u['beds'] . ' Bedroom',
                'bedrooms'   => $u['beds'],
                'style_id'   => $style?->id,
                'size_min_sqm' => $u['size'],
                'size_max_sqm' => $u['size'],
                'price_kes'  => $u['price'],
                'features'   => [
                    'Ensuite bathroom',
                    'Built-in wardrobes',
                    'Modern kitchen',
                    'Balcony',
                ],
                'sort_order' => 1,
            ]);
        }

        $this->command->info('Seeded unit types for Buy Property Nairobi.');
    }
}