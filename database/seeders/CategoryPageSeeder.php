<?php
namespace Database\Seeders;

use App\Models\CategoryPage;
use Illuminate\Database\Seeder;

class CategoryPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'kilimani',
                'purpose' => 'buy',
                'category_type' => 'location',
                'filter_value' => 'Kilimani',
                'h1' => 'Properties for Sale in Kilimani',
                'description' => '<p>Kilimani is one of Nairobi\'s most vibrant residential neighbourhoods — leafy streets, international schools, and easy access to the city centre. Properties range from modern studio apartments to spacious family homes and duplexes.</p>',
            ],
            [
                'slug' => 'westlands',
                'purpose' => 'buy',
                'category_type' => 'location',
                'filter_value' => 'Westlands',
                'h1' => 'Properties for Sale in Westlands',
                'description' => '<p>Westlands is Nairobi\'s primary commercial and residential hub. Modern high-rises, shopping malls, and restaurants make this one of the most sought-after postcodes in the city.</p>',
            ],
            [
                'slug' => '10000000-20000000',
                'purpose' => 'buy',
                'category_type' => 'budget',
                'filter_value' => '10000000-20000000',
                'h1' => 'Properties for Sale Between KES 10M and 20M',
                'description' => '<p>Homes in the 10 to 20 million shillings range offer a comfortable balance of space, location, and finish. This bracket typically includes 2 and 3-bedroom apartments in established areas like Kilimani and Lavington, and smaller townhouses in family-friendly neighbourhoods.</p>',
            ],
            [
                'slug' => 'apartment',
                'purpose' => 'buy',
                'category_type' => 'type',
                'filter_value' => 'apartment',
                'h1' => 'Apartments for Sale',
                'description' => '<p>Apartments remain the most popular choice in Nairobi\'s urban core — modern finishes, shared amenities like pools and gyms, and 24/7 security.</p>',
            ],
            [
                'slug' => 'duplex',
                'purpose' => 'buy',
                'category_type' => 'style',
                'filter_value' => 'duplex',
                'h1' => 'Duplexes for Sale',
                'description' => '<p>Duplexes offer two-floor living with the privacy of a home and the amenities of an apartment complex.</p>',
            ],
        ];

        foreach ($pages as $p) {
            CategoryPage::updateOrCreate(
                ['slug' => $p['slug'], 'purpose' => $p['purpose']],
                array_merge($p, ['is_published' => true])
            );
        }
    }
}