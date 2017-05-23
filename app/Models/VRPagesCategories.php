<?php

namespace App\Models;


class VRPagesCategories extends CoreModel
{
    protected $table = 'vr_pages_categories';

    protected $fillable = ['id', 'parent_id'];
}
