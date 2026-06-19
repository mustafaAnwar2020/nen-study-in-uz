<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiJoinPartnerSection;
use Illuminate\Http\Request;

class TpiJoinPartnerSectionController extends Controller
{
    public function edit()
    {
        $row = TpiJoinPartnerSection::query()->first();
        if (!$row) {
            $row = TpiJoinPartnerSection::query()->create([
                'section_title' => 'Join as Partner',
                'items' => TpiJoinPartnerSection::getDefaultItems(),
                'is_active' => true,
            ]);
        }
        $model = 'TPI Join as Partner Section';
        return view('admin.tpi-join-partner-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'section_title' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.icon' => 'nullable|string|max:100',
            'items.*.icon_class' => 'nullable|string|max:50',
            'items.*.title' => 'nullable|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.button_text' => 'nullable|string|max:255',
            'items.*.button_url' => 'nullable|string|max:500',
        ]);

        $row = TpiJoinPartnerSection::query()->first();
        if (!$row) {
            $row = new TpiJoinPartnerSection();
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($request->has('items') && is_array($request->items)) {
            $data['items'] = array_values(array_filter($request->items, function ($item) {
                return !empty($item['title'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-join-partner-section.edit')->with('success', __('messages.updated'));
    }
}
