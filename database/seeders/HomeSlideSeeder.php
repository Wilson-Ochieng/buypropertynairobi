<?php
namespace Database\Seeders;

use App\Models\HomeSlide;
use Illuminate\Database\Seeder;

class HomeSlideSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if empty so re-running doesn't create duplicates
        if (HomeSlide::count() > 0)
            return;

        HomeSlide::create([
            'type' => 'image',
            'title' => 'Nanchong Group',
            'subtitle' => 'Building homes for love, quality Nanchong',
            'cta_label' => 'Explore Our Portfolio',
            'cta_url' => '/china-portfolio',
            'image_path' => null, // placeholder background until admin uploads
            'is_active' => true,
            'sort_order' => 1,
        ]);

        HomeSlide::create([
            'type' => 'image',
            'title' => 'Nanchong in Kenya',
            'subtitle' => 'Landmark developments in Nairobi — Longines Bay and Longines Island.',
            'cta_label' => 'Discover Kenya Division',
            'cta_url' => '/kenya',
            'image_path' => null,
            'is_active' => true,
            'sort_order' => 2,
        ]);
    }
}