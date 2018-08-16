<?php namespace App\Repositories;

class AppVersionRepository extends BaseRepositoryService {

    public function __construct() {
        parent::__construct('App\Models\AppVersion');
    }
    
}