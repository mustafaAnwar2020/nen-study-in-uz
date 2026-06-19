<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'TOEFL IBT',
            'description' => 'TOEFL IBT description',
            'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
            'type' => 'assessment',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'TOEFL ITP',
            'description' => 'TOEFL ITP description',
            'url' => 'https://www.ets.org/toefl/itp.html',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org/toefl/itp.html',
            'type' => 'assessment',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'TOEIC',
            'description' => 'TOEIC description',
            'url' => 'https://www.ets.org/toeic.html',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org/toeic.html',
            'type' => 'assessment',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'GRE',
            'description' => 'GRE description',
            'url' => 'https://www.ets.org/gre.html',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org/gre.html',
            'type' => 'assessment',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        // preparation

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'Official TOEFL iBT® Prep Course',
            'description' => 'Official TOEFL iBT® Prep Course description',
            'url' => 'https://www.ets.org',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org',
            'type' => 'preparation',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'Mock Tests Course',
            'description' => 'Mock Tests description',
            'url' => 'https://www.ets.org',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org',
            'type' => 'preparation',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

        Product::query()->create([
            'slug' => Product::generateSlug(),
            'name' => 'TOEFL Certificate',
            'description' => 'TOEFL Certificate description',
            'url' => 'https://www.ets.org',
            'book_now_url' => json_encode([
                    [
                        'country' => 'eg',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ],
                    [
                        'country' => 'us',
                        'url' => 'https://www.ets.org/toefl/test-takers/ibt/about.html',
                    ]
                ]
            ),
            'more_link' => 'https://www.ets.org',
            'type' => 'certificates',
            'is_active' => true,
            'country_list_file' => 'https://google.com',
            'become_partner_url' => 'https://google.com',
        ]);

    }
}
