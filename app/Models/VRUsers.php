<?php

namespace App\Models;


class VRUsers extends CoreModel
{
    protected $table = 'vr_users';

    protected $fillable = ['id', 'name', 'surname', 'password', 'email', 'phone'];
}
