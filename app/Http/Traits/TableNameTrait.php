<?php
/**
 * Created by PhpStorm.
 * User: karolis
 * Date: 5/24/2017
 * Time: 10:41 AM
 */

namespace App\Http\Traits;


trait TableNameTrait
{
    /**
     * Adds model function to generate clean model name for use in controller, blade route name and page title
     */

    public function getTableName()
    {
        $tableName = substr($this->table, 3);
        return $tableName;
    }
}