<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserSettingController extends Controller
{
    public function index(Request $request)
    {
        $model = 'User Settings';
        return view('admin.user_settings.index', get_defined_vars());
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed'
        ]);

        currentUser()->update([
            'password' => Hash::make($request->password),
        ]);

        History::makeHistory(auth()->user(),
            'Setting',
            'update_user_settings',
        );

        return redirect()->back()->with('success', 'Password has been changed successfully');
    }
}
