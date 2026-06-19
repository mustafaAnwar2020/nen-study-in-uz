<?php

namespace Database\Seeders;

use App\Models\TpiContactSection;
use Illuminate\Database\Seeder;

class TpiContactSectionSeeder extends Seeder
{
    public function run(): void
    {
        TpiContactSection::query()->firstOrCreate(
            ['id' => 1],
            [
                'section_title' => 'CONTACT',
                'title_highlight' => 'US',
                'phone_cards' => TpiContactSection::getDefaultPhoneCards(),
                'social_card' => TpiContactSection::getDefaultSocialCard(),
                'email_cards' => TpiContactSection::getDefaultEmailCards(),
                'is_active' => true,
            ]
        );
    }
}
