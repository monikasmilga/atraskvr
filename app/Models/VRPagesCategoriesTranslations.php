<?php

namespace App\Models;


class VRPagesCategoriesTranslations extends CoreModel
{
    protected $table = 'vr_pages_categories_translations';

    protected $fillable = ['id', 'categories_id', 'languages_id', 'name', 'slug'];
}
