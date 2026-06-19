<?php

namespace Database\Seeders;

use App\Models\TpiHeroSection;
use Illuminate\Database\Seeder;

class TpiHeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        TpiHeroSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'title' => 'TOEFL IBT Practice Scholarship',
                'subtitle' => 'Practice. Train. Succeed.',
                'image' => 'site/images/tpi-hero.jpg',
                'apply_btn_text' => 'Apply Now',
                'countries' => TpiHeroSection::getDefaultCountries(),
                'nearest_center_text' => 'Nearest Center',
                'nearest_center_url' => '#authorized-centers',
                'is_active' => true,
            ]
        );
    }
}
