<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tribe;

class TribeSeeder extends Seeder
{
    /**
     * Seed the 18 Indigenous Peoples tribes.
     */
    public function run(): void
    {
        $tribes = [
            [
                'name'        => 'Aeta',
                'description' => 'The Aetas are among the earliest inhabitants, known for their resilience and farming traditions.',
                'photo'       => 'tribes/aeta.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Alta',
                'description' => 'The Altas are upland dwellers, closely related to the Dumagat, recognized for farming and forest resource use.',
                'photo'       => 'tribes/alta.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Bag-o',
                'description' => 'The Bag-o people are highland migrants, blending Ilocano and Cordilleran traditions in farming and crafts.',
                'photo'       => 'tribes/bago.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Badjao',
                'description' => 'The Badjao, or "sea gypsies," are known for their seafaring, fishing, and boat-dwelling culture.',
                'photo'       => 'tribes/badjao.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Bontoc',
                'description' => 'The Bontoc are famous for their rice terraces, woodcarving, and rich warrior traditions.',
                'photo'       => 'tribes/bontoc.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Bungkalot (Ilongot)',
                'description' => 'The Bugkalot, also called Ilongot, are known for their strong sense of independence and forest-based livelihood.',
                'photo'       => 'tribes/bungkalot.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Cordillera IP',
                'description' => 'Indigenous peoples from the Cordillera, known for rice cultivation, weaving, and mountain traditions.',
                'photo'       => 'tribes/cordillera-ip.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Dumagat',
                'description' => 'The Dumagats are riverine people, recognized for fishing, hunting, and their forest-based traditions.',
                'photo'       => 'tribes/dumagat.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Gaddang',
                'description' => 'Gaddang are skilled weavers and farmers, noted for their colorful textiles and craftsmanship.',
                'photo'       => 'tribes/gaddang.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Ibaloi',
                'description' => 'The Ibaloi are highland farmers of Benguet, known for cattle raising, rice cultivation, and rituals.',
                'photo'       => 'tribes/ibaloi.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Ibanag',
                'description' => 'The Ibanag are river valley settlers, famous for farming, fishing, and their rich oral traditions.',
                'photo'       => 'tribes/ibanag.jpg',  
                'is_active'   => true,
            ],
            [
                'name'        => 'Ifugao',
                'description' => 'The Ifugao are stewards of the Banaue Rice Terraces, known for woodcarving, rice rituals, and weaving.',
                'photo'       => 'tribes/ifugao.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Itawis',
                'description' => 'The Itawis are valley dwellers of Northern Luzon, known for farming, fishing, and weaving.',
                'photo'       => 'tribes/itawis.webp',
                'is_active'   => true,
            ],
            [
                'name'        => 'Itneg',
                'description' => 'The Itneg (Tinguian) are upland farmers and weavers, deeply rooted in animist rituals and traditions.',
                'photo'       => 'tribes/itneg.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'I-wak',
                'description' => 'The I-wak are Cordilleran highlanders, recognized for rice farming, weaving, and their close kinship ties.',
                'photo'       => 'tribes/I-wak.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kalanguya',
                'description' => 'The Kalanguya are terrace farmers and swidden cultivators, with traditions centered on rice and forest life.',
                'photo'       => 'tribes/kalanguya.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kalinga',
                'description' => 'The Kalinga are known for their warrior heritage, body tattoos, weaving, and vibrant rituals.',
                'photo'       => 'tribes/kalinga.jpg',
                'is_active'   => true,
            ],
            [
                'name'        => 'Kankanaey',
                'description' => 'The Kankanaey are terrace builders, gardeners, and weavers, respected for their community rituals and dances.',
                'photo'       => 'tribes/kankanaey.jpg',
                'is_active'   => true,
            ],
        ];

        foreach ($tribes as $tribe) {
            Tribe::updateOrCreate(
                ['name' => $tribe['name']],
                [
                    'description' => $tribe['description'],
                    'photo'       => $tribe['photo'],
                    'is_active'   => $tribe['is_active'],
                ]
            );
        }

        $this->command->info('✅ 18 tribes seeded successfully.');
    }
}
