<?php

namespace Database\Seeders;

use App\Models\NenLandingAgency;
use App\Models\NenLandingDocument;
use App\Models\NenLandingFaqItem;
use App\Models\NenLandingFeatureCard;
use App\Models\NenLandingHowItWorksStep;
use App\Models\NenLandingSetting;
use App\Models\NenLandingUniversityLogo;
use Illuminate\Database\Seeder;

class NenLandingPageSeeder extends Seeder
{
    private string $base = 'site/home/assets';

    public function run(): void
    {
        $this->seedSettings();
        $this->seedFeatureCards();
        $this->seedHowItWorksSteps();
        $this->seedTranslationAgencies();
        $this->seedTrustedAgencies();
        $this->seedDocuments();
        $this->seedFaqs();
        $this->seedUniversityLogos();

        $this->call(NenLandingArabicSeeder::class);
    }

    private function seedSettings(): void
    {
        $landing = NenLandingSetting::getInstance();

        $landing->update([
            // Hero
            'hero_product_title'  => 'Uzbekistan.',
            'hero_subtitle'       => 'Join the ideal education network where students, top universities, and world-class programs meet! Get ready to start your academic success.',
            'hero_btn_text'       => 'Admission Centers',
            'hero_btn_url'        => '#collection-point',

            // About
            'about_label'        => 'About Program',
            'about_title'        => 'About Study In Uzbekistan?',
            'about_description'  => 'Study in Uzbekistan is an official initiative of the Ministry of Higher Education to attract international students to world-class universities. Through the official portal, you can explore programs, requirements, and scholarship opportunities.',
            'about_image_main'   => null,  // cleared — blade falls back to site/home/assets/img3.png
            'about_image'        => null,

            // Header / Nav
            'header_register_text' => 'Apply Now',
            'header_register_url'  => '#collection-point',
            'nav_about_url'        => '#about',
            'nav_events_url'       => '#why-uzbekistan',
            'nav_partners_url'     => '#how-it-works',
            'nav_contact_url'      => '#faq',

            // Contact
            'contact_email'      => 'admissions@nen-global.org',
            'footer_phone'       => '+20 10 6160 0400',
            'footer_tagline'     => 'NEN | National Education Network, the official Middle East partner of the Ministry of Higher Education and the Study in Uzbekistan Initiative, connects students with internationally recognized universities and outstanding educational opportunities across Uzbekistan.',
            'footer_copyright'   => 'Copyright © ' . date('Y') . ' NEN | National Education Network',

            // New section titles / subtitles
            'features_title'            => 'Why Study In Uzbekistan?',
            'features_subtitle'         => 'Discover the advantages of world-class education in Uzbekistan',
            'how_it_works_title'        => 'Your Study Journey Starts Here',
            'how_it_works_subtitle'     => 'From registration to obtaining your visa, we guide you step by step toward studying in Uzbekistan.',
            'how_it_works_btn_text'     => 'Apply Now',
            'how_it_works_btn_url'      => '#collection-point',
            'milestones_title'          => 'About NEN',
            'milestones_subtitle'       => '',
            'milestones_description'    => '',
            'milestones_cta_text'       => 'Admission Centers',
            'milestones_cta_url'        => '#collection-point',
            'agencies_title'            => 'Certified Translation Agencies',
            'agencies_subtitle'         => 'Translate your official documents quickly and securely through our network of trusted, certified translation offices.',
            'documents_title'           => 'Required Application Documents',
            'documents_subtitle'        => 'Prepare your official papers to complete your university application smoothly.',
            'trusted_agencies_title'    => 'Trusted Study Abroad Agencies',
            'trusted_agencies_subtitle' => 'Connect with certified consultants to simplify your university admission.',
            'faq_title'                 => 'Frequently Asked Questions',
            'university_logos_title'    => 'Success Partners',
        ]);
    }

    private function seedFeatureCards(): void
    {
        $cards = [
            [
                'stat_value'  => '100+',
                'stat_label'  => 'Universities',
                'title'       => 'Quality Education',
                'description' => 'Internationally recognized universities offering a modern learning environment and diverse English-taught academic programs.',
                'image'       => $this->base . '/row/row-group1.png',
                'sort_order'  => 0,
            ],
            [
                'stat_value'  => '50%',
                'stat_label'  => 'Cost Savings',
                'title'       => 'Affordable Tuition & Living',
                'description' => 'Students can save up to 50% on tuition and living costs compared to many other study destinations.',
                'image'       => $this->base . '/row/row-group2.png',
                'sort_order'  => 1,
            ],
            [
                'stat_value'  => '50+',
                'stat_label'  => 'Nationalities',
                'title'       => 'Diverse International Environment',
                'description' => 'A growing international student community with students from various nationalities, and an increasing number of English-taught programs.',
                'image'       => $this->base . '/row/row-group3.png',
                'sort_order'  => 2,
            ],
            [
                'stat_value'  => '100%',
                'stat_label'  => 'Safety Index',
                'title'       => 'Safe & Welcoming Environment',
                'description' => 'A safe country welcoming international students, combining quality of life, rich cultural heritage, and an outstanding educational experience.',
                'image'       => $this->base . '/row/row-group4.png',
                'sort_order'  => 3,
            ],
        ];

        foreach ($cards as $card) {
            NenLandingFeatureCard::query()->updateOrCreate(
                ['sort_order' => $card['sort_order']],
                array_merge($card, ['is_active' => true])
            );
        }
    }

