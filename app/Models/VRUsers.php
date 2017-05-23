<?php

namespace App\Models;


class VRUsers extends CoreModel
{
    protected $table = 'vr_users';

    protected $fillable = ['id', 'name', 'surname', 'password', 'email', 'phone'];

    public function connection (  )
    {
        return $this->belongsToMany(VRRoles::class, 'vr_users_roles_connections', 'users_id', 'roles_id');
    }
}
