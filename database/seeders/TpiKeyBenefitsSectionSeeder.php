<?php

namespace Database\Seeders;

use App\Models\TpiKeyBenefitsSection;
use Illuminate\Database\Seeder;

class TpiKeyBenefitsSectionSeeder extends Seeder
{
    public function run(): void
    {
        TpiKeyBenefitsSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'section_title' => 'Key Benefits',
                'items' => TpiKeyBenefitsSection::getDefaultItems(),
                'is_active' => true,
            ]
        );
    }
}
