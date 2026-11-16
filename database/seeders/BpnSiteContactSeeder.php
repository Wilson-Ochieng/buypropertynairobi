<?php
namespace Database\Seeders;

use App\Models\SiteContact;
use Illuminate\Database\Seeder;

class BpnSiteContactSeeder extends Seeder
{
    public function run(): void
    {
        SiteContact::updateOrCreate(
            ['role' => 'Primary'],
            [
                'name'       => 'Buy Property Nairobi Team',
                'phone'      => '+254 799 934 180',
                'email'      => 'hello@buypropertynairobi.com',
                'is_primary' => true,
            ]
        );

        $this->command->info('Primary contact seeded.');
    }
}