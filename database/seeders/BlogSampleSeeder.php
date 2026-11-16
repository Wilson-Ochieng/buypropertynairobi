<?php
namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSampleSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'      => 'Nanchong Group Expands into Kenya',
                'slug'       => 'nanchong-group-expands-into-kenya',
                'category'   => 'News',
                'author_name'=> 'Nanchong Group',
                'excerpt'    => 'Nanchong Group brings its decade-long track record of building quality homes to Nairobi — launching with two landmark projects in Kilimani and Westlands.',
                'body'       => '<p>We are proud to announce the launch of Nanchong Group\'s Kenya Division, marking the group\'s first major expansion outside of China.</p>
<p>The Kenya Division launches with two flagship projects:</p>
<ul>
<li><strong>Longines Bay</strong> in Kilimani — a mixed-use development offering studios, 1-, 2-bedroom and duplex units, plus retail spaces from 27 to 180 square metres.</li>
<li><strong>Longines Island</strong> in Westlands — a boutique residential development offering studios, 1- and 2-bedroom units.</li>
</ul>
<h3>Why Kenya?</h3>
<p>Kenya\'s property market has shown consistent growth over the past decade, driven by a rising middle class, demand from returning diaspora, and strong interest from international investors. The country\'s stable legal system, transparent land registry, and international business environment make it a natural next market for Nanchong Group.</p>
<h3>What makes us different</h3>
<p>Nanchong Group brings over 15 years of development experience from China — five integrated business sectors, a first-class construction subsidiary, Jinkey-6S certified property management, and a track record of delivering quality projects on time and on budget.</p>
<p>Our Kenya projects are built to the same international standards as our China portfolio, tailored to Nairobi\'s climate, culture, and lifestyle.</p>
<h3>What\'s next</h3>
<p>Both projects are underway. For project updates, pricing, and viewings, reach out to our Kenya team via WhatsApp or email.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(14),
                'sort_order'   => 1,
            ],
            [
                'title'      => 'What to Look for When Buying Off-Plan in Nairobi',
                'slug'       => 'buying-off-plan-nairobi',
                'category'   => 'Buying Guide',
                'author_name'=> 'Nanchong Group',
                'excerpt'    => 'Off-plan purchases can offer significant value — but they carry risks too. Here\'s how to protect yourself.',
                'body'       => '<p>Off-plan property — buying a unit before the building is complete — has become increasingly popular in Nairobi, especially for buyers looking at prime residential projects. Prices are typically 10–20% lower than completed units, and buyers get first pick of the best layouts.</p>
<p>But off-plan carries risks that completed purchases don\'t. Here\'s what to check before you commit.</p>
<h3>1. Developer track record</h3>
<p>Has the developer completed projects before? Can you visit them? Speak to previous buyers? A developer with a strong track record of on-time delivery is the single best protection.</p>
<h3>2. Construction timeline</h3>
<p>Ask for a detailed construction schedule with milestones — not just a handover date. Reputable developers can show you current progress and provide independent verification.</p>
<h3>3. Payment structure</h3>
<p>Most off-plan purchases involve a deposit followed by staged payments as construction milestones are hit. Never pay the full amount upfront. Insist on a schedule tied to visible progress.</p>
<h3>4. Escrow or secured accounts</h3>
<p>Where possible, insist on payment through an escrow account or a bank-guaranteed arrangement. This protects your money if the project stalls.</p>
<h3>5. Legal due diligence</h3>
<p>Verify the developer owns the land, that building approvals are in place, and that the project has a valid title. Your lawyer should handle this — don\'t skip it.</p>
<h3>6. Exit clauses</h3>
<p>What happens if you need to sell before completion? Are transfers permitted? At what cost? Understand the resale terms before signing.</p>
<h3>The bottom line</h3>
<p>Off-plan can be an excellent purchase — but only with a trustworthy developer and a solid legal process. At Nanchong Group, we provide full transparency on every off-plan project: construction timelines, payment schedules, and independent verification on request.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'sort_order'   => 2,
            ],
            [
                'title'      => 'Kilimani vs Westlands — Which Neighbourhood Is Right for You?',
                'slug'       => 'kilimani-vs-westlands',
                'category'   => 'Neighbourhood',
                'author_name'=> 'Nanchong Group',
                'excerpt'    => 'Two of Nairobi\'s most popular residential areas. Which one matches your lifestyle, budget, and investment goals?',
                'body'       => '<p>Both Kilimani and Westlands are among Nairobi\'s top residential choices — but they attract different buyers and offer different lifestyles. Here\'s how they compare.</p>
<h3>Kilimani — for quiet, community living</h3>
<p>Kilimani has a more residential feel. Streets are leafier, developments are typically mid-rise, and the neighbourhood has a strong community vibe — especially in the international community around Ngong Road.</p>
<ul>
<li><strong>Best for:</strong> Families, long-term owner-occupiers, international residents who value quiet streets</li>
<li><strong>Price range:</strong> Studios from KES 4.5M, 2-bedrooms from KES 9M</li>
<li><strong>Rental yields:</strong> 6–7%</li>
<li><strong>Schools nearby:</strong> Braeburn, Hillcrest, Brookhouse</li>
</ul>
<h3>Westlands — for convenience and buzz</h3>
<p>Westlands is Nairobi\'s commercial and lifestyle hub. Malls, restaurants, offices, and nightlife are all within walking distance. Developments tend to be taller and more amenitised.</p>
<ul>
<li><strong>Best for:</strong> Young professionals, expats, investors targeting rental income</li>
<li><strong>Price range:</strong> Studios from KES 5M, 2-bedrooms from KES 10M</li>
<li><strong>Rental yields:</strong> 7–8%</li>
<li><strong>Lifestyle:</strong> Walking distance to Sarit, Westgate, The Hub</li>
</ul>
<h3>Which should you choose?</h3>
<p>If you\'re buying for your family to live in — Kilimani. If you\'re buying for investment or for a busy professional lifestyle — Westlands. If you can\'t decide, consider buying one of each — a home in Kilimani and an investment unit in Westlands.</p>
<h3>Our projects in both</h3>
<p>Nanchong Group has a project in each neighbourhood: <strong>Longines Bay</strong> in Kilimani and <strong>Longines Island</strong> in Westlands. Both are designed to international standards, with premium finishes and amenities.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'sort_order'   => 3,
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info('Processed ' . count($posts) . ' blog posts (existing ones skipped).');
    }
}