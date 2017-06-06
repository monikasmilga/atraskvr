<?php

namespace App\Models;


class VRResources extends CoreModel
{
    protected $table = 'vr_resources';

    protected $fillable = ['id', 'mime_type', 'path', 'width', 'height', 'size'];

}
