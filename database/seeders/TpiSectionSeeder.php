<?php

namespace Database\Seeders;

use App\Models\TpiSection;
use Illuminate\Database\Seeder;

class TpiSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCountries = [
            ['code' => 'eg', 'name' => 'Egypt', 'url' => 'https://nen-global.org/eging', 'flag' => 'flag-icon-eg'],
            ['code' => 'om', 'name' => 'Oman', 'url' => 'https://nen-global.org/oming', 'flag' => 'flag-icon-om'],
            ['code' => 'sa', 'name' => 'KSA', 'url' => 'https://nen-global.org/saing', 'flag' => 'flag-icon-sa'],
            ['code' => 'kg', 'name' => 'Kyrgyzstan', 'url' => 'https://nen-global.org/kging', 'flag' => 'flag-icon-kg'],
            ['code' => 'uz', 'name' => 'Uzbekistan', 'url' => 'https://nen-global.org/uzing', 'flag' => 'flag-icon-uz'],
            ['code' => 'tj', 'name' => 'Tajikistan', 'url' => 'https://nen-global.org/tjing', 'flag' => 'flag-icon-tj'],
            ['code' => 'tr', 'name' => 'Turkey', 'url' => 'https://nen-global.org/tring', 'flag' => 'flag-icon-tr'],
            ['code' => 'az', 'name' => 'Azerbaijan', 'url' => 'https://nen-global.org/azing', 'flag' => 'flag-icon-az'],
            ['code' => 'ae', 'name' => 'UAE', 'url' => 'https://nen-global.org/aeing', 'flag' => 'flag-icon-ae'],
        ];

        TpiSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'title' => 'TOEFL IBT Practice Scholarship',
                'heading' => 'Practice. Train. Succeed.',
                'benefit1' => 'Limited Seats! Train for TOEFL with Expert Support',
                'benefit2' => 'Get 3 complete practice tests and unlimited mentoring — all for a refundable $10 deposit.',
                'cta_text' => 'Book now and take your official exam within 6 months!',
                'deposit_amount' => '$10',
                'practice_tests_count' => '3',
                'months_text' => '6 months',
                'apply_btn_text' => 'Apply Now',
                'learn_more_text' => 'Learn More',
                'learn_more_url' => url('/tpi'),
                'image' => 'site/images/tpi-hero.png',
                'countries' => $defaultCountries,
                'is_active' => true,
            ]
        );
    }
}
