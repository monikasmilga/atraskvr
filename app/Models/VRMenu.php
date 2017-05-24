<?php

namespace App\Models;


class VRMenu extends CoreModel
{
    protected $table = 'vr_menu';

    protected $fillable = ['id', 'parent_id', 'name'];
}
