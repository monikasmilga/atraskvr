<?php

namespace App\Models;

use App\Http\Traits\FillableTrait;
use App\Http\Traits\TableNameTrait;
use App\Http\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreModel extends Model
{
    /**
     * Incrementing is set to false
     *
     * @var bool
     */
    public $incrementing = false;
    use SoftDeletes;
    use UuidTrait;
    use FillableTrait;
    use TableNameTrait;

}
