<?php
namespace Database\Seeders;

use App\Models\KenyaDivisionPage;
use Illuminate\Database\Seeder;

class KenyaDivisionPageSeeder extends Seeder
{
    public function run(): void
    {
        KenyaDivisionPage::updateOrCreate(['id' => 1], [
            'intro_text' => 'Nanchong Group brings its decade-long track record of building quality homes to Kenya. Under our Kenya Division, we are developing landmark residential and mixed-use projects in Nairobi — combining international standards with local expertise, and creating vibrant communities where people from different countries come together.',
        ]);
    }
}