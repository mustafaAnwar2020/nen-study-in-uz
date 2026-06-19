<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Faq::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Faqs';
        return view('admin.faqs.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Faq';
        return view('admin.faqs.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Faq::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit faq - ' . $row->name;
        return view('admin.faqs.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'product_type' => 'required|string|in:' . implode(',', array_keys(\App\Models\Product::TYPES)),
            'answer' => 'required|string',
            'image' => 'nullable|string',
            'show_in_home' => 'nullable|boolean',
        ]);
        $data['show_in_home'] = $request->boolean('show_in_home');

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Faq::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Faq::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        $brand = Faq::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'Faq',
            'create',
            $brand->id
        );

        return redirect()->route('admin.faqs.index')->with('success', $status);
    }


    public function destroy($id)
    {
        $brand = Faq::query()->findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.faqs.index')->with('success', __('messages.deleted'));
    }


}
