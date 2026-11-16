<?php
namespace Database\Seeders;

use App\Models\SiteContact;
use Illuminate\Database\Seeder;

class SiteContactSeeder extends Seeder
{
    public function run(): void
    {
        SiteContact::updateOrCreate(
            ['email' => 'nanchonginternational@gmail.com', 'role' => 'Client Contact'],
            [
                'name' => 'Mr. Huang',
                'phone' => '+254 710 998 888',
                'is_primary' => true,
            ]
        );

        SiteContact::updateOrCreate(
            ['role' => 'Chairman'],
            [
                'name' => 'Chairman, Nanchong Group',
                'email' => 'nanchonginternational@gmail.com',
                'phone' => null,
                'is_primary' => false,
            ]
        );
    }
}