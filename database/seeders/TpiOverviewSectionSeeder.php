<?php

namespace Database\Seeders;

use App\Models\TpiOverviewSection;
use Illuminate\Database\Seeder;

class TpiOverviewSectionSeeder extends Seeder
{
    public function run(): void
    {
        TpiOverviewSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'section_title' => 'What Is the TOEFL IBT Practice Scholarship?',
                'lead' => 'This scholarship provides a complete TOEFL practice experience at zero cost.',
                'intro_paragraph' => 'Participants pay a temporary, refundable deposit, receive full TOEFL practice sessions and mentor guidance, and recover the deposit after completing the program.',
                'benefits' => TpiOverviewSection::getDefaultBenefits(),
                'student_image' => 'site/images/toefl-students-celebrating.jpeg',
                'features' => TpiOverviewSection::getDefaultFeatures(),
                'is_active' => true,
            ]
        );
    }
}
