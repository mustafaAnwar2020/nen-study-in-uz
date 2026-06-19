<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Slider::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Sliders';
        return view('admin.sliders.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Slider';
        return view('admin.sliders.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Slider::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit slider - ' . $row->name;
        return view('admin.sliders.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'url' => 'nullable|string',
            'use_book_now' => 'nullable|boolean',
            'book_now_url' => 'nullable|array',
            'book_now_url.*.country' => 'nullable|string|max:10',
            'book_now_url.*.url' => 'nullable|url|max:255',
            'btn_text' => 'nullable|string',
            'btn_url' => 'nullable|string',
            'btn2_text' => 'nullable|string',
            'btn2_url' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Slider::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Slider::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        $data['use_book_now'] = $request->boolean('use_book_now');
        if ($data['use_book_now'] && $request->has('book_now_url') && is_array($request->book_now_url)) {
            $filtered = array_values(array_filter($request->book_now_url, fn($e) => !empty($e['url'] ?? '') && !empty($e['country'] ?? '')));
            $data['book_now_url'] = !empty($filtered) ? json_encode($filtered) : null;
        }

        if ($request->has('order')) {
            $data['order'] = $request->order;
        }

        Slider::query()->updateOrCreate(['id' => $request->row_id], $data);

        return redirect()->route('admin.sliders.index')->with('success', $status);
    }
}
