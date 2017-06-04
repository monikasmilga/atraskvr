<?php

namespace App\Models;


class VROrders extends CoreModel
{
    protected $table = 'vr_orders';

    protected $fillable = ['id', 'status'];

    public static $STATUS = ['reserved' => 'reserved', 'canceled' => 'canceled', 'active' => 'active'];

}
