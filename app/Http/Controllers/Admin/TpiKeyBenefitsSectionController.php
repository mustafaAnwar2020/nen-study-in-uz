<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiKeyBenefitsSection;
use Illuminate\Http\Request;

class TpiKeyBenefitsSectionController extends Controller
{
    public function edit()
    {
        $row = TpiKeyBenefitsSection::query()->first();
        if (!$row) {
            $row = TpiKeyBenefitsSection::query()->create([
                'section_title' => 'Key Benefits',
                'items' => TpiKeyBenefitsSection::getDefaultItems(),
                'is_active' => true,
            ]);
        }
        $model = 'TPI Key Benefits Section';
        return view('admin.tpi-key-benefits-section.manage', get_defined_vars());
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
        ]);

        $row = TpiKeyBenefitsSection::query()->first();
        if (!$row) {
            $row = new TpiKeyBenefitsSection();
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($request->has('items') && is_array($request->items)) {
            $data['items'] = array_values(array_filter($request->items, function ($item) {
                return !empty($item['title'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-key-benefits-section.edit')->with('success', __('messages.updated'));
    }
}
