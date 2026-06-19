<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventRequest;
use App\Models\History;

class EventRequestController extends Controller
{
    public function index()
    {
        $rows = EventRequest::query()->with('event')->latest()->paginate(20);
        $model = 'Event Requests';

        return view('admin.event_requests.index', get_defined_vars());
    }

    public function markDone(EventRequest $eventRequest)
    {
        $eventRequest->is_done = true;
        $eventRequest->save();

        return back()->with('success', 'Marked as handled.');
    }

    public function delete(EventRequest $eventRequest)
    {
        $eventRequest->delete();

        History::makeHistory(auth()->user(), 'EventRequest', 'delete');

        return back()->with('success', __('Item has been deleted successfully'));
    }
}
