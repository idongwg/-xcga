<?php namespace App\Models;

class AppVersion extends BaseModel {

    protected $table = 'app_versions';

    protected $fillable = ['uuid', 'version_name', 'version_code', 'platform', 'upgrade_method', 'upgrade_url', 'status', 'description'];

    protected $hidden = ['status', 'created_at', 'updated_at'];
    
}