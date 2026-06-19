<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\History;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    use CommonTrait;

    public function index(Request $request)
    {
        $rows = Blog::query()->latest();

        if ($request->filled('title')) {
            $rows->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $rows->where('status', $request->status);
        }

        $rows = $rows->paginate(20);
        $model = 'Blogs';
        return view('admin.blogs.index', get_defined_vars());
    }

    public function create()
    {
        $model = 'Create Blog';
        return view('admin.blogs.manage', get_defined_vars());
    }

    public function edit($slug)
    {
        $row = Blog::query()->where('slug', $slug)->firstOrFail();
        $model = 'Edit blog - ' . $row->title;
        return view('admin.blogs.manage', get_defined_vars());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . ($request->row_id ?? ''),
            'article' => 'required|string',
            'image' => 'nullable|string|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $isUpdate = (bool) $request->row_id;
        $status = $isUpdate ? __('messages.updated') : __('messages.created');

        $oldRow = null;
        $image = null;

        if ($isUpdate) {
            $oldRow = Blog::findOrFail($request->row_id);
            $image = $oldRow->image;

            if ($request->filled('image')) {
                $this->deleteOldFile($oldRow->image);
            }

        }

        if ($request->filled('image')) {
            $image = $request->image;
        }

        $data['image'] = $image;
        $data['is_active'] = $request->boolean('is_active');

        $blog = Blog::query()->updateOrCreate(['id' => $request->row_id], $data);

        History::makeHistory(auth()->user(), 'Blog', 'create', $blog->id);

        return redirect()->route('admin.blogs.index')->with('success', $status);
    }

    public function destroy($id)
    {
        $row = Blog::findOrFail($id);

        if ($row->image) {
            $this->deleteOldFile($row->image);
        }

        $row->delete();

        return redirect()->route('admin.blogs.index')->with('success', __('messages.deleted'));
    }
}
