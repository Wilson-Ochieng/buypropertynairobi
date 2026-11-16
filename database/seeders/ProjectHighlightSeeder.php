<?php
namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectHighlight;
use Illuminate\Database\Seeder;

class ProjectHighlightSeeder extends Seeder
{
    public function run(): void
    {
        $highlights = [
            'nanchong-longines-bay' => [
                'International community — people from different countries',
                'Retail spaces 27–180 m²',
                'Studio to Duplex residences',
                'Kilimani, off Ngong Road',
            ],
            'nanchong-longines-island' => [
                'Studio, 1-Bedroom & 2-Bedroom',
                'Westlands Avenue, off Sports Road',
                'Prime Nairobi location',
            ],
            'nanchong-hongcheng-road-community' => [
                '380 m from the subway station',
                'Third Nanchong project in Nanchang',
            ],
            'nanchong-bayi-square-residences' => [
                '400 m from Bayi Square',
                '3 luxury shopping malls nearby',
                'Only 70 prized homes',
            ],
            'nanchong-subway-education-community' => [
                'Subway and school very close',
                'New Asian + national-style garden',
                '6 high-rise buildings',
            ],
            'nanchong-fuzhou-park-community' => [
                'Park ecological community',
                '6 high-rises, 2 small high-rises, 10 villas',
                '6-class community kindergarten',
            ],
            'nanchong-chongren-baoshui-community' => [
                'Next to Chongren No.1 Middle School',
                'Hospitals, schools, malls, parks nearby',
            ],
            'liuyang-full-business-urban-complex' => [
                '5A office building',
                'Five-star hotel',
                '1.24 million m² construction area',
            ],
        ];

        foreach ($highlights as $slug => $labels) {
            $project = Project::where('slug', $slug)->first();
            if (!$project)
                continue;

            $project->highlights()->delete();
            foreach ($labels as $i => $label) {
                ProjectHighlight::create([
                    'project_id' => $project->id,
                    'label' => $label,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}