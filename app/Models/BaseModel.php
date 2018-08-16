<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
	
	public function getModelName() {
		return class_basename($this);
	}

    public static function firstByUuid($uuid, $columns = ['*']) {
        return (new static)->findByUuid($uuid, $columns);
    }
    
    public function findByUuid($uuid, $columns = ['*']) {
        return $this->newQuery()->where('uuid', $uuid)->first($columns);
    }

}
