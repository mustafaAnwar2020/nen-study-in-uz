<?php

namespace App\Http\Controllers\Admin;

use App\Imports\NetworkImport;
use App\Models\Network;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class NetworkController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Network::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Networks';
        return view('admin.network.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Network';
        return view('admin.network.manage', get_defined_vars());
    }

    public function import()
    {
        $model = 'Import Network';
        return view('admin.network.import', get_defined_vars());
    }

    public function postImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx|max:2048',
        ]);
        try {
            Excel::import(new NetworkImport(), $request->file('file'));
            return redirect()->route('admin.network.index')->with('success', 'File imported successfully');
        } catch (\Exception $e) {
            Log::error('importCars:' . $e->getMessage());
            return redirect()->route('admin.network.index')->with('success', $e->getMessage());
        }
    }

    public function edit($slug)
    {
        $row = Network::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit slider - ' . $row->name;
        return view('admin.network.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'id_text' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'type' => 'nullable|string',
            'social_media' => 'nullable|string',
            'since' => 'nullable|string',
            'status' => 'required|string',
            'image' => 'nullable|string',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Network::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Network::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        Network::query()->updateOrCreate(['id' => $request->row_id], $data);

        return redirect()->route('admin.network.index')->with('success', $status);
    }


}
