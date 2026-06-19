<?php
namespace App\Http\Controllers\Admin;
use App\Models\Page;
use App\Models\History;
use App\Models\PageContent;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    use CommonTrait;

    public function index()
    {
        $rows = Page::paginate(10);
        $model = __('admin_dashboard.pages.title');
        return view('admin.pages.index', get_defined_vars());
    }


    public function show(Page $page)
    {
        return response()->json($page->contents);
    }

    public function edit_section(PageContent $pageContent)
    {
        $model = 'تعديل سكشن -' . $pageContent->title;
        return view('admin.pages.edit_section', get_defined_vars());
    }


    public function update_section(Request $request, PageContent $pageContent)
    {
        $image = $pageContent->image;
        if ($request->image) {
            $this->deleteOldFile($image);
            $image = $this->upload_image($request->image, 'site/pages', 'section_');
        }

        $data = [];
        if ($request->list_1)
            $data['list_1'] = $request->list_1;

        if ($request->list_2)
            $data['list_2'] = $request->list_2;

        $pageContent->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle ?? null,
            'image' => $image,
            'data' => serialize($data)
        ]);

        History::makeHistory(auth()->user(),
            'PageContent',
            'update_page_content',
            $pageContent->id,
        );
        return back()->with('success', __('admin_dashboard.common.updated'));
    }
}
