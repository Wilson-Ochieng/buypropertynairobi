<?php
namespace Database\Seeders;

use App\Models\Subsidiary;
use Illuminate\Database\Seeder;

class SubsidiarySeeder extends Seeder
{
    public function run(): void
    {
        $subs = [
            [
                'name' => 'Jiangxi Tianying Construction Co., Ltd.',
                'qualification' => 'First-class qualification',
                'description' => 'Construction arm of the Nanchong Group, delivering high-quality residential and commercial developments.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Jiangxi Nanchong Property Management Co., Ltd.',
                'qualification' => 'Jinkey-6S service enterprise',
                'description' => 'Property management division providing premium residential and commercial services.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Jiangxi Nanchong Landscape Engineering Co., Ltd.',
                'qualification' => null,
                'description' => 'Landscape engineering division responsible for gardens and outdoor environments across Nanchong developments.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Jiangxi Chongrui Marketing Management Co., Ltd.',
                'qualification' => null,
                'description' => 'Marketing and sales management arm supporting all Nanchong Group projects.',
                'sort_order' => 4,
            ],
        ];

        foreach ($subs as $sub) {
            Subsidiary::updateOrCreate(['name' => $sub['name']], $sub);
        }
    }
}