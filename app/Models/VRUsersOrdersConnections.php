<?php

namespace App\Models;


class VRUsersOrdersConnections extends CoreModel
{
    protected $table = 'vr_users_orders_connections';

    protected $fillable = ['users_id', 'orders_id'];
}
