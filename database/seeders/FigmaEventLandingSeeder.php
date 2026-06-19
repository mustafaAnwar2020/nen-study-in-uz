<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventLandingPage;
use App\Models\EventLandingSection;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FigmaEventLandingSeeder extends Seeder
{
    public function run(): void
    {
        // ----------------------------------------------------------------
        // 1. Create the base event (matches Figma "ETS International Conference Namangan")
        // ----------------------------------------------------------------
        $event = Event::query()->create([
            'slug' => Event::generateSlug(),
            'name' => 'ETS International Conference Namangan',
            'description' => 'Bringing TOEFL success from Namangan to the world. Opening university doors and creating global opportunities for every student',
            'image' => null,
            'date' => Carbon::parse('2026-06-16'),
            'time' => '9:00 - 13:30',
            'location' => 'MA\'RIFAT MASKANI, Namangan, Uzbekistan',
            'address' => 'Mashrab street B, 160109, Namangan, Namangan region, Uzbekistan',
            'book_now_url' => 'https://example.com/register',
            'country_code' => 'uz',
            'is_online' => false,
            'is_active' => true,
        ]);

        // ----------------------------------------------------------------
        // 2. Create landing page (enabled)
        // ----------------------------------------------------------------
        $page = EventLandingPage::query()->create([
            'event_id' => $event->id,
            'is_enabled' => true,
        ]);

        // ----------------------------------------------------------------
        // 3. Hero section (maps to Figma hero)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_HERO,
            'is_active' => true,
            'sort_order' => 0,
            'content' => [
                'title' => "ETS International Conference\nNamangan",
                'title_highlight' => 'Namangan',
                'description' => 'Bringing TOEFL success from Namangan to the world. Opening university doors and creating global opportunities for every student',
                'date_label' => '16 JUNE 2026, Tuesday',
                'time_label' => '9:00 - 14:00',
                'location_label' => "MA'RIFAT MASKANI, Namangan",
                'hero_image' => null,
                'qr_image' => null,
                'register_label' => 'Register',
                'agenda_label' => 'View Agenda',
                'agenda_url' => '#agenda',
                'countdown_at' => '2026-06-16 09:00:00',
                'countdown_end_at' => '2026-06-16 14:00:00',
                'whatsapp_url' => 'https://wa.me/+998908227567',
                'telegram_url' => 'https://t.me/username',
                'faq_url' => '#faq',
            ],
        ]);

        // ----------------------------------------------------------------
        // 4. About + Reasons section (maps to Figma "About the Conference" + "3 Main Reasons")
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_ABOUT_REASONS,
            'is_active' => true,
            'sort_order' => 1,
            'content' => [
                'about_label' => 'About the Conference',
                'about_title' => "A Global Conversation\nStarts in Namangan",
                'about_description' => "The ETS International Conference Namangan is a unique platform for educators, university staff, and local leaders to discover how TOEFL® opens global opportunities\n\nDiscover insights, connect with leaders, and gain practical tools to help more students achieve success.",
                'about_images' => [
                    'main' => null,
                    'secondary' => null,
                ],
                'reasons_label' => 'Why this conference',
                'reasons_title' => '3 Main Reasons to Join',
                'reasons_desc' => 'The ETS International Conference Namangan is a practical-minded event for those who want to move beyond theory. Over the course of one morning, we\'ll connect local teaching reality with international standards — from TOEFL strategies to real partnerships between NEN, ETS and Uzbekistan\'s educational institutions.',
                'reasons' => [
                    [
                        'icon' => 'bi-globe',
                        'title' => 'Global Opportunities Through TOEFL',
                        'description' => 'Learn how TOEFL IBT scores unlock admissions, scholarships, and career opportunities in 160+ countries.',
                    ],
                    [
                        'icon' => 'bi-people',
                        'title' => 'Connect With Key Decision-Makers',
                        'description' => 'Meet university representatives, rectors, and education leaders shaping the future of higher education.',
                    ],
                    [
                        'icon' => 'bi-tools',
                        'title' => 'Practical Tools & Partnerships',
                        'description' => 'Gain strategies, resources, and partnership opportunities to support student success and institutional growth.',
                    ],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 5. Stats section (maps to Figma stat bar)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_STATS,
            'is_active' => true,
            'sort_order' => 2,
            'content' => [
                'stats' => [
                    ['value' => '200+', 'label' => 'Attendees'],
                    ['value' => '10+', 'label' => 'Speakers'],
                    ['value' => '10+', 'label' => 'Universities'],
                    ['value' => '2', 'label' => 'Sessions'],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 6. Details + Map section (maps to Figma "Event Details" + map)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_DETAILS_MAP,
            'is_active' => true,
            'sort_order' => 3,
            'content' => [
                'label' => 'Event Details',
                'title' => 'Know more about our event',
                'description' => 'Join us for a half-day of insightful sessions, expert talks, and meaningful connections designed to empower students and institutions through TOEFL.',
                'date' => '16 JUNE 2026',
                'time' => '9:00 - 13:30 (GMT+5)',
                'venue' => "MA'RIFAT MASKANI",
                'address' => 'Mashrab street B, 160109, Namangan, Namangan region, Uzbekistan',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3039.0!2d71.6460!3d41.0054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sNamdu%20Universitet!5e0!3m2!1sen!2s!4v1',
            ],
        ]);

        // ----------------------------------------------------------------
        // 7. Speakers section (maps to Figma speakers list)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_SPEAKERS,
            'is_active' => true,
            'sort_order' => 4,
            'content' => [
                'section_label' => 'Meet our speakers',
                'speakers' => [
                    [
                        'name' => 'Abdurazakov Shavkat Shokirdjanovich',
                        'title' => 'Mayor of Namangan',
                        'photo' => null,
                        'org_logo' => null,
                    ],
                    [
                        'name' => 'Anna Gutkowska',
                        'title' => 'Regional Director Eurasia & Central Asia at ETS',
                        'photo' => null,
                        'org_logo' => null,
                    ],
                    [
                        'name' => 'Dr. Ilhom Abdurahmanov',
                        'title' => 'Higher Education Reform Expert, Vice Rector for International Cooperation, Namangan State Technical University',
                        'photo' => null,
                        'org_logo' => null,
                    ],
                    [
                        'name' => 'Dr. Shuxratjon ISMAILJONOV',
                        'title' => 'Higher Education Reform Expert, Associate professor at Namangan State institute of foreign languages',
                        'photo' => null,
                        'org_logo' => null,
                    ],
                    [
                        'name' => 'Mrs Sevarakhon Ikromova',
                        'title' => "UpGrade LA founder\nTeacher Trainer",
                        'photo' => null,
                        'org_logo' => null,
                    ],
                    [
                        'name' => 'Axadxon NAJMITDINOV',
                        'title' => 'Rector of TIU - Turan International University',
                        'photo' => null,
                        'org_logo' => null,
                    ],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 8. Agenda section (maps to Figma agenda)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_AGENDA,
            'is_active' => true,
            'sort_order' => 5,
            'content' => [
                'section_label' => 'Agenda',
                'items' => [
                    [
                        'time' => '08:30 - 09:00',
                        'title' => 'Registration & Welcome Coffee',
                        'icon' => 'bi-cup-hot-fill',
                    ],
                    [
                        'time' => '09:00 - 09:15',
                        'title' => 'Welcome speeches',
                        'icon' => 'bi-mic',
                    ],
                    [
                        'time' => '09:15 - 10:00',
                        'title' => 'TOEFL IBT: Opening Global Doors',
                        'icon' => 'bi-globe2',
                    ],
                    [
                        'time' => '10:00 - 10:45',
                        'title' => 'Panel Discussion: Higher Education Reform',
                        'icon' => 'bi-people-fill',
                    ],
                    [
                        'time' => '10:45 - 11:05',
                        'title' => 'Coffee Break & Networking',
                        'icon' => 'bi-cup-hot-fill',
                    ],
                    [
                        'time' => '11:05 - 12:00',
                        'title' => 'Partnership Opportunities with ETS',
                        'icon' => 'bi-gift-fill',
                    ],
                    [
                        'time' => '12:00 - 13:30',
                        'title' => 'Closing Session & Lunch',
                        'icon' => 'bi-flag-fill',
                    ],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 9. NEN organizers (homepage map + network stats)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_ORGANIZERS,
            'is_active' => true,
            'sort_order' => 6,
            'content' => [
                'section_label' => 'Organizers',
                'description' => "NEN | National Education Network is a strategic network established at 2008 and owned by 'NEN for Information Technology'. It has management offices in 13 countries, and extends its educational impact across 33 countries by providing professional training services and International Exams, through over 2,000+ accredited training centers, 4,000+ certified trainers, 550+ authorized testing centers, and 200+ Invigilators. To ensure a robust and globally recognized certificate for learning and assessment with a commitment to excellence.",
                'logo' => null,
                'btn_text' => 'Learn more',
                'btn_url' => 'https://www.nen-global.org/EN/index.html',
                'map_location_ids' => null,
                'network_stats' => [
                    ['title' => 'Students', 'value' => '2,1M+', 'icon' => 'bi-mortarboard', 'image' => null],
                    ['title' => 'Training Centers', 'value' => '2K+', 'icon' => null, 'image' => '/site/images/training_centers.png'],
                    ['title' => 'Certified Trainers', 'value' => '4K+', 'icon' => null, 'image' => '/site/images/sales.png'],
                    ['title' => 'Testing Centers', 'value' => '550+', 'icon' => null, 'image' => '/site/images/testing_centers.png'],
                    ['title' => 'Invigilators', 'value' => '200+', 'icon' => 'bi-person-bounding-box', 'image' => null],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 10. Partners section
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_PARTNERS,
            'is_active' => true,
            'sort_order' => 7,
            'content' => [
                'section_label' => 'Organizers & Partners',
                'partners' => [
                    [
                        'name' => 'Хокимият Наманганской области',
                        'logo' => null,
                    ],
                    [
                        'name' => 'Namangan State Technical University',
                        'logo' => null,
                    ],
                    [
                        'name' => 'Namangan state pedagogical institute',
                        'logo' => null,
                    ],
                ],
            ],
        ]);

        // ----------------------------------------------------------------
        // 11. Media section (near footer)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_MEDIA,
            'is_active' => true,
            'sort_order' => 8,
            'content' => [
                'section_label' => 'Media',
                'items' => [],
            ],
        ]);

        // ----------------------------------------------------------------
        // 12. FAQ section (maps to Figma FAQs)
        // ----------------------------------------------------------------
        EventLandingSection::query()->create([
            'event_landing_page_id' => $page->id,
            'type' => EventLandingSection::TYPE_LANDING_FAQ,
            'is_active' => true,
            'sort_order' => 9,
            'content' => [
                'section_label' => 'FAQs',
                'items' => [
                    [
                        'question' => 'Is there a fee to attend the conference?',
                        'answer' => 'No, the conference is completely free to attend. Registration is required to secure your seat.',
                    ],
                    [
                        'question' => 'Who should attend this conference?',
                        'answer' => 'Educators, university staff, local leaders, and anyone interested in TOEFL and international education opportunities.',
                    ],
                    [
                        'question' => 'Will there be translation services available?',
                        'answer' => 'Yes, simultaneous translation will be available for the main sessions.',
                    ],
                    [
                        'question' => 'Is payment secure?',
                        'answer' => 'Absolutely. All transactions are processed through trusted and secure payment gateways.',
                    ],
                    [
                        'question' => 'How can I register as a speaker?',
                        'answer' => 'Please contact us through WhatsApp or Telegram for speaker registration inquiries.',
                    ],
                    [
                        'question' => 'Can I get a certificate of attendance?',
                        'answer' => 'Yes, all attendees will receive a digital certificate of participation after the event.',
                    ],
                ],
            ],
        ]);

        $this->command->info('✅ Figma event landing seeded successfully!');
        $this->command->info("   Event ID: {$event->id}");
        $this->command->info("   Slug: {$event->slug}");
        $this->command->info('   Run: php artisan event:show-landing ' . $event->slug);
    }
}
