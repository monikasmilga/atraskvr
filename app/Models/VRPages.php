<?php

namespace App\Models;


class VRPages extends CoreModel
{
    protected $table = 'vr_pages';

    protected $fillable = ['id', 'pages_categories_id', 'cover_image_id'];

    public function pagesTranslations()
    {
        return $this->hasMany(VRPagesTranslations::class, 'pages_id', 'id');
    }

    public function connection()
    {
        return $this->belongsToMany(VRLanguages::class, 'vr_pages_translations');
    }

    public function languageConnection()
    {
        return $this->hasMany(VRPagesTranslations::class, 'pages_id', 'id')->with(['language']);
    }

    public function pagesCategories()
    {
        return $this->hasOne(VRPagesCategories::class, 'id', 'pages_categories_id');
    }
}

