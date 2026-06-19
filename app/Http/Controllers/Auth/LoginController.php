<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //protected $redirectTo = RouteServiceProvider::HOME;
    public function showLoginForm()
    {
        return view('student.auth.login');
    }

    public function showAdminLoginForm()
    {
        if (auth()->user() && !auth()->user()->hasRole('student'))
            return redirect('/admin/dashboard');
        return view('admin.auth.login');
    }

    protected function authenticated($request, $user)
    {
        if (!auth()->user()->hasRole('student')) {
            return redirect('/admin/dashboard');
        }

        if (isset(auth()->user()->application)) {
            if (!auth()->user()->application->status) {
                Auth::logout();
                return redirect('/')->with('error', 'لم يتم قبول طلب الحجز حتي الآن');
            }
        } else {
            Auth::logout();
            return redirect('/')->with('error', 'ليس لديك طلب حجز');
        }

    /*    if (!auth()->user()->set_his_pass) {
            return redirect('/student/set_password');
        }*/

        return redirect(RouteServiceProvider::HOME);
    }

    public function username()
    {
        return 'username';
    }


}
