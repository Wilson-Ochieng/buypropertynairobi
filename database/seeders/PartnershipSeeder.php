<?php
namespace Database\Seeders;

use App\Models\Partnership;
use Illuminate\Database\Seeder;

class PartnershipSeeder extends Seeder
{
    public function run(): void
    {
        Partnership::updateOrCreate(
            ['title' => 'Land Partnership'],
            [
                'description' => 'Nanchong Group invites landowners and investors to partner with us on prime land across Kenya. Bring land, and we bring the full Nanchong development engine — design, construction, property management and sales — to create a landmark development together. Reach out to the Chairman\'s office directly to discuss.',
                'contact_name' => 'Chairman, Nanchong Group',
                'contact_email' => 'nanchonginternational@gmail.com',
                'contact_phone' => null,
                'is_active' => true,
            ]
        );
    }
}