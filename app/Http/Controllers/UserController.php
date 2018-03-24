<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setting()
    {
        $user = \Auth::user();
        return view('user.setting', compact('user'));
    }

    public function settingStore(Request $request)
    {
        $this->validate(request(), [
                'name' => 'required|min:3',
            ]
        );

        $name = request('name');
        $user = \Auth::user();
        if ($name != $user->name) {
            if (User::where('name', $name)->count() > 0) {
                return back()->withErrors('用户名已经被注册');
            }

            $user->name = $name;
        }

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->storePublicly($user->id);
            $user->avatar = "/storage/" . $path;
        }
        $user->save();

        return back();
    }

    public function show(User $user)
    {
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();

        $stars = $user->fans;
        $susers = User::whereIn('id', $stars->pluck('star_id'))->withCount(['stars', 'fans', 'posts'])->get();

        $fans = $user->fans;
        $fusers = User::whereIn('id', $fans->pluck('fan_id'))->withCount(['stars', 'fans', 'posts'])->get();

        return view('user/show', compact('user', 'posts', 'susers', 'fusers'));
    }

    public function fan(User $user)
    {
        $me = \Auth::user();
        $me->doFan($user->id);

        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function unfan(User $user)
    {
        $me = \Auth::user();
        $me->doUnFan($user->id);

        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
