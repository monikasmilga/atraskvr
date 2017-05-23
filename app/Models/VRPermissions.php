<?php

namespace App\Models;


class VRPermissions extends CoreModel
{
    protected $table = 'vr_permissions';

    protected $fillable = ['id', 'name'];
}
