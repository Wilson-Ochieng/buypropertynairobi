<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\UnitType;
use Illuminate\Database\Seeder;

class UnitTypeSeeder extends Seeder
{
    public function run(): void
    {
        $bay = Project::where('slug', 'nanchong-longines-bay')->first();
        $island = Project::where('slug', 'nanchong-longines-island')->first();

        if ($bay) {
            $bay->unitTypes()->delete();
            $bayUnits = [
                ['category' => 'commercial', 'name' => 'Retail', 'bedrooms' => null, 'price_kes' => null, 'size_min_sqm' => 27, 'size_max_sqm' => 180, 'sort_order' => 1],
                ['category' => 'residential', 'name' => 'Studio', 'bedrooms' => 0, 'price_kes' => 4_500_000, 'sort_order' => 2],
                ['category' => 'residential', 'name' => '1-Bedroom', 'bedrooms' => 1, 'price_kes' => 6_800_000, 'sort_order' => 3],
                ['category' => 'residential', 'name' => '2-Bedroom', 'bedrooms' => 2, 'price_kes' => 9_500_000, 'sort_order' => 4],
                ['category' => 'residential', 'name' => 'Duplex', 'bedrooms' => 3, 'price_kes' => 14_000_000, 'sort_order' => 5],
            ];
            foreach ($bayUnits as $u) {
                UnitType::create(array_merge($u, ['project_id' => $bay->id]));
            }
        }

        if ($island) {
            $island->unitTypes()->delete();
            $islandUnits = [
                ['category' => 'residential', 'name' => 'Studio', 'bedrooms' => 0, 'price_kes' => 5_200_000, 'sort_order' => 1],
                ['category' => 'residential', 'name' => '1-Bedroom', 'bedrooms' => 1, 'price_kes' => 7_400_000, 'sort_order' => 2],
                ['category' => 'residential', 'name' => '2-Bedroom', 'bedrooms' => 2, 'price_kes' => 10_900_000, 'sort_order' => 3],
            ];
            foreach ($islandUnits as $u) {
                UnitType::create(array_merge($u, ['project_id' => $island->id]));
            }
        }
    }
}