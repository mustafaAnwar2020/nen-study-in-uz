<?php
namespace App\Http\Controllers\Admin;
use App\Models\Chat;
use App\Models\User;
use App\Models\History;
use App\Models\ChatMessage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        if ($request->type == 'inbox') {
            $model = 'المراسلات - الواردة';
            $chats = currentUser()->chatsReceived()->with('sender')->get();
        } else {
            $model = 'المراسلات - الصادرة';
            $chats = currentUser()->chatsSent()->with('receiver')->get();
        }

        return view('admin.chats.index', get_defined_vars());
    }


    public function newChat(Request $request)
    {
        $model = 'إرسال رسالة';
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'student');
            //$q->where('name', '!=', 'instructor');
            $q->where('id', '!=', currentUser()->id);
        })->get();

        foreach ($users as $user){
            $user->role = $user->roles->first()->name_ar;
        }
        return view('admin.chats.new', get_defined_vars());
    }


    public function show($slug)
    {
        $chat = Chat::where('slug', $slug)->first();
        if (!$chat)
            return redirect()->back()->with('error', 'هذه المراسلة غير موجودة');

        $model = 'مراسلة مع' . ' - ' . $chat->sender->name;

        $chat->read_at = now();
        $chat->save();

        // mark all messages as read
        $chat->chatMessages()->where('user_id', '!=', currentUser()->id)->update(['read_at' => now()]);

        return view('admin.chats.show', get_defined_vars());
    }


    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ]);

        if (!$request->chat_id) {
            $chat = Chat::create([
                'sender_id' => currentUser()->id,
                'receiver_id' => $request->receiver_id,
                'slug' => Str::slug(Str::random(10) . time()),
            ]);
        }

        $message = ChatMessage::create([
            'chat_id' => $request->chat_id ?? $chat->id,
            'user_id' => currentUser()->id,
            'message' => $request->message,
            'isSender' => true,
        ]);

        History::makeHistory(auth()->user(),
            'ChatMessage',
            'send_message',
            $request->chat_id
        );
        return redirect(route('admin.chats.index') . '?type=inbox')->with('success', 'تم ارسال الرسالة بنجاح');
    }
}
