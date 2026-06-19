<?php

namespace Database\Seeders;

use App\Models\TpiJoinPartnerSection;
use Illuminate\Database\Seeder;

class TpiJoinPartnerSectionSeeder extends Seeder
{
    public function run(): void
    {
        TpiJoinPartnerSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'section_title' => 'Join as Partner',
                'items' => TpiJoinPartnerSection::getDefaultItems(),
                'is_active' => true,
            ]
        );
    }
}
