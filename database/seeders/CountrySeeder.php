<?php
namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Country::updateOrCreate(['slug' => 'kenya'], [
            'name'       => 'Kenya',
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        Country::updateOrCreate(['slug' => 'china'], [
            'name'       => 'China',
            'sort_order' => 2,
            'is_active'  => true,
        ]);
    }
}