<?php namespace App\Models;

class Sweeper extends BaseModel {

    protected $table = 'sweepers';

    protected $fillable = ['uuid', 'code', 'title', 'rfid', 'department_uuid', 'device_uuid', 'engine_number', 'chassis_number', 'model_number', 'manufacturer', 'status', 'description', 'image'];

    protected $hidden = ['status', 'created_at', 'updated_at'];

    public function findByRfid($rfid) {
        return $this->newQuery()->where('rfid', $rfid)->first();
    }

    public static function firstByRfid($rfid) {
        return (new static)->findByRfid($rfid);
    }
    
//    public function department() {
//        return $this->belongsTo('App\Models\Department', 'department_uuid', 'uuid');
//    }

    public function getImageUrlAttribute() {
        if (empty($this->attributes['image'])) {
            return url('/uploads/noicon.jpg');
        }
        return url($this->attributes['image']);
    }

    public function toArray() {
        $attributes = parent::toArray();
        $attributes['image_url'] = $this->getImageUrlAttribute();
        return $attributes;
    }
    
}