<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Seed the I'M PART partner organizations.
     */
    public function run(): void
    {
        // ── Government Sector Partners ──────────────────────────────────
        $governmentPartners = [
            [
                'name'       => 'Central Luzon State University (CLSU)',
                'logo'       => 'partners/ps-clsu.webp',
                'sort_order' => 1,
            ],
            [
                'name'       => 'Nueva Ecija University of Science and Technology (NEUST)',
                'logo'       => 'partners/ps-neust.png',
                'sort_order' => 2,
            ],
            [
                'name'       => 'Philippine Information Agency (PIA)',
                'logo'       => 'partners/ps-pia.png',
                'sort_order' => 3,
            ],
            [
                'name'       => 'Philippine Health Insurance Corporation (PhilHealth)',
                'logo'       => 'partners/ps-philhealth.png',
                'sort_order' => 4,
            ],
            [
                'name'       => 'Department of Health (DOH)',
                'logo'       => 'partners/ps-doh.png',
                'sort_order' => 5,
            ],
            [
                'name'       => 'Department of the Interior and Local Government (DILG)',
                'logo'       => 'partners/ps-dilg.png',
                'sort_order' => 6,
            ],
            [
                'name'       => 'Provincial Government of Nueva Ecija',
                'logo'       => 'partners/ps-gov.ne.jpg',
                'sort_order' => 7,
            ],
            [
                'name'       => 'Municipality of Aliaga',
                'logo'       => 'partners/ps-muni-aliaga.png',
                'sort_order' => 8,
            ],
            [
                'name'       => 'Municipality of Bongabon',
                'logo'       => 'partners/ps-muni-bongabon.jpg',
                'sort_order' => 9,
            ],
            [
                'name'       => 'City of Cabanatuan',
                'logo'       => 'partners/ps-muni-cabanatuan.png',
                'sort_order' => 10,
            ],
        ];

        foreach ($governmentPartners as $data) {
            Partner::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo'       => $data['logo'],
                    'sector'     => 'government',
                    'is_active'  => true,
                    'sort_order' => $data['sort_order'],
                ]
            );
        }

        // ── Private / Business and Civil Society Organization Sector ────
        $privatePartners = [
            [
                'name'       => 'ICOB-IPEIO',
                'logo'       => 'partners/ps-iped.png',
                'sort_order' => 1,
            ],
            [
                'name'       => 'KAMICYDI',
                'logo'       => 'partners/ps-KAMICYDI.png',
                'sort_order' => 2,
            ],
            [
                'name'       => 'Haribon Foundation',
                'logo'       => 'partners/ps-haribon.svg',
                'sort_order' => 3,
            ],
            [
                'name'       => 'Katutubo ng Grupo Novo Ecijano Asosasyon',
                'logo'       => 'partners/ps-katutubobg-novo.png',
                'sort_order' => 4,
            ],
        ];

        foreach ($privatePartners as $data) {
            Partner::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo'       => $data['logo'],
                    'sector'     => 'private',
                    'is_active'  => true,
                    'sort_order' => $data['sort_order'],
                ]
            );
        }

        $this->command->info('✅ ' . count($governmentPartners) . ' government + ' . count($privatePartners) . ' private partners seeded successfully.');
    }
}
