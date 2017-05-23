<?php

namespace App\Models;


class VRUsersRolesConnections extends CoreModel
{
    protected $table = 'vr_users_roles_connections';

    protected $fillable = ['users_id', 'roles_id'];
}
