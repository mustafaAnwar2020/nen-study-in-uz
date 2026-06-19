<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run()
    {

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'nen-sec',
            'title' => 'NEN',
            'description' => 'Distributor/ Authorized Reseller: A trusted partner authorized to market, promote, and distribute the company\'s products and services to reach a wider audience and maximize impact.',
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'about-ets',
            'title' => 'About ETS',
            'description' => 'a global education and talent solutions organization enabling lifelong
            learners to be future ready. We advance the science of measurement to
            build the benchmarks for fair and valid skill assessment. We are
            committed to powering human progress by promoting skill proficiency,
            empowering upward mobility and unlocking more opportunities for
            everyone, everywhere.',
            'image' => '/site/about.jpg',
            'btn_text' => 'Learn More',
            'btn_url' => 'https://www.ets.org/',
        ]);

        $testDayList = [
            [
                'icon' => 'briefcase',
                'title' => 'Duis aute irure dolor in reprehend',
                'desc' => 'Duis aute irure dolor in reprehend Duis aute irure dolor in reprehend',
            ],
            [
                'icon' => 'gem',
                'title' => 'Duis aute irure dolor in reprehend',
                'desc' => 'Duis aute irure dolor in reprehend Duis aute irure dolor in reprehend',
            ],
            [
                'icon' => 'broadcast',
                'title' => 'Duis aute irure dolor in reprehend',
                'desc' => 'Duis aute irure dolor in reprehend Duis aute irure dolor in reprehend',
            ],
            [
                'icon' => 'easel',
                'title' => 'Duis aute irure dolor in reprehend',
                'desc' => 'Duis aute irure dolor in reprehend Duis aute irure dolor in reprehend',
            ]
        ];

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'test-day',
            'title' => 'Test Day',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/cta-bg.jpg',
            'btn_text' => 'Learn More',
            'btn_url' => 'https://www.ets.org/',
            'list_items' => json_encode($testDayList)
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'verify',
            'title' => 'Verify',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/verifiy.jpg',
            'btn_text' => 'Check Certificate',
            'btn_url' => 'https://www.ets.org/',
        ]);


        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'join-teachers',
            'title' => 'Want to join our teachers?',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/joins/working-1.jpg',
            'btn_text' => 'Join Us',
            'type' => 'joins',
            'btn_url' => 'https://www.ets.org/',
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'join-center',
            'title' => 'Want to join our center?',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/joins/working-2.jpg',
            'btn_text' => 'Join Us',
            'type' => 'joins',
            'btn_url' => 'https://www.ets.org/',
        ]);


        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'join-partners',
            'title' => 'Want to join our partners?',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/joins/working-3.jpg',
            'btn_text' => 'Join Us',
            'type' => 'joins',
            'btn_url' => 'https://www.ets.org/',
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'join-proctors',
            'title' => 'Want to join our proctors?',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/joins/working-4.jpg',
            'btn_text' => 'Join Us',
            'type' => 'joins',
            'btn_url' => 'https://www.ets.org/',
        ]);


        // products tabs
        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'TOEFL-IBT',
            'product_id' => '1',
            'title' => 'TOEFL IBT',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/partners-bg.jpg',
            'btn_text' => 'Learn more',
            'btn_url' => 'https://www.ets.org/',
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'TOEFL-ITP',
            'product_id' => '2',
            'title' => 'TOEFL ITP',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/partners-bg.jpg',
            'btn_text' => 'Learn more',
            'btn_url' => 'https://www.ets.org/',
        ]);


        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'TOEIC',
            'product_id' => '3',
            'title' => 'TOEIC',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/partners-bg.jpg',
            'btn_text' => 'Learn more',
            'btn_url' => 'https://www.ets.org/',
        ]);

        Section::query()->create([
            'slug' => Section::generateSlug(),
            'key' => 'GRE',
            'product_id' => '4',
            'title' => 'GRE',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'image' => '/site/images/partners-bg.jpg',
            'btn_text' => 'Learn more',
            'btn_url' => 'https://www.ets.org/',
        ]);


    }
}
