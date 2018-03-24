<?php

namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('/admin/user/index', compact('users'));
    }

    public function create()
    {
        return view('/admin/user/add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|min:3',
                'password' => 'required'
            ]
        );

        $name = request('name');
        $password = bcrypt(request('password'));

        AdminUser::create(compact('name', 'password'));

        return redirect("/admin/users");

    }

    //用户角色页面
    public function role(AdminUser $user)
    {
        $roles = AdminRole::paginate(10);
        $myRoles = $user->roles;
        return view('admin/user/role', compact('roles', 'myRoles', 'user'));
    }

    //存储用户角色
    public function storeRole(AdminUser $user)
    {
        $this->validate(request(), [
                'roles' => 'required|array'
            ]
        );

        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;
        //要增加的
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role) {
            $user->assignRole($role);
        }
        //要删除的
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }

        return back();


    }
}
