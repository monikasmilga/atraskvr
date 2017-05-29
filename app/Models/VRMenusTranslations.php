<?php

namespace App\Models;


class VRMenusTranslations extends CoreModel
{
    protected $table = 'vr_menus_translations';

    protected $fillable = ['id', 'menus_id', 'languages_id', 'title', 'slug'];
}
