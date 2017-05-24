<?php

namespace App\Models;


class VRPages extends CoreModel
{
    protected $table = 'vr_pages';

    protected $fillable = ['id', 'pages_categories_id', 'cover_image_id'];
}
