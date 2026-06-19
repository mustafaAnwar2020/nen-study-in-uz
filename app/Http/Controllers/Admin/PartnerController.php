<?php

namespace App\Http\Controllers\Admin;

use App\Models\Partner;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Partner::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Partners';
        return view('admin.partners.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Partner';
        return view('admin.partners.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Partner::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit partner - ' . $row->name;
        return view('admin.partners.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:255',
            'product_id' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|string',
            'logo' => 'nullable|string',
            'pdf' => 'nullable|string',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Partner::find($request->row_id);
            $image = $oldRow->logo;

            if ($request->logo) {
                $this->deleteOldFile($image);
            }

            $pdf = $oldRow->pdf;

            if ($request->pdf) {
                $this->deleteOldFile($pdf);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Partner::generateSlug();
        }

        if ($request->logo) {
            $image = $request->logo;
        }

        if ($request->pdf) {
            $pdf = $request->pdf;
        }

        $data['logo'] = $image;
        $data['pdf'] = $pdf;
        Partner::query()->updateOrCreate(['id' => $request->row_id], $data);

        return redirect()->route('admin.partners.index')->with('success', $status);
    }


}
