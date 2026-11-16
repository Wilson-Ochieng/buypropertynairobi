<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BpnAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@buypropertynairobi.test'],
            [
                'name'     => 'Buy Property Admin',
                'password' => Hash::make('password'),
            ]
        );

        $this->command->info('Admin user: admin@buypropertynairobi.test / password');
    }
}