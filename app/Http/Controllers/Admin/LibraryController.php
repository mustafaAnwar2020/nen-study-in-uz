<?php

namespace App\Http\Controllers\Admin;

use App\Models\Library;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LibraryController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Library::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'Library';
        return view('admin.library.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create library record';
        return view('admin.library.manage', get_defined_vars());
    }


    public function edit($slug)
    {
        $row = Library::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit library - ' . $row->name;
        return view('admin.library.manage', get_defined_vars());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|string',
            'url' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Library::find($request->row_id);
            $image = $oldRow->image;

            if ($request->image) {
                $this->deleteOldFile($image);
            }

            $data['slug'] = $oldRow->slug;
        } else {
            $data['slug'] = Library::generateSlug();
        }

        if ($request->image) {
            $image = $request->image;
        }

        $data['image'] = $image;
        Library::query()->updateOrCreate(['id' => $request->row_id], $data);

        return redirect()->route('admin.library.index')->with('success', $status);
    }


}
