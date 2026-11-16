<?php
namespace Database\Seeders;

use App\Models\BudgetRange;
use App\Models\Style;
use App\Models\UseCategory;
use Illuminate\Database\Seeder;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        // Uses
        $uses = [
            ['name' => 'Family Homes', 'slug' => 'family', 'description' => 'Homes designed for family life — space, safety, schools nearby.'],
            ['name' => 'Investments', 'slug' => 'investment', 'description' => 'Properties with strong rental yield and long-term capital growth.'],
            ['name' => 'Holiday Homes', 'slug' => 'holiday', 'description' => 'Second homes and vacation properties in desirable locations.'],
            ['name' => 'Commercial', 'slug' => 'commercial', 'description' => 'Retail, office, and mixed-use commercial spaces.'],
        ];
        foreach ($uses as $u) {
            UseCategory::updateOrCreate(['slug' => $u['slug']], $u);
        }

        // Styles — Type column shows the apartment/villa/etc subset
        $styles = [
            ['name' => 'Apartment', 'slug' => 'apartment', 'description' => 'Vertical units in multi-storey buildings.'],
            ['name' => 'Villa', 'slug' => 'villa', 'description' => 'Standalone homes on private plots with gardens.'],
            ['name' => 'Townhouse', 'slug' => 'townhouse', 'description' => 'Multi-level homes sharing walls with neighbours.'],
            ['name' => 'Maisonette', 'slug' => 'maisonette', 'description' => 'Two-floor units in low-rise developments.'],
            ['name' => 'Studio', 'slug' => 'studio', 'description' => 'Compact one-room units with kitchenette.'],
            ['name' => 'Bedsitter', 'slug' => 'bedsitter', 'description' => 'Single-room units with basic amenities.'],
            ['name' => 'Duplex', 'slug' => 'duplex', 'description' => 'Two-floor living with private staircase — a home-like layout.'],
            ['name' => 'Simplex', 'slug' => 'simplex', 'description' => 'Single-floor layout for ease of living.'],
            ['name' => 'Triplex', 'slug' => 'triplex', 'description' => 'Three-level homes with generous living and dining spaces.'],
            ['name' => 'Penthouse', 'slug' => 'penthouse', 'description' => 'Top-floor residences with terraces and premium finishes.'],
            ['name' => 'Bungalow', 'slug' => 'bungalow', 'description' => 'Single-storey standalone home.'],
        ];
        foreach ($styles as $s) {
            Style::updateOrCreate(['slug' => $s['slug']], $s);
        }

        // Budget ranges — SALE
        $saleRanges = [
            ['label' => 'Below KES 10M', 'min_value' => null, 'max_value' => 10_000_000, 'sort_order' => 1, 'description' => 'Entry-level homes and studios — ideal for first-time buyers and rental investors.'],
            ['label' => 'KES 10M – 20M', 'min_value' => 10_000_000, 'max_value' => 20_000_000, 'sort_order' => 2, 'description' => 'The sweet spot for 2-bedroom apartments in established neighbourhoods — great value.'],
            ['label' => 'KES 20M – 30M', 'min_value' => 20_000_000, 'max_value' => 30_000_000, 'sort_order' => 3, 'description' => 'Spacious 3-bedroom apartments and smaller townhouses in prime areas.'],
            ['label' => 'KES 30M – 40M', 'min_value' => 30_000_000, 'max_value' => 40_000_000, 'sort_order' => 4, 'description' => 'Family homes and maisonettes with generous living spaces and amenities.'],
            ['label' => 'KES 40M – 50M', 'min_value' => 40_000_000, 'max_value' => 50_000_000, 'sort_order' => 5, 'description' => 'High-end family properties in Nairobi\'s most desirable neighbourhoods.'],
            ['label' => 'KES 50M – 60M', 'min_value' => 50_000_000, 'max_value' => 60_000_000, 'sort_order' => 6, 'description' => 'Luxury apartments and villas with premium finishes and expansive layouts.'],
            ['label' => 'KES 60M – 70M', 'min_value' => 60_000_000, 'max_value' => 70_000_000, 'sort_order' => 7, 'description' => 'Premium properties in gated communities with full amenities.'],
            ['label' => 'Above KES 70M', 'min_value' => 70_000_000, 'max_value' => null, 'sort_order' => 8, 'description' => 'Our most exclusive listings — luxury villas, penthouses, and landmark homes.'],
        ];
        foreach ($saleRanges as $r) {
            BudgetRange::updateOrCreate(
                ['purpose' => 'sale', 'label' => $r['label']],
                array_merge($r, ['purpose' => 'sale', 'is_active' => true])
            );
        }

        // Budget ranges — RENT (monthly)
        $rentRanges = [
            ['label' => 'Below KES 30K', 'min_value' => null, 'max_value' => 30_000, 'sort_order' => 1, 'description' => 'Affordable rentals — studios and bedsitters in accessible areas.'],
            ['label' => 'KES 30K – 50K', 'min_value' => 30_000, 'max_value' => 50_000, 'sort_order' => 2, 'description' => 'Comfortable 1-bedroom apartments in residential neighbourhoods.'],
            ['label' => 'KES 50K – 100K', 'min_value' => 50_000, 'max_value' => 100_000, 'sort_order' => 3, 'description' => 'Well-finished 1 and 2-bedroom apartments with amenities.'],
            ['label' => 'KES 100K – 200K', 'min_value' => 100_000, 'max_value' => 200_000, 'sort_order' => 4, 'description' => 'Spacious family homes and prime-location apartments.'],
            ['label' => 'KES 200K – 400K', 'min_value' => 200_000, 'max_value' => 400_000, 'sort_order' => 5, 'description' => 'High-end rentals with premium finishes and full amenities.'],
            ['label' => 'Above KES 400K', 'min_value' => 400_000, 'max_value' => null, 'sort_order' => 6, 'description' => 'Luxury rentals — villas, penthouses, and exclusive addresses.'],
        ];
        foreach ($rentRanges as $r) {
            BudgetRange::updateOrCreate(
                ['purpose' => 'rent', 'label' => $r['label']],
                array_merge($r, ['purpose' => 'rent', 'is_active' => true])
            );
        }
    }
}