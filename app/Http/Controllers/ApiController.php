<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class ApiController extends Controller {

    protected $need_auth = true;
    protected $auth_user = false;

    public function __construct() {
        if ($this->need_auth) {
            $this->auth_user = $this->authentication();
        }
    }

    protected function authentication() {
        //$token = request()->input('token', request()->header('token'));
        $token = request()->header('token', request()->input('token'));
        if (! $token) {
            //abort(401, trans('auth.token_required'));
            throw new AuthenticationException(trans('auth.token_required'));
        }

        $user = User::firstByToken($token);
        if (! $user) {
            //abort(401, trans('auth.token_invalid'));
            throw new AuthenticationException(trans('auth.token_invalid'));
        }

        return $user;
    }
    
    protected function createData() {
        $inputs = $this->inputData();
        if (! isset($inputs['uuid'])) {
            $inputs['uuid'] = $this->newUuid();
        }
        if ($this->need_auth) {
            $user = $this->auth_user;
            $inputs['user_id'] = $user->id;
            $inputs['user_uuid'] = $user->uuid;
        }
        return $inputs;
    }

    protected function updateData() {
        $inputs = $this->inputData();
        if (isset($inputs['uuid'])) {
            unset($inputs['uuid']);
        }
        if ($this->need_auth) {
            $user = $this->auth_user;
            $inputs['user_id'] = $user->id;
            $inputs['user_uuid'] = $user->uuid;
        }
        return $inputs;
    }

    protected function inputData() {
        $inputs = request()->all();
        if (empty($inputs)) {
            $data = $this->inputJson();
            if (! empty($data)) {
                $inputs = $data;
            }
        }
        return $inputs;
    }

    protected function newUuid() {
        return $this->randomUuid();
    }
    
}
