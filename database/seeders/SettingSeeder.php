<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{

    public function run()
    {
        $settings = [
            [
                'created_at' => now(),
                'updated_at' => now(),
                'key' => 'social',
                'value' => json_encode([
                    'facebook' => 'https://www.facebook.com/nenglobal',
                    'twitter' => 'https://x.com/NationalED',
                    'instagram' => 'https://www.instagram.com/nenglobal',
                    'linkedin' => 'https://www.linkedin.com/company/nenglobal',
                    'youtube' => 'https://www.youtube.com/@NENNationalEducationNetwork',
                    'tiktok' => 'https://tiktok.com',
                    'whatsapp' => '961313213',
                    'telegram' => 'username',
                    'floating_whatsapp' => [
                        ['title' => 'Main', 'number' => '961313213']
                    ],
                    'floating_telegram' => [
                        ['title' => 'Support', 'username' => 'username']
                    ]
                ])
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'key' => 'general',
                'value' => json_encode([
                    'site_name' => 'NEN',
                    'site_about' => 'a global education and talent solutions organization enabling lifelong learners to be future ready. We advance the science of measurement to build the benchmarks for fair and valid skill assessment. We are committed to powering human progress by promoting skill proficiency, empowering upward mobility and unlocking more opportunities for everyone, everywhere.',
                    'open_hours' => 'Monday - Friday | 9:00AM - 05:00PM',
                    'phone' => '966321231233',
                    'phone2' => '9661213133',
                    'phone3' => '9661213133',
                    'email' => 'info@nen-global.org',
                    'cs_email' => 'cs@nen-global.org',
                    'support_email' => 'support@nen-global.org',
                    'acc_email' => 'acc@nen-global.org',
                    'sales_email' => 'sales@nen-global.org',
                    'tca_email' => 'tca@nen-global.org',
                    'fax' => '00971-asdc-18-12-60',
                    'iban' => '21231321154545121323313',
                    'address' => 'Eg, address, test address',
                ])
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'key' => 'media',
                'value' => json_encode([
                    'logo' => '/assets/logo.png',
                    'ets_logo' => '/assets/ets-svg.svg',
                    'fav_icon' => '/assets/favicon.png',
                ])
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'key' => 'flags_text',
                'value' => json_encode([
                    'text' => 'Click on flags to search for partners in your region',
                ])
            ],
        ];

        DB::table('settings')->insert($settings);
    }
}
