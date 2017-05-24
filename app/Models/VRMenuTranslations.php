<?php

namespace App\Models;


class VRMenuTranslations extends CoreModel
{
    protected $table = 'vr_menu_translations';

    protected $fillable = ['id', 'menu_id', 'languages_id', 'title', 'slug'];
}
