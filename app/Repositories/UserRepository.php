<?php namespace App\Repositories;

class UserRepository extends BaseRepositoryService {

    public function __construct() {
        parent::__construct('App\Models\User');
    }

    public function updateDepartment($uuid, $department) {
        if (! $uuid) {
            return false;
        }
        if (! $department) {
            return false;
        }
        $user = $this->findByUuid($uuid);
        if (! $user) {
            return false;
        }
        $user->department_uuid = $department;
        $user->save();

        return $user;
    }

    public function updatePassword($uuid, $password) {
        if (! $uuid) {
            return false;
        }
        if (! $password) {
            return false;
        }
        $user = $this->findByUuid($uuid);
        if (! $user) {
            return false;
        }
        $user->password = $password;
        $user->save();

        return $user;
    }
    
}