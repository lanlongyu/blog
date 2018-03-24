<?php

namespace App;


class AdminPermission extends Model
{
    //权限属于哪个角色
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_permission_roles', 'permission_id', 'role_id')
            ->withPivot(['permission_id', 'role_id']);
    }
}
