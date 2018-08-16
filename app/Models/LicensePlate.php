<?php namespace App\Models;

class LicensePlate extends BaseModel {

    protected $table = 'license_plates';

    protected $fillable = ['uuid', 'sweepers_title', 'title', 'device_uuid', 'latitude', 'longitude', 'location', 'image', 'road_uuid', 'road_title', 'year', 'month', 'day', 'status', 'description'];

    protected $hidden = ['status', 'updated_at'];

    public function deviceuuid() {
        return $this->belongsTo('App\Models\Sweeper', 'device_uuid', 'device_uuid');

    }

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