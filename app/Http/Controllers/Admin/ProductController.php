<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Models\Product;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {

        $rows = Product::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->type && $request->type != '') {
            $rows->where('type', $request->type);
        }

        $rows = $rows->paginate(20);


        $model = 'Products';
        return view('admin.products.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Product';
        return view('admin.products.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Product::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit Product - ' . $row->name;
        return view('admin.products.manage', get_defined_vars());
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            //'category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'url' => 'nullable|string',
            'book_now_url' => 'nullable|array',
            'book_now_url.*.country' => 'required_with:book_now_url.*.url|string|max:10',
            'book_now_url.*.url' => 'required_with:book_now_url.*.country|url|max:255',
            'more_link' => 'nullable|string',
            'type' => 'nullable|string',
            'country_list_file' => 'nullable|string',
            'become_partner_url' => 'nullable|string',
            'is_active' => 'nullable',
            'show_in_home' => 'nullable',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Product::query()->find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Product::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;

        $data['book_now_url'] = $request->has('book_now_url') ? json_encode($request->book_now_url) : null;

        $brand = Product::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'Product',
            'create',
            $brand->id
        );

        return redirect()->route('admin.products.index')->with('success', $status);
    }


    public function delete(Product $product)
    {
        try {
            $this->deleteOldFile($product->image);
            $product->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'حدث خطأ ما');
        }

        History::makeHistory(auth()->user(),
            'Product',
            'delete',
        );

        return redirect()->route('admin.products.index')->with('success', 'تم الحذف بنجاح');
    }
}
