<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewsletterExport;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{

    public function index()
    {
        $rows  = Newsletter::query()->latest()->paginate(20);
        $model = 'Newsletter Subscribers';
        return view('admin.newsletter.index', get_defined_vars());
    }

    public function export()
    {
        $data = Newsletter::query()->get();

        return Excel::download(new NewsletterExport($data), 'newsletter_data_' . time() . '.xlsx');
    }


}
