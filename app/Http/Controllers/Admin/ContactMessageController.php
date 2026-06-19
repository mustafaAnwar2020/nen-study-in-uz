<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactMessage;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactMessageController extends Controller
{

    public function index()
    {
        $rows = ContactMessage::query()->latest()->paginate(20);
        $model = 'Contact Messages';
        return view('admin.contact_messages.index', get_defined_vars());
    }


    public function markDone(ContactMessage $contactMessage)
    {
        $contactMessage->is_done = true;
        $contactMessage->save();

        return back()->with('success', 'Marked as contacted.');
    }

    public function delete(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        History::makeHistory(auth()->user(),
            'ContactMessage',
            'delete',
        );

        return back()->with('success', __('Item has been deleted successfully'));
    }

}
