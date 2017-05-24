<?php

namespace App\Models;


class VRPagesTranslations extends CoreModel
{
    protected $table = 'vr_pages_translations';

    protected $fillable = ['id', 'pages_id', 'languages_id', 'title', 'description_long', 'description_short', 'slug'];
}
