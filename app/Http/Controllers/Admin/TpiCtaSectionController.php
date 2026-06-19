<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiCtaSection;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class TpiCtaSectionController extends Controller
{
    use CommonTrait;

    public function edit()
    {
        $row = TpiCtaSection::query()->first();
        if (!$row) {
            $row = TpiCtaSection::query()->create([
                'title' => 'Ready to Practice TOEFL',
                'lead' => 'Start Now - Only $10 Refundable Deposit',
                'pay_btn_text' => 'Pay Now',
                'image' => 'site/images/tpi-hero.png',
                'payment_options' => TpiCtaSection::getDefaultPaymentOptions(),
                'is_active' => true,
            ]);
        }
        $model = 'TPI Final CTA Section';
        return view('admin.tpi-cta-section.manage', get_defined_vars());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'lead' => 'nullable|string|max:500',
            'pay_btn_text' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'payment_options' => 'nullable|array',
            'payment_options.*.label' => 'nullable|string|max:255',
            'payment_options.*.url' => 'nullable|url|max:500',
            'payment_options.*.icon' => 'nullable|string|max:50',
        ]);

        $row = TpiCtaSection::query()->first();
        if (!$row) {
            $row = new TpiCtaSection();
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
        if ($request->has('payment_options') && is_array($request->payment_options)) {
            $data['payment_options'] = array_values(array_filter($request->payment_options, function ($o) {
                return !empty($o['url'] ?? '');
            }));
        }

        $row->fill($data);
        $row->save();

        return redirect()->route('admin.tpi-cta-section.edit')->with('success', __('messages.updated'));
    }
}
