<?php
/**
 * Created by PhpStorm.
 * User: karolis
 * Date: 5/24/2017
 * Time: 10:40 AM
 */

namespace App\Http\Traits;


trait FillableTrait
{
    /**
     * Generates list of fillable model columns without first item (id) for use in controller and blade
     */

    public function getFillable() {

        if(sizeof($this->fillable) > 1) {
            unset($this->fillable[0]);
        }
        return $this->fillable;

    }
}