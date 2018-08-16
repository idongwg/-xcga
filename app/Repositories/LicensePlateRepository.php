<?php namespace App\Repositories;

class LicensePlateRepository extends BaseRepositoryService {

    public function __construct() {
        parent::__construct('App\Models\LicensePlate');
    }
    
}