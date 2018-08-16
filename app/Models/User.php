<?php namespace App\Models;

use App\AuthUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthUser {

//    use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    protected $hidden = ['password', 'remember_token', 'avatar', 'status', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['token', 'uuid', 'username', 'password', 'realname', 'title', 'rfid', 'phone', 'mobile', 'email', 'department_uuid', 'team_uuid', 'role_uuid', 'avatar', 'status', 'latitude', 'longitude', 'channel_id', 'app_version'];

    //protected $dates = ['deleted_at'];

    public function getModelName() {
        return class_basename($this);
    }

//    public function department() {
//        return $this->belongsTo('App\Models\Department', 'department_uuid', 'uuid');
//    }
//
//    public function role() {
//        return $this->belongsTo('App\Models\Role', 'role_uuid', 'uuid');
//    }

    public static function firstByUuid($uuid, $columns = ['*']) {
        return (new static)->findByUuid($uuid, $columns);
    }

    public function findByUuid($uuid, $columns = ['*']) {
        return $this->newQuery()->where('uuid', $uuid)->first($columns);
    }
    
    public function findByUsername($username) {
        return $this->newQuery()->where('username', $username)->first();
    }

    public function findByToken($token) {
        return $this->newQuery()->where('token', $token)->first();
    }

    public function findByRfid($rfid) {
        return $this->newQuery()->where('rfid', $rfid)->first();
    }
    
    public static function firstByUsername($username) {
        return (new static)->findByUsername($username);
    }

    public static function firstByToken($token) {
        return (new static)->findByToken($token);
    }

    public static function firstByRfid($rfid) {
        return (new static)->findByRfid($rfid);
    }
    
    public function getAvatarUrlAttribute() {
        if (empty($this->attributes['avatar'])) {
            return url('/uploads/noavatar.png');
        }
        return url($this->attributes['avatar']);
    }

    public function toArray() {
        $attributes = parent::toArray();
        $attributes['avatar_url'] = $this->getAvatarUrlAttribute();
        return $attributes;
    }

}
