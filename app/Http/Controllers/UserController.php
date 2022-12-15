<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    use SoftDeletes;

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
                'email' => 'required|email', // example
                'password' => 'required', // example
            ]
        );

        $_userModel = User::where('email', $request->email)->first();

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if ($_userModel->isHr()) {
                return redirect(route('hr.dashboard'));
            } else if ($_userModel->isEmployee()) {
                return redirect(route('employee.dashboard'));
            }
        }
        $request->session()->flash('error', 'Password Incorrect!!!');
        return redirect('/');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }
}
