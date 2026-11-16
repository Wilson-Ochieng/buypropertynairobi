<?php
namespace Database\Seeders;

use App\Models\GroupInfo;
use Illuminate\Database\Seeder;

class GroupInfoSeeder extends Seeder
{
    public function run(): void
    {
        GroupInfo::updateOrCreate(['id' => 1], [
            'hero_title'    => 'Nanchong Group',
            'hero_subtitle' => 'Building homes for love, quality Nanchong',
            'brand_tenet'   => 'Building homes for love, quality Nanchong',
            'intro_text'    => 'Nanchong Group was founded in 2010, starting from the beautiful "hometown of Neo Confucianism" — Fuzhou City, Jiangxi Province. Its headquarters is located in the heroic city of Nanchang, with the brand tenet of "building homes for love, quality Nanchong". It is committed to providing comfortable and beautiful living scenes for Chinese families through high-quality products and services, and becoming the "creator of a better life" for Chinese families.

Nanchong Group takes the "marathon spirit" as its cultural guidance and the "hotel+real estate" model as its business strategy, accumulating and steadily cultivating. It has now developed into five major industries: real estate, hotels, construction, property management, and landscaping. It is a large group company with comprehensive development and integrated operation capabilities for high-quality projects.

The registered capital of the company is one billion yuan. As of now, the planned total construction area is about 3 million square meters, with 25,000 sets of planned houses and the development and construction of four-star hotels. The group has subsidiaries such as Jiangxi Tianying Construction Co., Ltd. (first-class qualification), Jiangxi Nanchong Property Management Co., Ltd. (Jinkey-6S service enterprise), Jiangxi Nanchong Landscape Engineering Co., Ltd., and Jiangxi Chongrui Marketing Management Co., Ltd.',
            'registered_capital' => '1 billion yuan',
            'total_area'         => '3 million m²',
            'planned_homes'      => '25,000',
            'hotels_count'       => '4',
            'founded_year'       => '2010',
            'hq_city'            => 'Nanchang',
            'origin_city'        => 'Fuzhou, Jiangxi',
        ]);
    }
}