    private function seedHowItWorksSteps(): void
    {
        $steps = [
            [
                'step_number' => 1,
                'title'       => 'Registration',
                'description' => 'Create your account on the Study in Uzbekistan portal.',
                'image'       => $this->base . '/component/component-presentation.png',
            ],
            [
                'step_number' => 2,
                'title'       => 'Choose Your Major & University',
                'description' => 'Select the university and program that match your academic goals.',
                'image'       => $this->base . '/component/component-university.png',
            ],
            [
                'step_number' => 3,
                'title'       => 'Submit Documents',
                'description' => 'Prepare and submit the required documents through accredited admission centers.',
                'image'       => $this->base . '/component/component-files.png',
            ],
            [
                'step_number' => 4,
                'title'       => 'Document Verification',
                'description' => 'We review and verify your documents and coordinate with the relevant authorities.',
                'image'       => null,
            ],
            [
                'step_number' => 5,
                'title'       => 'Admission Process',
                'description' => 'Track your application status and receive admission updates and support throughout the process.',
                'image'       => $this->base . '/component/component-checkmark.png',
            ],
            [
                'step_number' => 6,
                'title'       => 'Obtain Your Visa',
                'description' => 'Complete your visa procedures and get ready to begin your study journey in Uzbekistan.',
                'image'       => $this->base . '/component/component-folder-view.png',
            ],
        ];

        foreach ($steps as $i => $step) {
            NenLandingHowItWorksStep::query()->updateOrCreate(
                ['step_number' => $step['step_number']],
                array_merge($step, [
                    'sort_order' => $i,
                    'is_active'  => true,
                ])
            );
        }
    }

    private function seedTranslationAgencies(): void
    {
        if (NenLandingAgency::query()->where('type', NenLandingAgency::TYPE_TRANSLATION)->count() > 0) {
            return;
        }

        $agencies = [
            [
                'name'                => 'ArabTrans Egypt',
                'service_description' => 'Certified Translation Services',
                'location'            => 'Cairo',
                'phone'               => '+20 1212811805',
                'image'               => $this->base . '/frame/frame-img5.png',
                'sort_order'          => 0,
            ],
            [
                'name'                => 'Alex Docs',
                'service_description' => 'Academic & Legal Translation',
                'location'            => 'Alexandria',
                'phone'               => '+20 1008765432',
                'image'               => $this->base . '/frame/frame-img6.png',
                'sort_order'          => 1,
            ],
            [
                'name'                => 'Giza Translate',
                'service_description' => 'Official Document Translation Center',
                'location'            => 'Giza',
                'phone'               => '+20 1097654321',
                'image'               => $this->base . '/frame/frame-img7.png',
                'sort_order'          => 2,
            ],
            [
                'name'                => 'Future Translate',
                'service_description' => 'Certified Translation Solutions',
                'location'            => 'Cairo',
                'phone'               => '+20 1015556666',
                'image'               => $this->base . '/frame/frame-img8.png',
                'sort_order'          => 3,
            ],
        ];

        foreach ($agencies as $agency) {
            NenLandingAgency::query()->create(array_merge($agency, [
                'type'      => NenLandingAgency::TYPE_TRANSLATION,
                'is_active' => true,
            ]));
        }
    }

