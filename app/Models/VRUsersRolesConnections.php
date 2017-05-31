<?php

namespace App\Models;


class VRUsersRolesConnections extends CoreModel
{
    protected $table = 'vr_users_roles_connections';

    protected $fillable = ['users_id', 'roles_id'];

    protected $updated_at = false;


    public function role()
    {
        return $this->hasOne(VRRoles::class, 'id', 'roles_id');
    }
}
