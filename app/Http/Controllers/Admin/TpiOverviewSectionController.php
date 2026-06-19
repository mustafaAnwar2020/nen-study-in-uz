<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiOverviewSection;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class TpiOverviewSectionController extends Controller
{
    use CommonTrait;

    public function edit()
    {
        $row = TpiOverviewSection::query()->first();
        if (!$row) {
            $row = TpiOverviewSection::query()->create([
                'section_title' => 'What Is the TOEFL IBT Practice Scholarship?',
                'lead' => 'This scholarship provides a complete TOEFL practice experience at zero cost.',
                'intro_paragraph' => 'Participants pay a temporary, refundable deposit, receive full TOEFL practice sessions and mentor guidance, and recover the deposit after completing the program.',
                'benefits' => TpiOverviewSection::getDefaultBenefits(),
                'student_image' => 'site/images/toefl-students-celebrating.jpeg',
                'features' => TpiOverviewSection::getDefaultFeatures(),
                'is_active' => true,
            ]);
        }
        $model = 'TPI Page Overview Section';
        return view('admin.tpi-overview-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'section_title' => 'nullable|string|max:255',
            'lead' => 'nullable|string|max:500',
            'intro_paragraph' => 'nullable|string',
            'student_image' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*.icon' => 'nullable|string|max:100',
            'features.*.icon_class' => 'nullable|string|max:50',
            'features.*.title' => 'nullable|string|max:255',
        ]);

        $row = TpiOverviewSection::query()->first();
        if (!$row) {
            $row = new TpiOverviewSection();
        }

        if (!empty($request->student_image)) {
            if ($row->student_image) {
                $this->deleteOldFile($row->student_image);
            }
            $data['student_image'] = $request->student_image;
        } elseif ($row->exists && $request->has('student_image')) {
            $data['student_image'] = $row->student_image;
        }

        $data['is_active'] = $request->boolean('is_active');
        if ($request->has('benefits') && is_array($request->benefits)) {
            $data['benefits'] = array_values(array_filter($request->benefits));
        }
        if ($request->has('features') && is_array($request->features)) {
            $data['features'] = array_values(array_filter($request->features, function ($f) {
                return !empty($f['title'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-overview-section.edit')->with('success', __('messages.updated'));
    }
}
