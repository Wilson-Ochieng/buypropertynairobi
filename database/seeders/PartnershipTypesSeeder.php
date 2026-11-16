<?php
namespace Database\Seeders;

use App\Models\Partnership;
use Illuminate\Database\Seeder;

class PartnershipTypesSeeder extends Seeder
{
    public function run(): void
    {
        // Land Partnership (existing — ensure it has type = land)
        Partnership::updateOrCreate(
            ['type' => 'land'],
            [
                'title' => 'Land Partnership',
                'subtitle' => 'Own land? Let\'s build something together.',
                'description' => 'Nanchong Group invites landowners and investors to partner with us on prime land across Kenya. Bring land, and we bring the full Nanchong development engine — design, construction, property management, and sales — to create a landmark development together.',
                'cta_label' => 'Speak to the Chairman\'s office',
                'cta_url' => 'mailto:nanchonginternational@gmail.com',
                'contact_name' => 'Chairman, Nanchong Group',
                'contact_email' => 'nanchonginternational@gmail.com',
                'is_active' => true,
            ]
        );

        // Real Estate Agencies
        Partnership::updateOrCreate(
            ['type' => 'agency'],
            [
                'title' => 'Real Estate Agencies',
                'subtitle' => 'Sell Nanchong homes with premium commission.',
                'description' => 'Registered real estate agencies are invited to partner with Nanchong Group. We offer competitive commission structures, priority access to new releases, co-branded marketing materials, and dedicated agent support. Our team handles the paperwork, construction updates, and handover logistics — so you focus on matching buyers to their ideal home.',
                'cta_label' => 'Apply as an agency',
                'cta_url' => 'mailto:agencies@nanchonginternational.com',
                'benefits' => [
                    'Competitive commission structure',
                    'Priority access to new unit releases',
                    'Co-branded marketing materials',
                    'Dedicated partnership manager',
                    'Fast-tracked buyer handover',
                    'Access to our full portfolio — Kenya and China',
                ],
                'contact_name' => 'Agency Partnerships Team',
                'contact_email' => 'agencies@nanchonginternational.com',
                'is_active' => true,
            ]
        );

        // Freelance Agents
        Partnership::updateOrCreate(
            ['type' => 'freelancer'],
            [
                'title' => 'Freelance Agents',
                'subtitle' => 'Earn premium commission on every successful sale.',
                'description' => 'Whether you\'re an independent agent or transitioning from a larger agency, Nanchong Group welcomes freelance agents. Get direct access to our inventory, flexible working terms, and fast commission payouts — no monthly targets, no restrictive exclusivity.',
                'cta_label' => 'Join as a freelance agent',
                'cta_url' => 'mailto:agents@nanchonginternational.com',
                'benefits' => [
                    'Premium commission on every sale',
                    'No monthly targets or quotas',
                    'Fast commission payouts',
                    'Direct access to sales team',
                    'Full inventory visibility',
                    'Work independently, get paid quickly',
                ],
                'contact_name' => 'Freelance Agent Team',
                'contact_email' => 'agents@nanchonginternational.com',
                'is_active' => true,
            ]
        );
    }
}