<?php

namespace App\Models;


class VRReservations extends CoreModel
{
    protected $table = 'vr_reservations';

    protected $fillable = ['id', 'time', 'orders_id', 'pages_id'];
}
