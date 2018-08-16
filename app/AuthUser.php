<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthUser extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'realname', 'title', 'department_uuid', 'role_uuid', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

//    public function role()
//    {
//        return $this->belongsTo('App\Models\Role', 'role_uuid', 'uuid');
//    }

    public function has($permission)
    {
        if ($this->username == 'admin') {
            return true;
        }
        if (!$this->role) {
            return false;
        }
        if ($this->role_uuid == 'role-admin') {
            return true;
        }
        if ($permission == 'admin_system') {
            return false;
        }
        if ($this->role_uuid == 'role-manager') {
            return true;
        }

        return $this->hasPermission($permission);
    }

    public function hasPermission($permission)
    {
        return $this->role->hasPermission($permission);
        /*
        if (!$this->permission) {
            return false;
        }
        $permissions = explode(",", $this->permission);
        return in_array($permission, $permissions);
        */


    }


}
