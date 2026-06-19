<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TpiFaq;
use Illuminate\Http\Request;

class TpiFaqController extends Controller
{
    public function index()
    {
        $rows = TpiFaq::query()->orderBy('sort_order')->orderBy('id')->paginate(20);
        $model = 'TPI FAQs';
        return view('admin.tpi-faqs.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create TPI FAQ';
        return view('admin.tpi-faqs.manage', get_defined_vars());
    }

    public function edit($id)
    {
        $row = TpiFaq::query()->findOrFail($id);
        $model = 'Edit TPI FAQ';
        return view('admin.tpi-faqs.manage', get_defined_vars());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($request->sort_order ?? 0);

        if ($request->row_id) {
            $row = TpiFaq::query()->findOrFail($request->row_id);
            $row->update($data);
            return redirect()->route('admin.tpi-faqs.index')->with('success', __('messages.updated'));
        }

        TpiFaq::query()->create($data);
        return redirect()->route('admin.tpi-faqs.index')->with('success', __('messages.created'));
    }

    public function destroy($id)
    {
        TpiFaq::query()->findOrFail($id)->delete();
        return redirect()->route('admin.tpi-faqs.index')->with('success', __('messages.deleted'));
    }
}
