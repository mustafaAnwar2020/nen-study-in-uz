<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiSection;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class TpiSectionController extends Controller
{
    use CommonTrait;

    public function edit()
    {
        $row = TpiSection::query()->first();
        if (!$row) {
            $row = TpiSection::query()->create([
                'title' => 'TOEFL IBT Practice Scholarship',
                'heading' => 'Practice. Train. Succeed.',
                'benefit1' => 'Limited Seats! Train for TOEFL with Expert Support',
                'benefit2' => 'Get 3 complete practice tests and unlimited mentoring — all for a refundable $10 deposit.',
                'cta_text' => 'Book now and take your official exam within 6 months!',
                'deposit_amount' => '$10',
                'practice_tests_count' => '3',
                'months_text' => '6 months',
                'apply_btn_text' => 'Apply Now',
                'learn_more_text' => 'Learn More',
                'learn_more_url' => url('/tpi'),
                'image' => 'site/images/tpi-hero.png',
                'countries' => TpiSection::getDefaultCountries(),
                'is_active' => true,
            ]);
        }
        $model = 'TOEFL IBT Practice Scholarship Section';
        return view('admin.tpi-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'benefit1' => 'nullable|string|max:500',
            'benefit2' => 'nullable|string',
            'cta_text' => 'nullable|string|max:500',
            'deposit_amount' => 'nullable|string|max:50',
            'practice_tests_count' => 'nullable|string|max:20',
            'months_text' => 'nullable|string|max:50',
            'apply_btn_text' => 'nullable|string|max:100',
            'learn_more_text' => 'nullable|string|max:100',
            'learn_more_url' => 'nullable|string|max:500',
            'image' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'countries' => 'nullable|array',
            'countries.*.code' => 'required_with:countries.*.url|string|max:10',
            'countries.*.name' => 'nullable|string|max:100',
            'countries.*.url' => 'required_with:countries.*.code|url|max:500',
            'countries.*.flag' => 'nullable|string|max:50',
        ]);

        $row = TpiSection::query()->first();
        if (!$row) {
            $row = new TpiSection();
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

        return redirect()->route('admin.tpi-section.edit')->with('success', __('messages.updated'));
    }
}