    private function seedTrustedAgencies(): void
    {
        if (NenLandingAgency::query()->where('type', NenLandingAgency::TYPE_TRUSTED)->count() > 0) {
            return;
        }

        $agencies = [
            ['name' => 'TOP EDU',       'location' => 'Giza',       'phone' => '+20 1097654321', 'sort_order' => 0],
            ['name' => 'EduBridge',     'location' => 'Cairo',      'phone' => '+20 1012345678', 'sort_order' => 1],
            ['name' => 'StudyGo',       'location' => 'Alexandria', 'phone' => '+20 1098765432', 'sort_order' => 2],
            ['name' => 'GlobalAdmit',   'location' => 'Cairo',      'phone' => '+20 1056789012', 'sort_order' => 3],
            ['name' => 'UniPath Egypt', 'location' => 'Giza',       'phone' => '+20 1034567890', 'sort_order' => 4],
            ['name' => 'Academia Plus', 'location' => 'Alexandria', 'phone' => '+20 1078901234', 'sort_order' => 5],
            ['name' => 'Future Gate',   'location' => 'Cairo',      'phone' => '+20 1023456789', 'sort_order' => 6],
            ['name' => 'Bright Paths',  'location' => 'Giza',       'phone' => '+20 1087654321', 'sort_order' => 7],
        ];

        foreach ($agencies as $agency) {
            NenLandingAgency::query()->create(array_merge($agency, [
                'type'                => NenLandingAgency::TYPE_TRUSTED,
                'service_description' => 'Study Abroad Consultancy',
                'image'               => $this->base . '/card/card-whats-app.png',
                'whatsapp_url'        => '#',
                'is_active'           => true,
            ]));
        }
    }

    private function seedDocuments(): void
    {
        if (NenLandingDocument::query()->count() > 0) {
            return;
        }

        $documents = [
            ['title' => 'Valid Passport',                              'image' => $this->base . '/card/card-img1.png', 'sort_order' => 0],
            ['title' => 'Secondary School Certificate',                'image' => $this->base . '/card/card-img2.png', 'sort_order' => 1],
            ['title' => 'Language Certificate (If available)',         'image' => $this->base . '/card/card-img3.png', 'sort_order' => 2],
            ['title' => 'National ID Card',                            'image' => $this->base . '/card/card-img4.png', 'sort_order' => 3],
            ['title' => 'Academic Transcripts',                        'image' => $this->base . '/card/card-img5.png', 'sort_order' => 4],
            ['title' => 'Medical Certificate (If required)',           'image' => $this->base . '/card/card-img6.png', 'sort_order' => 5],
            ['title' => 'Passport Size Photos',                        'image' => $this->base . '/card/card-img7.png', 'sort_order' => 6],
            ['title' => "Bachelor's Degree (For Postgraduate Applicants)", 'image' => $this->base . '/card/card-img8.png', 'sort_order' => 7],
            ['title' => 'Original documents required for immediate verification.', 'image' => $this->base . '/card/card-img9.png', 'sort_order' => 8],
        ];

        foreach ($documents as $doc) {
            NenLandingDocument::query()->create(array_merge($doc, ['is_active' => true]));
        }
    }

    private function seedFaqs(): void
    {
        if (NenLandingFaqItem::query()->count() > 0) {
            return;
        }

        $faqs = [
            ['question' => 'Are the degrees globally accredited and recognized?',                  'answer' => 'Yes. All universities listed on the Study in Uzbekistan portal hold international accreditation recognized by global academic bodies.'],
            ['question' => 'What languages are used for teaching programs?',                        'answer' => 'Programs are offered in Uzbek, Russian, and English, depending on the university and faculty chosen.'],
            ['question' => 'Does this scholarship cover all living expenses?',                      'answer' => 'Fully funded scholarships cover tuition, campus accommodation, and a monthly stipend. Partial scholarships may cover tuition only.'],
            ['question' => 'How long does the application process take?',                           'answer' => 'The standard application process takes between 4 to 8 weeks from document submission to admission confirmation.'],
            ['question' => 'What are the scholarship requirements and how to apply?',               'answer' => 'Scholarships are fully funded programs that cover tuition, campus accommodation, and monthly stipends without hidden fees. Students learn and develop skills through advanced academic structures over time.'],
            ['question' => 'Can I update my documents after submission?',                           'answer' => 'Document updates are accepted within 48 hours of the initial submission. Contact your NEN collection point for assistance.'],
            ['question' => 'Is there any age limit for applicants?',                               'answer' => 'Undergraduate programs accept applicants aged 17–25. Postgraduate programs have no strict upper age limit.'],
        ];

        foreach ($faqs as $i => $faq) {
            NenLandingFaqItem::query()->create(array_merge($faq, ['sort_order' => $i, 'is_active' => true]));
        }
    }

    private function seedUniversityLogos(): void
    {
        if (NenLandingUniversityLogo::query()->count() > 0) {
            return;
        }

        $logos = [
            'Tashkent State Technical University',
            'Samarkand State University',
            'National University of Uzbekistan',
            'Turin Polytechnic University in Tashkent',
            'Inha University in Tashkent',
            'Webster University Tashkent',
            'Kimyo International University',
            'Fergana Polytechnic Institute',
            'Andijan State University',
        ];

        foreach ($logos as $i => $name) {
            NenLandingUniversityLogo::query()->create([
                'name'       => $name,
                'image'      => $this->base . '/mask-group.png',
                'url'        => '#',
                'sort_order' => $i,
                'is_active'  => true,
            ]);
        }
    }
}
