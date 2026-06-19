<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = ProductCategory::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Product Categories';
        return view('admin.categories.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Product Category';
        return view('admin.categories.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = ProductCategory::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit product category - ' . $row->name;
        return view('admin.categories.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = ProductCategory::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = ProductCategory::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        $brand = ProductCategory::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'ProductCategory',
            'create',
            $brand->id
        );

        return redirect()->route('admin.categories.index')->with('success', $status);
    }




}
