<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['code' => 'eg', 'name' => 'Egypt', 'flag_icon' => 'flag-icon-eg', 'registration_url' => 'https://nen-global.org/egets', 'sort_order' => 1],
            ['code' => 'sa', 'name' => 'Saudi Arabia', 'flag_icon' => 'flag-icon-sa', 'registration_url' => 'https://nen-global.org/saets', 'sort_order' => 2],
            ['code' => 'ae', 'name' => 'United Arab Emirates', 'flag_icon' => 'flag-icon-ae', 'registration_url' => 'https://nen-global.org/aeets', 'sort_order' => 3],
            ['code' => 'om', 'name' => 'Oman', 'flag_icon' => 'flag-icon-om', 'registration_url' => 'https://nen-global.org/omets', 'sort_order' => 4],
            ['code' => 'uz', 'name' => 'Uzbekistan', 'flag_icon' => 'flag-icon-uz', 'registration_url' => 'https://nen-global.org/uzets', 'sort_order' => 5],
            ['code' => 'az', 'name' => 'Azerbaijan', 'flag_icon' => 'flag-icon-az', 'registration_url' => 'https://nen-global.org/azets', 'sort_order' => 6],
            ['code' => 'de', 'name' => 'Germany', 'flag_icon' => 'flag-icon-de', 'registration_url' => 'https://nen-global.org/deets', 'sort_order' => 7],
            ['code' => 'tr', 'name' => 'Turkey', 'flag_icon' => 'flag-icon-tr', 'registration_url' => 'https://nen-global.org/trets', 'sort_order' => 8],
            ['code' => 'kg', 'name' => 'Kyrgyzstan', 'flag_icon' => 'flag-icon-kg', 'registration_url' => 'https://nen-global.org/kgets', 'sort_order' => 9],
            ['code' => 'jo', 'name' => 'Jordan', 'flag_icon' => 'flag-icon-jo', 'registration_url' => 'https://nen-global.org/joets', 'sort_order' => 10],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}
