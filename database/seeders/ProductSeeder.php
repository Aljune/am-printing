<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::truncate();

        $defaults = [
            // Printing Services
            [
                'name' => 'B&W Printing – Short/Letter',
                'description' => '₱5–8 per page, black & white, short/letter size.',
                'price' => 5,
                'category' => 'printing',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored Printing – Short/Letter',
                'description' => '₱10–15 per page, full color, short/letter size.',
                'price' => 10,
                'category' => 'printing',
                'subcategory' => null,
            ],
            [
                'name' => 'B&W Printing – A4/Long',
                'description' => '₱5–8 per page, black & white, A4/long size.',
                'price' => 5,
                'category' => 'printing',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored Printing – A4/Long',
                'description' => '₱10–15 per page, full color, A4/long size.',
                'price' => 10,
                'category' => 'printing',
                'subcategory' => null,
            ],

            // Photocopy Services
            [
                'name' => 'B&W Photocopy – Short/Letter',
                'description' => '₱3–5 per page, black & white, short/letter size.',
                'price' => 3,
                'category' => 'photocopy',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored Photocopy – Short/Letter',
                'description' => '₱5–10 per page, full color, short/letter size.',
                'price' => 5,
                'category' => 'photocopy',
                'subcategory' => null,
            ],
            [
                'name' => 'B&W Photocopy – A4/Long',
                'description' => '₱3–5 per page, black & white, A4/long size.',
                'price' => 3,
                'category' => 'photocopy',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored Photocopy – A4/Long',
                'description' => '₱5–10 per page, full color, A4/long size.',
                'price' => 5,
                'category' => 'photocopy',
                'subcategory' => null,
            ],

            // Scanning Services
            [
                'name' => 'Standard Document Scan – Short/Letter',
                'description' => '₱5 per page, standard scan, short/letter size.',
                'price' => 5,
                'category' => 'scan',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored / High Quality Scan – Short/Letter',
                'description' => '₱10 per page, colored/high-quality scan, short/letter size.',
                'price' => 10,
                'category' => 'scan',
                'subcategory' => null,
            ],
            [
                'name' => 'Standard Document Scan – A4/Long',
                'description' => '₱5 per page, standard scan, A4/long size.',
                'price' => 5,
                'category' => 'scan',
                'subcategory' => null,
            ],
            [
                'name' => 'Colored / High Quality Scan – A4/Long',
                'description' => '₱10 per page, colored/high-quality scan, A4/long size.',
                'price' => 10,
                'category' => 'scan',
                'subcategory' => null,
            ],

            // Rush ID
            [
                'name' => 'Rush ID, 1x1 & 2x2',
                'description' => 'Same-day photo ID, printed and cut, set of 4.',
                'price' => 60,
                'category' => 'rushid',
                'subcategory' => null,
            ],

            // Laminations
            [
                'name' => 'Lamination, A4',
                'description' => 'Hot lamination, clear film, per sheet.',
                'price' => 25,
                'category' => 'lamination',
                'subcategory' => null,
            ],

            // Template Design
            [
                'name' => 'Birthday invitation design',
                'description' => 'Custom layout, 1 revision, print-ready file.',
                'price' => 150,
                'category' => 'template',
                'subcategory' => 'birthday',
            ],
            [
                'name' => 'Wedding invitation suite',
                'description' => 'Invite + RSVP card, matching design, 2 revisions.',
                'price' => 350,
                'category' => 'template',
                'subcategory' => 'wedding',
            ],
            [
                'name' => 'Christening invitation design',
                'description' => 'Custom layout with baby motif, 1 revision.',
                'price' => 150,
                'category' => 'template',
                'subcategory' => 'christening',
            ],
            [
                'name' => 'Anniversary card design',
                'description' => 'Personalized card design, print-ready file.',
                'price' => 120,
                'category' => 'template',
                'subcategory' => 'anniversary',
            ],
        ];

        foreach ($defaults as $item) {
            Product::create(array_merge($item, [
                'image_url' => null,
                'image_path' => null,
                'video_url' => null,
                'video_path' => null,
            ]));
        }

        $this->command->info('AM Printing products seeded successfully!');
    }
}