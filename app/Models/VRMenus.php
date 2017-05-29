<?php

namespace App\Models;


class VRMenus extends CoreModel
{
    protected $table = 'vr_menus';

    protected $fillable = ['id', 'parent_id', 'name'];
}
