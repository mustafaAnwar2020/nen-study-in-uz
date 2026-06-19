<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiContactSection;
use Illuminate\Http\Request;

class TpiContactSectionController extends Controller
{
    public function edit()
    {
        $row = TpiContactSection::query()->first();
        if (!$row) {
            $row = TpiContactSection::query()->create([
                'section_title' => 'CONTACT',
                'title_highlight' => 'US',
                'phone_cards' => TpiContactSection::getDefaultPhoneCards(),
                'social_card' => TpiContactSection::getDefaultSocialCard(),
                'email_cards' => TpiContactSection::getDefaultEmailCards(),
                'is_active' => true,
            ]);
        }
        $model = 'TPI Contact Us Section';
        return view('admin.tpi-contact-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'section_title' => 'nullable|string|max:100',
            'title_highlight' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'phone_cards' => 'nullable|array',
            'phone_cards.*.icon' => 'nullable|string|max:50',
            'phone_cards.*.flag' => 'nullable|string|max:50',
            'phone_cards.*.lang_tag' => 'nullable|string|max:20',
            'phone_cards.*.phone_number' => 'nullable|string|max:50',
            'phone_cards.*.phone_display' => 'nullable|string|max:50',
            'phone_cards.*.whatsapp' => 'nullable|string|max:255',
            'phone_cards.*.telegram' => 'nullable|string|max:255',
            'social_card' => 'nullable|array',
            'social_card.icon' => 'nullable|string|max:50',
            'social_card.title' => 'nullable|string|max:100',
            'social_card.links' => 'nullable|array',
            'social_card.links.*.label' => 'nullable|string|max:50',
            'social_card.links.*.url' => 'nullable|string|max:500',
            'social_card.links.*.icon_class' => 'nullable|string|max:50',
            'social_card.links.*.bi_icon' => 'nullable|string|max:50',
            'email_cards' => 'nullable|array',
            'email_cards.*.icon' => 'nullable|string|max:50',
            'email_cards.*.title' => 'nullable|string|max:100',
            'email_cards.*.email' => 'nullable|email|max:255',
        ]);

        $row = TpiContactSection::query()->first();
        if (!$row) {
            $row = new TpiContactSection();
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($request->has('phone_cards') && is_array($request->phone_cards)) {
            $data['phone_cards'] = array_values(array_filter($request->phone_cards, function ($c) {
                return !empty($c['phone_number'] ?? '');
            }));
        }
        if ($request->has('social_card') && is_array($request->social_card)) {
            $data['social_card'] = $request->social_card;
            if (!empty($data['social_card']['links']) && is_array($data['social_card']['links'])) {
                $data['social_card']['links'] = array_values(array_filter($data['social_card']['links'], function ($l) {
                    return !empty($l['url'] ?? '');
                }));
            }
        }
        if ($request->has('email_cards') && is_array($request->email_cards)) {
            $data['email_cards'] = array_values(array_filter($request->email_cards, function ($c) {
                return !empty($c['email'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-contact-section.edit')->with('success', __('messages.updated'));
    }
}
