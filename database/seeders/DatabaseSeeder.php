<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BpnAdminSeeder::class,
            CountrySeeder::class,
            LookupSeeder::class,
            UnitTypeLookupSeeder::class,
            BrandSeeder::class,
            BpnPropertySeeder::class,
            BpnUnitTypeSeeder::class,
            BpnSiteContactSeeder::class,




        ]);
    }
}