<?php

namespace App\Models;


class VRReservations extends CoreModel
{
    protected $table = 'vr_reservation';

    protected $fillable = ['id', 'orders_id', 'pages_id'];
}
