<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            return redirect('/posts');
        }
        return view('login.index');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required|min:3|max:16',
                'is_remember' => 'integer'
            ]
        );
        $user = request(['email', 'password']);
        $is_remember = request('is_remember');
        if (\Auth::attempt($user, $is_remember)) {
            return redirect('/posts');
        }

        return \Redirect::back()->withErrors("邮箱密码不匹配");
    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}
