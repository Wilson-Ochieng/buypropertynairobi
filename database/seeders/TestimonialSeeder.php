<?php
namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if empty — avoids duplicates on repeated runs
        if (Testimonial::count() > 0) {
            return;
        }

        $testimonials = [
            // 1. Featured — buying experience
            [
                'source' => 'manual',
                'author_name' => 'Grace Wanjiku',
                'author_role' => 'Homeowner · Longines Bay, Kilimani',
                'quote' => 'From the first viewing to handing over the keys, the Nanchong team was professional and transparent. The finishing in our 2-bedroom is excellent, and the location is perfect for our family. We are very happy with the purchase.',
                'rating' => 5,
                'location' => 'Kilimani',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],

            // 2. Featured — investment angle
            [
                'source' => 'google',
                'author_name' => 'David Mwangi',
                'author_role' => 'Investor · Westlands',
                'quote' => 'I have bought two units through Nanchong and both have delivered strong rental yields. The team understands what investors need — clear timelines, quality construction, and no surprises. Highly recommend for anyone looking at Nairobi property.',
                'rating' => 5,
                'location' => 'Westlands',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 2,
                'google_review_time' => now()->subDays(45),
            ],

            // 3. Expat perspective
            [
                'source' => 'manual',
                'author_name' => 'Sarah Thompson',
                'author_role' => 'Homeowner · Longines Island',
                'quote' => 'Moving to Nairobi from London, I was nervous about buying off-plan. Nanchong walked me through everything — the legal process, payment schedule, and construction progress updates. The community at Longines Island is genuinely international, which made settling in so much easier.',
                'rating' => 5,
                'location' => 'Westlands',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 3,
            ],

            // 4. Google-style — fast, specific
            [
                'source' => 'google',
                'author_name' => 'Kevin Otieno',
                'author_role' => 'Google Review',
                'quote' => 'Great communication from the sales team. They answered all my questions on WhatsApp within minutes, and the viewing was well organised. The property itself matched the photos exactly. Would work with them again.',
                'rating' => 4,
                'location' => 'Kilimani',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
                'google_review_time' => now()->subDays(12),
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }

        $this->command->info('Seeded ' . count($testimonials) . ' testimonials.');
    }
}