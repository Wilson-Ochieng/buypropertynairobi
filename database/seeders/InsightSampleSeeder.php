<?php
namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightSampleSeeder extends Seeder
{
    public function run(): void
    {
        $insights = [
            // ──────────── AREA GUIDE (new) ────────────
            [
                'title'      => 'Living in Lavington — A Buyer\'s Guide',
                'slug'       => 'living-in-lavington',
                'category'   => 'area_guide',
                'location'   => 'Lavington',
                'summary'    => 'Quiet, green, and family-friendly — Lavington is Nairobi\'s premium residential enclave.',
                'body'       => '<p>Lavington is one of Nairobi\'s most established residential neighbourhoods — leafy, quiet, and favoured by families and senior professionals.</p>
<p>The area has a distinctly suburban feel while still being close to the city. Large plots, mature trees, and a slower pace of life are the defining features.</p>
<h3>What to know before buying</h3>
<ul>
<li><strong>Family-friendly</strong> — many international schools within a 10-minute drive.</li>
<li><strong>Larger plots</strong> — detached homes and townhouses dominate.</li>
<li><strong>Security</strong> — most homes are within gated compounds or estates.</li>
<li><strong>Higher price point</strong> — expect to pay more per square metre than nearby areas.</li>
</ul>
<h3>What you can expect to spend</h3>
<p>Townhouses from KES 25M, standalone homes from KES 40M. Prime plots command premiums.</p>',
                'is_published' => true,
                'sort_order'   => 3,
            ],

            // ──────────── MARKET INSIGHTS (new) ────────────
            [
                'title'      => 'Nairobi Property Market — Q4 2025 Report',
                'slug'       => 'nairobi-market-q4-2025',
                'category'   => 'market',
                'location'   => 'Nairobi',
                'summary'    => 'A quarter of steady demand, tightening supply, and rising yields across Nairobi\'s prime residential sub-markets.',
                'body'       => '<p>The Nairobi residential market closed Q4 2025 with continued momentum — driven by demand from returning diaspora, expats, and a resilient local buyer base.</p>
<h3>Key trends</h3>
<ul>
<li><strong>Prime residential prices</strong> rose 3.2% year-on-year in Kilimani, Westlands, and Lavington.</li>
<li><strong>Rental yields</strong> held steady at 6-8% in the mid-market segment.</li>
<li><strong>New completions</strong> slowed — the pipeline for 2026 is thinner than 2024/2025.</li>
<li><strong>Diaspora buyers</strong> now represent an estimated 25-30% of prime residential transactions.</li>
</ul>
<h3>What this means for buyers</h3>
<p>With fewer new completions in the pipeline, competition for well-located units is likely to intensify. Buyers who lock in pricing now in projects that will complete in the next 12-18 months are positioning themselves well.</p>
<h3>What this means for sellers</h3>
<p>If you have a well-maintained unit in a prime location, demand is strong. Expect prices to hold, and in some cases rise, over the next 2-3 quarters.</p>',
                'is_published' => true,
                'sort_order'   => 4,
            ],
            [
                'title'      => 'Why Diaspora Buyers Are Choosing Kenya',
                'slug'       => 'diaspora-buyers-choosing-kenya',
                'category'   => 'market',
                'location'   => 'Nairobi',
                'summary'    => 'Favourable exchange rates, strong rental yields, and a maturing mortgage market are driving diaspora investment.',
                'body'       => '<p>Kenyans living abroad have long invested in property back home. But over the last two years, that trend has accelerated — for several concrete reasons.</p>
<h3>Why now</h3>
<ul>
<li><strong>Exchange rate</strong> — the KES has stabilised, making it more attractive to convert foreign currency.</li>
<li><strong>Rental demand</strong> — strong demand from expats and young professionals keeps prime rentals occupied.</li>
<li><strong>Mortgage market</strong> — more banks are offering diaspora-friendly mortgage products.</li>
<li><strong>Legal transparency</strong> — digital land records have simplified due diligence.</li>
</ul>
<h3>What to watch out for</h3>
<ul>
<li><strong>Fake listings</strong> — always view the property or send a trusted representative.</li>
<li><strong>Off-plan risk</strong> — choose developers with a strong track record and clear timelines.</li>
<li><strong>Currency timing</strong> — large transactions should be timed with your preferred exchange rate.</li>
</ul>
<p>For diaspora buyers, the key is partnering with a developer you can trust — one with completed projects and verifiable references.</p>',
                'is_published' => true,
                'sort_order'   => 5,
            ],
        ];

        foreach ($insights as $data) {
            Insight::updateOrCreate(
                ['slug' => $data['slug'], 'category' => $data['category']],
                $data
            );
        }

        $this->command->info('Processed ' . count($insights) . ' insights (existing ones skipped).');
    }
}