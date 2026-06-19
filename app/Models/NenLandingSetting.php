<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NenLandingSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'featured_event_id' => 'integer',
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
            'hero_product_title' => 'TOEFL Primary® Tests',
            'hero_subtitle' => 'Put Your Students On The Right Path, Right From The Start',
            'hero_image' => 'site/images/nen-landing/hero-bg.png',
            'hero_btn_text' => 'Book now',
            'hero_btn_url' => '#contact',
            'about_label' => 'About NEN',
            'about_title' => 'Educational Transformation Leadership in Namangan',
            'about_description' => 'NEN | National Education Network is a strategic network established@2008 and owned by "NEN for Information Technology". It has management offices in 13 countries, and extends its educational impact across the region.',
            'about_image' => 'site/images/nen-landing/about.jpg',
            'about_stat_value' => '15+',
            'about_stat_label' => 'Years of Distinction',
            'about_metric1_value' => '10k+',
            'about_metric1_label' => 'Beneficiary Student',
            'about_metric2_value' => '50+',
            'about_metric2_label' => 'Partner Institution',
            'about_image_main' => 'site/images/nen-landing/about-main.jpg',
            'about_image_secondary' => 'site/images/nen-landing/about-secondary.jpg',
            'about_image_side' => 'site/images/nen-landing/about-side.jpg',
            'highlights_title' => 'Upcoming Highlights Events',
            'highlights_subtitle' => 'Discover Unique Educational Journeys with Us',
            'archive_title' => 'Archive of Previous Events',
            'archive_subtitle' => 'Discover Unique Educational Journeys with Us',
            'archive_btn_text' => 'View all Archive',
            'archive_btn_url' => '/events',
            'partners_title' => 'Organizers & Partners',
            'faq_title' => 'FAQs',
            'media_title' => 'Media Gallery',
            'contact_title' => 'Contact Us',
            'contact_description' => 'Have questions about our events or partnerships? Our team is here to help.',
            'contact_email' => 'info@nen.uz',
            'contact_headquarters' => 'Namangan, Uzbekistan',
            'footer_phone' => '+998908227567',
            'footer_copyright' => '@ ' . date('Y') . '(NEN) All rights reserved',
            'footer_collaboration_text' => 'Read more about our Collaboration with ETS',
            'footer_collaboration_url' => 'https://ets.nen-global.org/',
            'header_register_text' => 'Register',
            'header_register_url' => '#contact',
            'nav_about_url' => '#about',
            'nav_events_url' => '#events',
            'nav_partners_url' => '#partners',
            'nav_contact_url' => '#contact',
            'is_active' => true,
        ];
    }
}
