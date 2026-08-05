<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accomplishment;

class AccomplishmentSeeder extends Seeder
{
    /**
     * Seed all accomplishments from the static accomplishments page.
     * Layout types: 1 = left-image/right-content, 2 = right-image/left-content,
     *               4 = card with image overlay date, 5 = image grid + content
     */
    public function run(): void
    {
        $accomplishments = [

            // ── Year Group: 2025 ──────────────────────────────────────────────
            [
                'title'       => 'CLSU Partnership for IP',
                'description' => 'Science City of Munoz, Nueva Ecija - Central Luzon State University (CLSU) and the National Commission on Indigenous Peoples–Nueva Ecija Provincial Office (NCIP-NEPO) have officially launched a partnership to implement the Indigenous Peoples\' Livelihood Empowerment Advancement Project (IP-LEAP) in Nueva Ecija. The agreement was sealed through a Memorandum of Agreement (MOA) signing held on May 7, 2025 at the CLSU Administration Conference Hall.',
                'date_label'  => 'May 7, 2025',
                'image'       => 'accomplishments/nepo-clsu.jpg',
                'extra_images'=> null,
                'layout_type' => 1,
                'year_group'  => '2025',
                'sort_order'  => 1,
                'is_active'   => true,
            ],

            // ── Year Group: 2023 ──────────────────────────────────────────────
            [
                'title'       => 'NEUST-ReCIPE celebrates the National Indigenous Peoples\' Day',
                'description' => 'The Nueva Ecija University of Science and Technology Regional Center for Indigenous Peoples Education (NEUST-ReCIPE) conducts the first-ever hybrid International Forum Toward Responding to Indigenous Peoples in Voluntary Isolation in Region III, Philippines in celebration of IDWIP with the theme \'Indigenous Peoples in Voluntary Isolation & Initial Contact\' at NEUST Sumacab Campus. The celebration started with a cultural dance performance by ADIBAI IP Youth Organization followed by a Press Briefing attended by the NEUST President Dr. Rhodora R. Jugo, the Vice President for Research, Extension, and Training (RET), Dr. Rachael R. Moralde, and the Head of NEUST-ReCIPE, Dr. Vilma R. Ramos, together with the Provincial Officer of the National Commission on Indigenous Peoples (NCIP) Nueva Ecija Provincial Office (NEPO), Dr. Donato B. Bumacas, who catered to the questions raised by the representatives from different IPs, SUCs, and public agencies and sectors within the region.',
                'date_label'  => 'September 5, 2023',
                'image'       => 'accomplishments/NeustIpDay.jpg',
                'extra_images'=> null,
                'layout_type' => 4,
                'year_group'  => '2023',
                'sort_order'  => 2,
                'is_active'   => true,
            ],

            // ── Year Group: 2020 ──────────────────────────────────────────────
            [
                'title'       => 'Formulation Domaget ADSDPP in Salmag',
                'description' => 'The BUDI MI Domaget Kabolowen Ancestral Domain Sustainable Development and Protection Plan (ADSDPP) in Salmag is our legacy this FY2020. This is one of the major GAA Funded Program being implemented and managed by NCIP NEPO. Due to the CSR free technical assistance of the International Consultancy for Indigenous Peoples Environment and Development Co. (ICON IPED CO.) during the actual formulation process and writing, the said ADSDPP is finished. It is in the layouting stage ready to be printed for distribution.',
                'date_label'  => 'September 11, 2020',
                'image'       => 'accomplishments/IpBudi.png',
                'extra_images'=> null,
                'layout_type' => 2,
                'year_group'  => '2020',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'title'       => 'Educational Assistance for IP',
                'description' => 'The Educational Assistance Program (EAP) is a GAA Funded Program of NCIP NEPO that covers Districts I, II, III & IV in the Province of Nueva Ecija. It is a program that provides financial assistance to IP students who are interested in pursuing their education and who are willing to study harder to be able to attain good grades, graduate in college and have a good life in the future. For Districts I and II, the Educational Assistance Program direct beneficiaries are distributed as follows: 7 Elementary (4 males & 3 females); 6 High School (3 males & 3 females); and 13 College (5 males & 8 females) with a total of twenty six (26) students. All of them are successfully attending their schooling through modules.',
                'date_label'  => 'May 7, 2020',
                'image'       => 'accomplishments/accomplishment-educ.png',
                'extra_images'=> null,
                'layout_type' => 1,
                'year_group'  => '2020',
                'sort_order'  => 4,
                'is_active'   => true,
            ],
            [
                'title'       => 'Issued a total of seven Certificate of Affirmation to barangay IPMRs',
                'description' => 'In 2020, in spite of the COVID-19 Pandemic the NCIP NEPO successfully issued a total of Seven (7) Certificate of Affirmation (COA) to Barangay IPMRs in the different Barangays of Nueva Ecija. The Provincial Officer Dr. Donato B. Bumacas with the staff happily awarded the Certificate of Affirmation (COA) to Barangay IPMR Johnny Ponciano of Barangay San Isidro, Laur, Nueva Ecija.',
                'date_label'  => 'December 12, 2020',
                'image'       => 'accomplishments/accomplishment-certificate.png',
                'extra_images'=> null,
                'layout_type' => 4,
                'year_group'  => '2020',
                'sort_order'  => 5,
                'is_active'   => true,
            ],
            [
                'title'       => 'Assistance IP students scholarship',
                'description' => "57 Tunong Dunong IP Beneficiaries\n13 Tertiary Education Subsidy recipients\n45 Provincial Government Scholars\n6 NEUST-USG Scholars",
                'date_label'  => 'March - April 2020',
                'image'       => 'accomplishments/IpStudents.png',
                'extra_images'=> null,
                'layout_type' => 2,
                'year_group'  => '2020',
                'sort_order'  => 6,
                'is_active'   => true,
            ],
            [
                'title'       => 'Assistance relief during pandemic',
                'description' => 'Being a member of NE IATF, Dr. Donato B. Bumacas often meet with Municipal and City Mayors and advocated the prioritizing of ICCs/IPs in their distribution of Cash and Food Relief Goods distributions. Below were some of the results of Dr. Bumacas advocacies to LGU\'s in the service of ICCs/IPs during the COVID-19 Pandemic per LGU\'s.',
                'date_label'  => 'Calendar Year 2020',
                'image'       => 'accomplishments/IpAssistance1.png',
                'extra_images'=> [
                    'accomplishments/IpAssistance1.png',
                    'accomplishments/IpAssistance2.png',
                    'accomplishments/IpAssistance3.png',
                    'accomplishments/IpAssistance4.png',
                ],
                'layout_type' => 5,
                'year_group'  => '2020',
                'sort_order'  => 7,
                'is_active'   => true,
            ],

            // ── Year Group: 2019 ──────────────────────────────────────────────
            [
                'title'       => '1st Nueva Ecija IP Summit',
                'description' => 'Engr. Feliciana A. Jacoba – NEUST President; Atty. Ana Maria Paz B. Rafael-Banaag – Assistant Secretary of President Duterte; Atty. Basilio A. Wandag – Commissioner of NCIP; Atty. Gina Naimes – Representative of Regional Director Atty. Ronald M. Daquioag; and Dr. Donato B. Bumacas – DMO V / Provincial Officer of NCIP Nueva Ecija.',
                'date_label'  => 'October 10, 2019',
                'image'       => 'accomplishments/Ipsummitd.png',
                'extra_images'=> null,
                'layout_type' => 1,
                'year_group'  => '2019',
                'sort_order'  => 8,
                'is_active'   => true,
            ],

            // ── Year Group: 2017 ──────────────────────────────────────────────
            [
                'title'       => 'Provincial IP Day Celebrations',
                'description' => 'The innovative Indigenous Multi-Stakeholders Partnership (I\'M PART) led to the successful mobilization and implementation of the 20TH YEAR INDIGENOUS PEOPLES MONTH AND DAY CELEBRATION without any single centavo or fund from NCIP. Dr. Bumacas planned in advance the activity with the IPMRs where they agreed to conduct series of activities within the municipalities during the month of October 2017 then it will be highlighted on October 29, 2017 which is the exact date of the passage of IPRA on October 29, 1997. Dr. Bumacas launched the PADIT-SUBKAL, The Provincial Festival of Indigenous Peoples in the Province of Nueva Ecija. This is the first time and very historical among indigenous peoples in Nueva Ecija. It was agreed that the PADIT-SUBKAL will become an Annual Celebration.',
                'date_label'  => 'October 20, 2017',
                'image'       => 'accomplishments/Ipday1.png',
                'extra_images'=> [
                    'accomplishments/Ipday1.png',
                    'accomplishments/Ipday2.png',
                    'accomplishments/Ipday3.png',
                    'accomplishments/Ipday4.png',
                ],
                'layout_type' => 5,
                'year_group'  => '2017',
                'sort_order'  => 9,
                'is_active'   => true,
            ],
        ];

        foreach ($accomplishments as $item) {
            Accomplishment::updateOrCreate(
                ['title' => $item['title']],
                [
                    'description'  => $item['description'],
                    'date_label'   => $item['date_label'],
                    'image'        => $item['image'],
                    'extra_images' => $item['extra_images'],
                    'layout_type'  => $item['layout_type'],
                    'year_group'   => $item['year_group'],
                    'sort_order'   => $item['sort_order'],
                    'is_active'    => $item['is_active'],
                ]
            );
        }

        $this->command->info('✅ 9 accomplishments seeded successfully.');
    }
}
