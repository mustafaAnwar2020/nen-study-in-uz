<?php

namespace Database\Seeders;

use App\Models\NenLandingEventItem;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingHeroSlide;
use App\Models\NenLandingMediaItem;
use App\Models\NenLandingPartnerItem;
use App\Models\NenLandingSetting;
use Illuminate\Database\Seeder;

class NenLandingSeeder extends Seeder
{
    public function run(): void
    {
        $landing = NenLandingSetting::getInstance();

        if (NenLandingHeroSlide::query()->count() === 0) {
            NenLandingHeroSlide::query()->create([
                'title' => $landing->hero_product_title,
                'subtitle' => $landing->hero_subtitle,
                'image' => $landing->hero_image,
                'btn_text' => $landing->hero_btn_text,
                'btn_url' => $landing->hero_btn_url,
                'sort_order' => 0,
                'is_active' => true,
            ]);
        }

        if (NenLandingPartnerItem::query()->count() === 0) {
            $partners = [
                ['name' => 'Namangan Regional Administration', 'description' => 'More information about it', 'image' => 'site/images/nen-landing/partner-1.png', 'sort_order' => 0],
                ['name' => 'Namangan State Technical University', 'description' => 'Namangan State Technical University', 'image' => 'site/images/nen-landing/partner-2.png', 'sort_order' => 1],
                ['name' => 'Namangan state pedagogical institute', 'description' => 'Namangan state pedagogical institute', 'sort_order' => 2],
            ];
            foreach ($partners as $p) {
                NenLandingPartnerItem::query()->create(array_merge($p, ['is_active' => true]));
            }
        }

        if (NenLandingEventItem::query()->count() === 0) {
            NenLandingEventItem::query()->create([
                'type' => NenLandingEventItem::TYPE_HIGHLIGHT,
                'title' => 'ETS International Conference Namangan',
                'description' => 'Bringing TOEFL success from Namangan to the world.',
                'event_date' => '2026-06-16',
                'sort_order' => 0,
                'is_active' => true,
            ]);
            foreach (['Namangan Teacher Summit 2025', 'TOEFL Workshop Series'] as $i => $title) {
                NenLandingEventItem::query()->create([
                    'type' => NenLandingEventItem::TYPE_ARCHIVE,
                    'title' => $title,
                    'description' => 'Discover Unique Educational Journeys with Us',
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }

        if (NenLandingFaqItem::query()->count() === 0) {
            $faqs = [
                ['question' => 'Is there a fee to attend the conference?', 'answer' => 'Registration details vary by event. Please check the event page for pricing.'],
                ['question' => 'Can I return or exchange products', 'answer' => 'Yes, you can return or exchange items within 14 days, provided they are in their original condition.'],
                ['question' => 'Is payment secure?', 'answer' => 'Absolutely. All transactions are processed through trusted and secure payment gateways.'],
            ];
            foreach ($faqs as $i => $faq) {
                NenLandingFaqItem::query()->create(array_merge($faq, ['sort_order' => $i, 'is_active' => true]));
            }
        }

        if (NenLandingMediaItem::query()->count() === 0) {
            $slots = [
                NenLandingMediaItem::SLOT_LEFT_TOP,
                NenLandingMediaItem::SLOT_LEFT_BOTTOM,
                NenLandingMediaItem::SLOT_CENTER,
                NenLandingMediaItem::SLOT_RIGHT_TOP,
                NenLandingMediaItem::SLOT_RIGHT_BOTTOM,
            ];
            foreach ($slots as $i => $slot) {
                NenLandingMediaItem::query()->create([
                    'caption' => 'Gallery image ' . ($i + 1),
                    'layout_slot' => $slot,
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }
    }
}
