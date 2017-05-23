<?php

namespace App\Models;


class VRRolesPermissionsConnections extends CoreModel
{
    protected $table = 'vr_roles_permissions_connections';

    protected $fillable = ['permissions_id', 'roles_id'];
}
