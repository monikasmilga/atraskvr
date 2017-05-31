<?php

namespace App\Models;


class VROrders extends CoreModel
{
    protected $table = 'vr_orders';

    protected $fillable = ['id', 'status'];

    public static $STATUS = ['reserved' => 'reserved', 'canceled' => 'canceled', 'active' => 'active'];

    public function connection (  )
    {
        return $this->belongsToMany(DTIngredients::class, 'dt_pizzas_ingredients_connections', 'pizzas_id', 'ingredients_id');
    }
}
