<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {

        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
                'name' => 'required',
                'password' => 'required|min:3|max:16',

            ]
        );
        $user = request(['name', 'password']);

        if (\Auth::guard("admin")->attempt($user)) {
            return redirect('/admin/home');
        }

        return \Redirect::back()->withErrors("邮箱密码不匹配");
    }

    public function logout()
    {
        \Auth::guard("admin")->logout();
        return redirect('/admin/login');
    }
}
