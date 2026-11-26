<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Westlands (General Mathenge Road) apartments for sale.
 * Run: php artisan db:seed --class=WestlandsGeneralMathengeSeeder
 * Safe to re-run: records are matched by slug and updated, not duplicated.
 */
class WestlandsGeneralMathengeSeeder extends Seeder
{
    private const ADDRESS = 'General Mathenge Road, Westlands, Nairobi';
    private const WHATSAPP = '254799934180';

    private const AMENITIES = [
        'Heated swimming pool',
        'Rooftop BBQ area',
        'Sauna room',
        'Landscaped gardens',
        'Walking & jogging track',
        'Children’s playground',
        'Social hall',
        'Water feature',
        'Electric vehicle charging port',
        'Backup generator',
        'Laundromat',
        'Intercom',
        'Alarm system',
    ];

    public function run(): void
    {
        $country = Country::query()
            ->where('slug', 'kenya')
            ->orWhere('name', 'Kenya')
            ->first();

        if (!$country) {
            $this->command?->error('Kenya was not found in the countries table. Add it in the admin first, then re-run.');
            return;
        }

        foreach ($this->listings() as $i => $l) {
            $title = $l['title'];
            $slug = Str::slug($title);

            $property = Property::updateOrCreate(['slug' => $slug], [
                'title' => $title,
                'description' => $l['description'],
                'country_id' => $country->id,
                'category' => 'residential',
                'purpose' => 'sale',
                'status' => 'available',
                'property_type' => 'apartment',
                'bedrooms' => $l['bedrooms'],
                'bathrooms' => $l['bathrooms'],
                'floors' => $l['floors'] ?? null,
                'size_sqm' => $l['size'],
                'price_kes' => $l['price'],
                'price_negotiable' => false,
                'location' => 'Westlands',
                'city' => 'Nairobi',
                'address' => self::ADDRESS,
                'features' => self::AMENITIES,
                'whatsapp_number' => self::WHATSAPP,
                'is_featured' => $l['featured'] ?? false,
                'is_published' => true,
                'sort_order' => $i,
            ]);

            // Highlights (replace on re-run so they don't duplicate)
            $property->highlights()->delete();
            foreach ($l['highlights'] as $n => $label) {
                $property->highlights()->create(['label' => $label, 'sort_order' => $n]);
            }
        }
    }

    private function listings(): array
    {
        $shared = 'Located along General Mathenge Road in Westlands, this development offers modern apartment living in one of Nairobi’s most established and desirable neighbourhoods, close to shopping, dining, international schools and business centres. Residents enjoy a heated swimming pool, rooftop BBQ area, sauna, landscaped gardens, a walking and jogging track, children’s playground, social hall, water feature, electric vehicle charging, backup generator, laundromat, intercom and alarm system.';

        $amenityHighlights = [
            'Heated swimming pool',
            'Rooftop BBQ area and sauna',
            'Backup generator',
            'EV charging port',
            'Intercom & alarm system',
        ];

        return [
            // ── Featured listing ──
            [
                'title' => '3 Bedroom Apartment + DSQ for Sale, General Mathenge Road, Westlands (Unit C8)',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'size' => 170,
                'price' => 25600000,
                'featured' => true,
                'description' => "A spacious, modern 3-bedroom apartment with a separate domestic staff quarters (DSQ) on General Mathenge Road, Westlands. All three bedrooms are ensuite, and the generous 170 sqm layout suits family living or long-term property investment.\n\n"
                    . "Unit C8 sits in a development with premium lifestyle amenities, including a heated swimming pool, rooftop BBQ area, sauna room, landscaped gardens, a walking and jogging track, children’s playground, social hall, water feature, electric vehicle charging port, backup generator, laundromat, and intercom and alarm systems.\n\n"
                    . "Westlands offers easy access to shopping, dining, international schools, business centres and lifestyle destinations. Contact Buy Property Nairobi to arrange a private viewing, request photos or ask for more details.",
                'highlights' => array_merge([
                    '3 spacious bedrooms, all ensuite',
                    'Separate domestic staff quarters (DSQ)',
                    '170 sqm layout',
                    'Prime Westlands location',
                ], $amenityHighlights),
            ],

            // ── Other available units (same development) ──
            $this->unit('2 Bedroom Apartment for Sale, General Mathenge Road, Westlands (Unit A2)', 2, null, 110, 14500000, $shared, $amenityHighlights),
            $this->unit('2 Bedroom Apartment for Sale, General Mathenge Road, Westlands (Unit A10)', 2, null, 110, 17700000, $shared, $amenityHighlights),
            $this->unit('2 Bedroom Apartment for Sale, General Mathenge Road, Westlands (Unit A12)', 2, null, 110, 18000000, $shared, $amenityHighlights),

            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit B2)', 3, null, 150, 21300000, $shared, $amenityHighlights),
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit B5)', 3, null, 150, 22000000, $shared, $amenityHighlights),
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit C5)', 3, null, 150, 22100000, $shared, $amenityHighlights),
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit B6)', 3, null, 150, 22200000, $shared, $amenityHighlights),
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit C6)', 3, null, 150, 22300000, $shared, $amenityHighlights),
            // NOTE: Unit C8 appears twice in the price list (22.8M master-ensuite and 25.6M all-ensuite + DSQ).
            // Confirm which is correct; the slug below is distinct so both can exist until you decide.
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit C8 Master Ensuite)', 3, null, 150, 22800000, $shared, $amenityHighlights),
            $this->unit('3 Bedroom Master Ensuite Apartment for Sale, Westlands (Unit C14)', 3, null, 150, 24200000, $shared, $amenityHighlights),

            $this->unit('4 Bedroom Duplex + DSQ for Sale, General Mathenge Road, Westlands (Unit D7)', 4, null, 230, 36000000, $shared, array_merge(['Duplex with DSQ'], $amenityHighlights), floors: 2),
        ];
    }

    private function unit(string $title, int $bedrooms, ?int $bathrooms, int $size, int $price, string $description, array $highlights, ?int $floors = null): array
    {
        return [
            'title' => $title,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'size' => $size,
            'price' => $price,
            'floors' => $floors,
            'description' => $description,
            'highlights' => array_merge(["{$size} sqm", "{$bedrooms} bedrooms"], $highlights),
        ];
    }
}