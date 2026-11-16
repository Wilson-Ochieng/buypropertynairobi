<?php
namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Post;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        // Board + Management
        TeamMember::updateOrCreate(['name' => 'Chairman, Nanchong Group'], [
            'type' => 'board',
            'role' => 'Chairman',
            'sort_order' => 1,
            'is_active' => true,
            'bio' => 'Chairman of Nanchong Group since its founding in 2010. Guiding the group through 15 years of growth across five business sectors.',
        ]);
        TeamMember::updateOrCreate(['name' => 'Managing Director'], [
            'type' => 'management',
            'role' => 'Managing Director',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Blog
        Post::updateOrCreate(['slug' => 'nanchong-kenya-expansion'], [
            'title' => 'Nanchong Group Expands into Kenya',
            'category' => 'News',
            'excerpt' => 'Nanchong Group brings its decade-long track record of building quality homes to Nairobi.',
            'body' => '<p>Nanchong Group is proud to announce its Kenya Division, launching with two landmark projects in Nairobi — Longines Bay in Kilimani and Longines Island in Westlands.</p>',
            'is_published' => true,
            'published_at' => now()->subDays(10),
        ]);

        // FAQs
        $faqs = [
            ['category' => 'Buying', 'question' => 'How do I purchase a property?', 'answer' => '<p>Get in touch with our sales team via WhatsApp or email. We will guide you through the process from viewing to handover.</p>', 'sort_order' => 1],
            ['category' => 'Buying', 'question' => 'Do you offer financing?', 'answer' => '<p>We partner with leading banks and mortgage providers to offer flexible payment plans.</p>', 'sort_order' => 2],
            ['category' => 'Construction', 'question' => 'How long does construction take?', 'answer' => '<p>Typical projects run 24–36 months from ground-breaking to handover, depending on scope.</p>', 'sort_order' => 3],
            ['category' => 'Payments', 'question' => 'What payment methods do you accept?', 'answer' => '<p>We accept bank transfers, mortgage financing, and staged payment plans.</p>', 'sort_order' => 4],
            ['category' => 'General', 'question' => 'Where are your offices located?', 'answer' => '<p>Our headquarters is in Nanchang, China. Our Kenya Division is based in Nairobi.</p>', 'sort_order' => 5],
        ];
        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question' => $f['question']], array_merge($f, ['is_published' => true]));
        }
    }
}