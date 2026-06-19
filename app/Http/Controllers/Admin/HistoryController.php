<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $model = 'سجل النشاطات';

        $rows = History::with(['user'])->orderBy('id', 'desc');

        if ($request->has('user_id') && $request->user_id != 'all')
            $rows = $rows->where('user_id', $request->user_id);

        if ($request->has('type') && $request->type != 'all')
            $rows = $rows->where('performed_on_model', $request->type);

        $rows = $rows->paginate(25);

        return view('admin.histories.index', get_defined_vars());
    }
}
