<?php
namespace Database\Seeders;

use App\Models\Country;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BpnPropertySeeder extends Seeder
{
    public function run(): void
    {
        $kenya = Country::where('slug', 'kenya')->first();
        if (!$kenya) {
            $this->command->error('Country "kenya" not found. Run CountrySeeder first.');
            return;
        }

        $properties = [
            [
                'name'        => '2 Bedroom Apartment — Kileleshwa',
                'location'    => 'Kileleshwa',
                'price'       => 12_000_000,
                'beds'        => 2,
                'baths'       => 2,
                'size'        => 120,
                'status'      => 'ongoing',
                'type'        => 'Apartment',
                'description' => 'A modern 2-bedroom apartment in the heart of Kileleshwa. This well-designed unit offers 2 bathrooms, 120 m² of living space, and premium finishes throughout. Secure compound with 24/7 security, covered parking, and backup generator.',
            ],
            [
                'name'        => '3 Bedroom Luxury Apartment — Kilimani',
                'location'    => 'Kilimani',
                'price'       => 18_500_000,
                'beds'        => 3,
                'baths'       => 3,
                'size'        => 160,
                'status'      => 'ongoing',
                'type'        => 'Apartment',
                'description' => 'Luxury 3-bedroom apartment in Kilimani with 3 ensuite bathrooms and 160 m² of living space. Premium amenities include a swimming pool, fully equipped gym, rooftop lounge, and 24/7 concierge. Minutes from Yaya Centre and Ngong Road.',
            ],
            [
                'name'        => '4 Bedroom Villa — Karen',
                'location'    => 'Karen',
                'price'       => 85_000_000,
                'beds'        => 4,
                'baths'       => 5,
                'size'        => 450,
                'status'      => 'ongoing',
                'type'        => 'Villa',
                'description' => 'Spacious 4-bedroom villa in Karen sitting on a generous private plot. Features include 5 bathrooms, 450 m² of living space, private swimming pool, mature gardens, staff quarters, and a double garage. Perfect for families seeking space and privacy.',
            ],
            [
                'name'        => '1 Bedroom Investment Apartment — Westlands',
                'location'    => 'Westlands',
                'price'       => 7_500_000,
                'beds'        => 1,
                'baths'       => 1,
                'size'        => 55,
                'status'      => 'off_plan',
                'type'        => 'Apartment',
                'description' => 'Off-plan 1-bedroom investment apartment in Westlands. Ideal for rental income with strong demand from expats and young professionals. 55 m², modern finishes, pool and gym in the building. Completion expected soon.',
            ],
            [
                'name'        => '4 Bedroom Townhouse — Lavington',
                'location'    => 'Lavington',
                'price'       => 39_000_000,
                'beds'        => 4,
                'baths'       => 4,
                'size'        => 300,
                'status'      => 'ongoing',
                'type'        => 'Townhouse',
                'description' => 'Family-friendly 4-bedroom townhouse in leafy Lavington. 4 bathrooms, 300 m², private garden, and access to a shared community pool. Close to international schools and shopping. Ideal for growing families.',
            ],
            [
                'name'        => 'Luxury Penthouse — Riverside',
                'location'    => 'Riverside',
                'price'       => 68_000_000,
                'beds'        => 4,
                'baths'       => 4,
                'size'        => 400,
                'status'      => 'ongoing',
                'type'        => 'Penthouse',
                'description' => 'Premium 4-bedroom penthouse in Riverside with panoramic city views. 400 m² of luxurious living space, private rooftop terrace, and top-tier amenities including infinity pool, spa, and concierge service. One of Nairobi\'s most exclusive addresses.',
            ],
        ];

        foreach ($properties as $i => $p) {
            $slug = Str::slug($p['name']);
            Project::updateOrCreate(['slug' => $slug], [
                'name'            => $p['name'],
                'country_id'      => $kenya->id,
                'location'        => $p['location'],
                'city'            => 'Nairobi',
                'address'         => $p['location'] . ', Nairobi',
                'description'     => $p['description'],
                'status'          => $p['status'],
                'is_featured'     => true,
                'contact_email'   => 'hello@buypropertynairobi.com',
                'whatsapp_number' => '254799934180',
                'sort_order'      => $i + 1,
            ]);
        }

        $this->command->info('Seeded ' . count($properties) . ' Buy Property Nairobi listings.');
    }
}