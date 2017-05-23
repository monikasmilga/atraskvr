<?php

namespace App\Models;


class VRPagesCategoriesConnections extends CoreModel
{
    protected $table = 'vr_pages_categories_connections';

    protected $fillable = ['pages_id', 'categories_id'];
}
