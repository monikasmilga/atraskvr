<?php
/**
 * Created by PhpStorm.
 * User: aivar
 * Date: 5/23/2017
 * Time: 11:19 AM
 */

namespace App\Http\Traits;


use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * Automatically generates and adds UUID to model
     */
    protected static function boot() {
        Model::boot();
        static::creating(function($model) {
            if(!isset($model->attributes['id'])) {
                $model->attributes['id'] = Uuid::uuid4();
            } else {
                $model->{$model->getKeyName()} = $model->attributes['id'];
            }
        });
    }
}