<?php
namespace Database\Seeders;

use App\Models\Country;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $kenya = Country::where('slug', 'kenya')->first();
        $china = Country::where('slug', 'china')->first();

        if (!$kenya || !$china) {
            throw new \RuntimeException('Countries must be seeded before projects. Run CountrySeeder first.');
        }

        $projects = [
            // ============ KENYA ============
            [
                'name'          => 'Nanchong Longines Bay',
                'country_id'    => $kenya->id,
                'location'      => 'Kilimani',
                'city'          => 'Nairobi',
                'address'       => 'Kilimani / Karbanet Rd off Ngong Rd',
                'description'   => 'A mixed-use development offering retail spaces from 27 m² to 180 m² and residential units including studios, 1-bedroom, 2-bedroom and duplex options. An international community — people from different countries taking part.',
                'is_featured'   => true,
                'contact_email' => 'bay@nanchonginternational.com',
                'sort_order'    => 1,
            ],
            [
                'name'          => 'Nanchong Longines Island',
                'country_id'    => $kenya->id,
                'location'      => 'Westlands',
                'city'          => 'Nairobi',
                'address'       => 'Westlands Avenue off Sports Rd',
                'description'   => 'Residential development offering studio, 1-bedroom and 2-bedroom units in the heart of Westlands, Nairobi.',
                'is_featured'   => true,
                'contact_email' => 'island@nanchonginternational.com',
                'sort_order'    => 2,
            ],

            // ============ CHINA ============
            [
                'name'              => 'Liuyang Full-Business Urban Complex',
                'country_id'        => $china->id,
                'location'          => 'Liuyang',
                'city'              => 'Liuyang',
                'address'           => 'Liuyang City, Hunan Province',
                'description'       => 'This community is located in Liuyang City, with a total investment of about 10 billion yuan and a land area of about 600.36 mu, including a 5A office building, residential and commercial blocks, and a five-star famous hotel. With a construction area of about 1.24 million square meters, it is a full-business urban complex.',
                'investment'        => '10 billion yuan',
                'land_area'         => '600.36 mu',
                'construction_area' => '1.24 million m²',
                'is_featured'       => true,
                'sort_order'        => 10,
            ],
            [
                'name'            => 'Nanchong Hongcheng Road Community',
                'country_id'      => $china->id,
                'location'        => 'Nanchang · Xihu',
                'city'            => 'Nanchang',
                'address'         => 'Hongcheng Road, Xihu District, Nanchang',
                'description'     => 'This community is the third project of Nanchong Group in Nanchang City, located on Hongcheng Road, Xihu District, Nanchang City, about 380 meters away from the subway station.',
                'distance_subway' => '380 m',
                'is_featured'     => true,
                'sort_order'      => 11,
            ],
            [
                'name'            => 'Nanchong Bayi Square Residences',
                'country_id'      => $china->id,
                'location'        => 'Nanchang · City Center',
                'city'            => 'Nanchang',
                'address'         => 'City Center, near Bayi Square, Nanchang',
                'description'     => 'This community is located in the center of Nanchang city, only 400 meters away from the landmark building of Nanchang Bayi Square, enjoying the top urban facilities, 3 of the city\'s most luxurious shopping malls, and the entrance of the community is the city\'s most popular food block. Only 70 prized homes were snapped up.',
                'distance_subway' => '400 m from Bayi Square',
                'unit_count'      => '70 prized homes',
                'is_featured'     => true,
                'sort_order'      => 12,
            ],
            [
                'name'              => 'Nanchong Subway Education Community',
                'country_id'        => $china->id,
                'location'          => 'Nanchang',
                'city'              => 'Nanchang',
                'address'           => 'Nanchang, Jiangxi Province',
                'description'       => 'This community is located in Nanchang City, Jiangxi Province. It is a subway education community with mature surrounding life — the subway and the school are very close. With a construction area of about 90,000 square meters, six high-rise buildings are carefully regulated with high construction standards. The new Asian architectural style combined with the national style garden brings a new living place for local people.',
                'construction_area' => '90,000 m²',
                'is_featured'       => true,
                'sort_order'        => 13,
            ],
            [
                'name'              => 'Nanchong Fuzhou Park Community',
                'country_id'        => $china->id,
                'location'          => 'Fuzhou',
                'city'              => 'Fuzhou',
                'address'           => 'Fuzhou City, Jiangxi Province',
                'description'       => 'This community is located in Fuzhou City, Jiangxi Province. It covers an area of about 90 mu and will be built into a 148,000 square meter park ecological community. It consists of 6 high-rise buildings, 2 small high-rise buildings and 10 villas, in addition to a 6-class community kindergarten.',
                'land_area'         => '90 mu',
                'construction_area' => '148,000 m²',
                'is_featured'       => true,
                'sort_order'        => 14,
            ],
            [
                'name'              => 'Nanchong Chongren Baoshui Community',
                'country_id'        => $china->id,
                'location'          => 'Chongren',
                'city'              => 'Chongren',
                'address'           => 'Baoshui New District, next to Chongren No.1 Middle School',
                'description'       => 'The project is located in Baoshui New District, next to Chongren No.1 Middle School, alongside hospitals, schools, shopping malls, parks and other living facilities. With a construction area of about 100,000 square meters, Chongren is a new starting point for quality human settlements.',
                'construction_area' => '100,000 m²',
                'is_featured'       => true,
                'sort_order'        => 15,
            ],
        ];

        foreach ($projects as $data) {
            $data['slug'] = Str::slug($data['name']);
            Project::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}