<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function register(Request $request)
    {
        $valid = $this->validate($request, [
                'name' => 'required|min:3|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:16|confirmed'
            ]
        );


        $name = $request->name;
        $email = $request->email;
        $password = bcrypt($request->password);

        $user = User::create(compact('name', 'email', 'password'));

        if ($user) {
            return redirect('/login');
        } else {
            return \Redirect::back()->withErrors("注册失败");
        }
    }
}
