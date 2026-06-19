<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cefr;
use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CefrController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = Cefr::query()->ordered();

        if ($request->title && $request->title != '') {
            $rows->where('title', 'like', '%' . $request->title . '%');
        }

        $rows = $rows->paginate(20);
        $model = 'CEFR Content';
        return view('admin.cefr.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = 'Create CEFR Content';
        return view('admin.cefr.manage', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'content_type' => 'required|in:text,table,image',
            'order_number' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'image_path' => 'nullable|string',
        ]);

        // Check if it's an update request
        $isUpdate = $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $image = null;
        if ($isUpdate) {
            $oldRow = Cefr::find($request->row_id);
            $image = $oldRow->image_path;

            if ($request->image_path) {
                $this->deleteOldFile($image);
            }
        }

        if ($request->image_path) {
            $image = $request->image_path;
        }

        $data['image_path'] = $image;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $cefr = Cefr::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(),
            'Cefr',
            $isUpdate ? 'update' : 'create',
            $cefr->id
        );

        return redirect()->route('admin.cefr.index')->with('success', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Cefr::findOrFail($id);
        $model = 'View CEFR Content - ' . $row->title;
        return view('admin.cefr.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Cefr::findOrFail($id);
        $model = 'Edit CEFR Content - ' . $row->title;
        return view('admin.cefr.manage', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Cefr::findOrFail($id);
        
        // Delete associated image if exists
        if ($row->image_path) {
            $this->deleteOldFile($row->image_path);
        }

        $row->delete();

        History::makeHistory(auth()->user(),
            'Cefr',
            'delete',
            $id
        );

        return redirect()->route('admin.cefr.index')->with('success', __('messages.deleted'));
    }
}
