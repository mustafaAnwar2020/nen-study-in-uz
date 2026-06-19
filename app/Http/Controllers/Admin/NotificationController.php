<?php

namespace App\Http\Controllers\Admin;

use App\Traits\CommonTrait;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    use CommonTrait;

    public function markAllRead()
    {
        currentUser()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }
}
