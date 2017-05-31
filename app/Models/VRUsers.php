<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VRUsers extends Authenticatable
{

    use Notifiable;

    use SoftDeletes;

    protected $table = 'vr_users';

    protected $fillable = ['id', 'name', 'surname', 'password', 'email', 'phone'];

    public $incrementing = false;

    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            if(!isset($model->attributes['id'])) {
                $model->attributes['id'] = Uuid::uuid4();
            } else {
                $model->{$model->getKeyName()} = $model->attributes['id'];
            }
        });
    }


    public function connection()
    {
        return $this->belongsToMany(VRRoles::class, 'vr_users_roles_connections', 'users_id', 'roles_id');
    }


    public function rolesConnections()
    {
        return $this->hasMany(VRUsersRolesConnections::class, 'users_id', 'id');
    }
    public function getFillable()
    {

        unset($this->fillable[0]);
        return $this->fillable;

    }

    public function getTableName()
    {
        $tableName = substr($this->table, 3);
        return $tableName;
    }

}
