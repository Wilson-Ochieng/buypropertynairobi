<?php
namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'nanchong-longines-bay' => [
                'Swimming pool',
                'Gym & fitness centre',
                '24/7 security',
                'Covered parking',
                'Backup generator',
                'Borehole water',
                'Retail arcade',
                'Kids play area',
            ],
            'nanchong-longines-island' => [
                'Swimming pool',
                'Gym',
                '24/7 security',
                'High-speed lifts',
                'Covered parking',
                'Backup generator',
            ],
        ];

        foreach ($features as $slug => $list) {
            Project::where('slug', $slug)->update([
                'features' => $list,
                'whatsapp_number' => '254710998888',
                'latitude' => null,
                'longitude' => null,
            ]);
        }
    }
}