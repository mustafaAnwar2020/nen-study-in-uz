<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\NenLandingSetting;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class NenLandingSettingController extends Controller
{
    use CommonTrait;

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
        $data = $request->validate([
            'hero_product_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image' => 'nullable|string',
            'hero_btn_text' => 'nullable|string|max:100',
            'hero_btn_url' => 'nullable|string|max:500',
            'featured_event_id' => 'nullable|integer|exists:events,id',
            'about_label' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:500',
            'about_description' => 'nullable|string',
            'about_image' => 'nullable|string',
            'about_stat_value' => 'nullable|string|max:50',
            'about_stat_label' => 'nullable|string|max:255',
            'about_metric1_value' => 'nullable|string|max:50',
            'about_metric1_label' => 'nullable|string|max:255',
            'about_metric2_value' => 'nullable|string|max:50',
            'about_metric2_label' => 'nullable|string|max:255',
            'about_image_main' => 'nullable|string',
            'about_image_secondary' => 'nullable|string',
            'about_image_side' => 'nullable|string',
            'highlights_title' => 'nullable|string|max:255',
            'highlights_subtitle' => 'nullable|string|max:500',
            'archive_title' => 'nullable|string|max:255',
            'archive_subtitle' => 'nullable|string|max:500',
            'archive_btn_text' => 'nullable|string|max:255',
            'archive_btn_url' => 'nullable|string|max:500',
            'partners_title' => 'nullable|string|max:255',
            'faq_title' => 'nullable|string|max:255',
            'media_title' => 'nullable|string|max:255',
            'contact_title' => 'nullable|string|max:255',
            'contact_description' => 'nullable|string',
            'contact_email' => 'nullable|string|max:255',
            'contact_headquarters' => 'nullable|string|max:255',
            'footer_phone' => 'nullable|string|max:50',
            'footer_copyright' => 'nullable|string|max:500',
            'footer_collaboration_text' => 'nullable|string|max:500',
            'footer_collaboration_url' => 'nullable|string|max:500',
            'header_register_text' => 'nullable|string|max:100',
            'header_register_url' => 'nullable|string|max:500',
            'nav_about_url' => 'nullable|string|max:500',
            'nav_events_url' => 'nullable|string|max:500',
            'nav_partners_url' => 'nullable|string|max:500',
            'nav_contact_url' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $row = NenLandingSetting::getInstance();
        foreach (['hero_image', 'about_image', 'about_image_main', 'about_image_secondary', 'about_image_side'] as $field) {
            if ($request->filled($field) && $row->{$field} && $request->{$field} !== $row->{$field}) {
                $this->deleteOldFile($row->{$field});
            }
        }
        $data['is_active'] = $request->boolean('is_active');
        $row->update($data);

        return redirect()->route('admin.nen-landing-settings.edit')->with('success', __('messages.updated'));
    }
}
