<?php
namespace Database\Seeders;

use App\Models\Insight;
use Illuminate\Database\Seeder;

class InsightSeeder extends Seeder
{
    public function run(): void
    {
        Insight::updateOrCreate(['slug' => 'living-in-kilimani'], [
            'title' => 'Living in Kilimani — A Buyer\'s Guide',
            'location' => 'Kilimani',
            'summary' => 'Why Kilimani is one of Nairobi\'s most sought-after residential neighbourhoods.',
            'body' => "Kilimani sits just southwest of Nairobi's CBD, close to Ngong Road and the Yaya Centre. The area is popular for its leafy streets, international schools, restaurants, and easy access to both Westlands and the city centre.\n\nThe neighbourhood has seen significant mid-rise development over the past decade, with mixed-use projects offering retail at street level and residential above. Expect strong rental demand from expats and young professionals.\n\nBuyers should consider:\n\n- Proximity to Ngong Road — the main artery to the west.\n- Security — most developments are gated with 24/7 guards.\n- Water supply — boreholes are common in newer developments.\n- Schools — Braeburn, Hillcrest, and Brookhouse are within reach.",
            'is_published' => true,
            'sort_order' => 1,
        ]);

        Insight::updateOrCreate(['slug' => 'living-in-westlands'], [
            'title' => 'Living in Westlands — A Buyer\'s Guide',
            'location' => 'Westlands',
            'summary' => 'The commercial and residential heartbeat of modern Nairobi.',
            'body' => "Westlands is Nairobi's primary commercial district after the CBD, mixing office towers, shopping malls (Sarit, Westgate, The Hub), and high-end residential apartments.\n\nThe area attracts young professionals and expats. Traffic is dense at peak hours, but the convenience of having everything nearby compensates.\n\nBuyers should consider:\n\n- Traffic — plan commuting times around rush hours.\n- Access to malls and restaurants — Westlands is unmatched on this front.\n- Newer high-rises with amenities — pools, gyms, co-working spaces.\n- Rental yields — Westlands consistently delivers strong returns.",
            'is_published' => true,
            'sort_order' => 2,
        ]);
    }
}