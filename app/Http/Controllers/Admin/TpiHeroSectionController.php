<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiHeroSection;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class TpiHeroSectionController extends Controller
{
    use CommonTrait;

    public function edit()
    {
        $row = TpiHeroSection::query()->first();
        if (!$row) {
            $row = TpiHeroSection::query()->create([
                'title' => 'TOEFL IBT Practice Scholarship',
                'subtitle' => 'Practice. Train. Succeed.',
                'image' => 'site/images/tpi-hero.jpg',
                'apply_btn_text' => 'Apply Now',
                'countries' => TpiHeroSection::getDefaultCountries(),
                'nearest_center_text' => 'Nearest Center',
                'nearest_center_url' => '#authorized-centers',
                'is_active' => true,
            ]);
        }
        $model = 'TPI Page Hero Section';
        return view('admin.tpi-hero-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'apply_btn_text' => 'nullable|string|max:100',
            'nearest_center_text' => 'nullable|string|max:100',
            'nearest_center_url' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'countries' => 'nullable|array',
            'countries.*.code' => 'required_with:countries.*.url|string|max:10',
            'countries.*.name' => 'nullable|string|max:100',
            'countries.*.url' => 'required_with:countries.*.code|url|max:500',
            'countries.*.flag' => 'nullable|string|max:50',
        ]);

        $row = TpiHeroSection::query()->first();
        if (!$row) {
            $row = new TpiHeroSection();
        }

        if (!empty($request->image)) {
            if ($row->image) {
                $this->deleteOldFile($row->image);
            }
            $data['image'] = $request->image;
        } elseif ($row->exists && $request->has('image')) {
            $data['image'] = $row->image;
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($request->has('countries') && is_array($request->countries)) {
            $data['countries'] = array_values(array_filter($request->countries, function ($c) {
                return !empty($c['url'] ?? '') && !empty($c['code'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-hero-section.edit')->with('success', __('messages.updated'));
    }
}
