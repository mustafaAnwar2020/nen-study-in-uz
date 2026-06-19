<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->only(['username', 'password']))) {
            return redirect('/admin/dashboard');
        }

        return back()->withErrors('There is an issue occurred');

    }

}
