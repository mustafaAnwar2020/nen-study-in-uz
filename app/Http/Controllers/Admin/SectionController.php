<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use CommonTrait;


    public function index(Request $request)
    {
        $rows = Section::query()->latest();

        if ($request->name && $request->name != '') {
            $rows->where('name', 'like', '%' . $request->name . '%');
        }

        $rows  = $rows->paginate(20);
        $model = 'Sections';
        return view('admin.sections.index', get_defined_vars());
    }


    public function edit($slug)
    {
        $row   = Section::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit section - ' . $row->title;
        return view('admin.sections.manage', get_defined_vars());
    }


    public function update(Request $request, $slug)
    {
        $data = $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'btn_text'    => 'nullable|string',
            'btn_url'     => 'nullable|string',
            'btn2_text'    => 'nullable|string',
            'btn2_url'     => 'nullable|string',
            'iframe_url' => 'nullable|string',
        ]);

        $row = Section::query()->where('slug', $slug)->firstOrFail();

        if ($request->image) {
            $this->deleteOldFile($row->image);
        }

        if ($request->has('list')) {
            $data['list_items'] = json_encode($request->list);
        }

        $row->update($data);

        return redirect()->route('admin.sections.index')
            ->with('success', __('messages.updated'));
    }


}
