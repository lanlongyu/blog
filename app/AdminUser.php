<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $rememberTokenName = '';

    //用户有哪一些角色
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_role_users', 'user_id', 'role_id')
            ->withPivot('user_id', 'role_id');
    }

    //判断是否有某个角色，某些角色
    public function isInRole($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    //给用户分配角色
    public function assignRole($role)
    {
        return $this->roles()->save($role);
    }

    //取消用户分配的角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    //用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRole($permission->roles);
    }

}
