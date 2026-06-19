<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NenLandingSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active'             => 'boolean',
        'featured_event_id'     => 'integer',
        'show_hero'             => 'boolean',
        'show_about'            => 'boolean',
        'show_events'           => 'boolean',
        'show_archive'          => 'boolean',
        'show_features'         => 'boolean',
        'show_how_it_works'     => 'boolean',
        'show_milestones'       => 'boolean',
        'show_agencies'         => 'boolean',
        'show_documents'        => 'boolean',
        'show_trusted_agencies' => 'boolean',
        'show_partners'         => 'boolean',
        'show_university_logos' => 'boolean',
        'show_media'            => 'boolean',
        'show_faq'              => 'boolean',
        'show_contact'          => 'boolean',
    ];

    public function featuredEvent(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'featured_event_id');
    }

    public static function getInstance(): self
    {
        return static::firstOrCreate([], static::getDefaults());
    }

    public static function getDefaults(): array
    {
        return [
            // Hero
            'hero_product_title'  => 'TOEFL Primary® Tests',
            'hero_subtitle'       => 'Put Your Students On The Right Path, Right From The Start',
            'hero_image'          => 'site/images/nen-landing/hero-bg.png',
            'hero_btn_text'       => 'Book now',
            'hero_btn_url'        => '#contact',

            // About
            'about_label'            => 'About NEN',
            'about_title'            => 'Educational Transformation Leadership in Namangan',
            'about_description'      => 'NEN | National Education Network is a strategic network established@2008 and owned by "NEN for Information Technology". It has management offices in 13 countries, and extends its educational impact across the region.',
            'about_image'            => 'site/images/nen-landing/about.jpg',
            'about_stat_value'       => '15+',
            'about_stat_label'       => 'Years of Distinction',
            'about_metric1_value'    => '10k+',
            'about_metric1_label'    => 'Beneficiary Student',
            'about_metric2_value'    => '50+',
            'about_metric2_label'    => 'Partner Institution',
            'about_image_main'       => 'site/images/nen-landing/about-main.jpg',
            'about_image_secondary'  => 'site/images/nen-landing/about-secondary.jpg',
            'about_image_side'       => 'site/images/nen-landing/about-side.jpg',

            // Events / Archive
            'highlights_title'    => 'Upcoming Highlights Events',
            'highlights_subtitle' => 'Discover Unique Educational Journeys with Us',
            'archive_title'       => 'Archive of Previous Events',
            'archive_subtitle'    => 'Discover Unique Educational Journeys with Us',
            'archive_btn_text'    => 'View all Archive',
            'archive_btn_url'     => '/events',

            // Partners
            'partners_title' => 'Organizers & Partners',

            // FAQ / Media / Contact
            'faq_title'               => 'FAQs',
            'media_title'             => 'Media Gallery',
            'contact_title'           => 'Contact Us',
            'contact_description'     => 'Have questions about our events or partnerships? Our team is here to help.',
            'contact_email'           => 'info@nen.uz',
            'contact_headquarters'    => 'Namangan, Uzbekistan',

            // Footer
            'footer_phone'              => '+998908227567',
            'footer_copyright'          => '@ ' . date('Y') . '(NEN) All rights reserved',
            'footer_collaboration_text' => 'Read more about our Collaboration with ETS',
            'footer_collaboration_url'  => 'https://ets.nen-global.org/',

            // Header / Nav
            'header_register_text' => 'Register',
            'header_register_url'  => '#contact',
            'nav_about_url'        => '#about',
            'nav_events_url'       => '#events',
            'nav_partners_url'     => '#partners',
            'nav_contact_url'      => '#contact',

            'is_active' => true,

            // Section visibility
            'show_hero'             => true,
            'show_about'            => true,
            'show_events'           => true,
            'show_archive'          => true,
            'show_features'         => true,
            'show_how_it_works'     => true,
            'show_milestones'       => true,
            'show_agencies'         => true,
            'show_documents'        => true,
            'show_trusted_agencies' => true,
            'show_partners'         => true,
            'show_university_logos' => true,
            'show_media'            => true,
            'show_faq'              => true,
            'show_contact'          => true,

            // New section titles
            'features_title'            => 'Why Study In Uzbekistan?',
            'features_subtitle'         => 'Discover the advantages of world-class education in Uzbekistan',
            'how_it_works_title'        => 'How It Works',
            'how_it_works_subtitle'     => 'Simple steps from application to arrival. Fast admission, certified future.',
            'how_it_works_btn_text'     => 'Apply for a student visa',
            'how_it_works_btn_url'      => '#contact',
            'milestones_title'          => 'National Education Network Global Learning Portal',
            'milestones_subtitle'       => 'An international education network providing top services in university partnerships, student recruitment, and certified academic projects worldwide.',
            'milestones_description'    => 'Our mission is making international education more accessible. Join a thriving global academic community with verified university programs, direct admissions, and guidance led by experienced mentors.',
            'milestones_cta_text'       => 'Find collection point',
            'milestones_cta_url'        => '#contact',
            'agencies_title'            => 'Certified Translation Agencies',
            'agencies_subtitle'         => 'Translate your official documents quickly and securely through our network of trusted, certified translation offices.',
            'documents_title'           => 'Required Application Documents',
            'documents_subtitle'        => 'Prepare your official papers to complete your university application smoothly.',
            'trusted_agencies_title'    => 'Trusted Study Abroad Agencies',
            'trusted_agencies_subtitle' => 'Connect with certified consultants to simplify your university admission.',
            'university_logos_title'    => 'Success Partners',
        ];
    }
}
