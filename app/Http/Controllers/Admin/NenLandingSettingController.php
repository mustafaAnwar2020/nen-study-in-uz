<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\NenLandingSetting;
use App\Traits\CommonTrait;
use App\Traits\LocalizesValidationRules;
use Illuminate\Http\Request;

class NenLandingSettingController extends Controller
{
    use CommonTrait, LocalizesValidationRules;

    public function edit()
    {
        $row = NenLandingSetting::getInstance();
        $model = 'Homepage Settings';
        $featuredEventOptions = Event::query()
            ->active()
            ->notArchived()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get(['id', 'name', 'date']);

        return view('admin.nen-landing-settings.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $rules = [
            // Hero
            'hero_product_title'    => 'nullable|string|max:255',
            'hero_subtitle'         => 'nullable|string|max:500',
            'hero_image'            => 'nullable|string',
            'hero_btn_text'         => 'nullable|string|max:100',
            'hero_btn_url'          => 'nullable|string|max:500',
            'hero_official_logo'    => 'nullable|string',
            'hero_official_label'   => 'nullable|string|max:255',
            'featured_event_id'     => 'nullable|integer|exists:events,id',

            // About
            'about_label'           => 'nullable|string|max:255',
            'about_title'           => 'nullable|string|max:500',
            'about_description'     => 'nullable|string',
            'about_image'           => 'nullable|string',
            'about_stat_value'      => 'nullable|string|max:50',
            'about_stat_label'      => 'nullable|string|max:255',
            'about_metric1_value'   => 'nullable|string|max:50',
            'about_metric1_label'   => 'nullable|string|max:255',
            'about_metric2_value'   => 'nullable|string|max:50',
            'about_metric2_label'   => 'nullable|string|max:255',
            'about_image_main'      => 'nullable|string',
            'about_image_secondary' => 'nullable|string',
            'about_image_side'      => 'nullable|string',

            // Events / Archive
            'highlights_title'    => 'nullable|string|max:255',
            'highlights_subtitle' => 'nullable|string|max:500',
            'archive_title'       => 'nullable|string|max:255',
            'archive_subtitle'    => 'nullable|string|max:500',
            'archive_btn_text'    => 'nullable|string|max:255',
            'archive_btn_url'     => 'nullable|string|max:500',

            // Partners / FAQ / Media / Contact
            'partners_title'          => 'nullable|string|max:255',
            'faq_title'               => 'nullable|string|max:255',
            'media_title'             => 'nullable|string|max:255',
            'contact_title'           => 'nullable|string|max:255',
            'contact_description'     => 'nullable|string',
            'contact_email'           => 'nullable|string|max:255',
            'contact_headquarters'    => 'nullable|string|max:255',

            // Footer
            'footer_phone'              => 'nullable|string|max:50',
            'footer_copyright'          => 'nullable|string|max:500',
            'footer_collaboration_text' => 'nullable|string|max:500',
            'footer_collaboration_url'  => 'nullable|string|max:500',
            'footer_tagline'            => 'nullable|string|max:500',

            // Header / Nav
            'header_register_text' => 'nullable|string|max:100',
            'header_register_url'  => 'nullable|string|max:500',
            'nav_about_url'        => 'nullable|string|max:500',
            'nav_events_url'       => 'nullable|string|max:500',
            'nav_partners_url'     => 'nullable|string|max:500',
            'nav_contact_url'      => 'nullable|string|max:500',

            'is_active' => 'nullable|boolean',

            // Section visibility
            'show_hero'             => 'nullable|boolean',
            'show_about'            => 'nullable|boolean',
            'show_events'           => 'nullable|boolean',
            'show_archive'          => 'nullable|boolean',
            'show_features'         => 'nullable|boolean',
            'show_how_it_works'     => 'nullable|boolean',
            'show_milestones'       => 'nullable|boolean',
            'show_agencies'         => 'nullable|boolean',
            'show_documents'        => 'nullable|boolean',
            'show_trusted_agencies' => 'nullable|boolean',
            'show_partners'         => 'nullable|boolean',
            'show_university_logos' => 'nullable|boolean',
            'show_media'            => 'nullable|boolean',
            'show_faq'              => 'nullable|boolean',
            'show_contact'          => 'nullable|boolean',

            // New section titles
            'features_title'            => 'nullable|string|max:255',
            'features_subtitle'         => 'nullable|string|max:500',
            'how_it_works_title'        => 'nullable|string|max:255',
            'how_it_works_subtitle'     => 'nullable|string|max:500',
            'how_it_works_btn_text'     => 'nullable|string|max:100',
            'how_it_works_btn_url'      => 'nullable|string|max:500',
            'milestones_title'          => 'nullable|string|max:255',
            'milestones_subtitle'       => 'nullable|string|max:500',
            'milestones_description'    => 'nullable|string',
            'milestones_cta_text'       => 'nullable|string|max:100',
            'milestones_cta_url'        => 'nullable|string|max:500',
            'agencies_title'            => 'nullable|string|max:255',
            'agencies_subtitle'         => 'nullable|string|max:500',
            'documents_title'           => 'nullable|string|max:255',
            'documents_subtitle'        => 'nullable|string|max:500',
            'trusted_agencies_title'    => 'nullable|string|max:255',
            'trusted_agencies_subtitle' => 'nullable|string|max:500',
            'university_logos_title'    => 'nullable|string|max:255',
        ];

        $data = $request->validate($this->localizeRules($rules, [
            'hero_product_title', 'hero_subtitle', 'hero_btn_text', 'hero_official_label',
            'about_label', 'about_title', 'about_description', 'about_stat_label',
            'about_metric1_label', 'about_metric2_label',
            'highlights_title', 'highlights_subtitle', 'archive_title', 'archive_subtitle', 'archive_btn_text',
            'partners_title', 'faq_title', 'media_title', 'contact_title', 'contact_description',
            'footer_copyright', 'footer_collaboration_text', 'footer_tagline',
            'header_register_text',
            'features_title', 'features_subtitle',
            'how_it_works_title', 'how_it_works_subtitle', 'how_it_works_btn_text',
            'milestones_title', 'milestones_subtitle', 'milestones_description', 'milestones_cta_text',
            'agencies_title', 'agencies_subtitle',
            'documents_title', 'documents_subtitle',
            'trusted_agencies_title', 'trusted_agencies_subtitle',
            'university_logos_title',
        ]));

        $row = NenLandingSetting::getInstance();

        foreach (['hero_image', 'hero_official_logo', 'about_image', 'about_image_main', 'about_image_secondary', 'about_image_side'] as $field) {
            if ($request->filled($field) && $row->{$field} && $request->{$field} !== $row->{$field}) {
                $this->deleteOldFile($row->{$field});
            }
        }

        $data['is_active'] = $request->boolean('is_active');

        // Explicit boolean handling for section visibility checkboxes
        $visibilityFields = [
            'show_hero', 'show_about', 'show_events', 'show_archive',
            'show_features', 'show_how_it_works', 'show_milestones',
            'show_agencies', 'show_documents', 'show_trusted_agencies',
            'show_partners', 'show_university_logos', 'show_media',
            'show_faq', 'show_contact',
        ];
        foreach ($visibilityFields as $field) {
            $data[$field] = $request->boolean($field);
        }

        $row->update($data);

        return redirect()->route('admin.nen-landing-settings.edit')->with('success', __('messages.updated'));
    }
}
