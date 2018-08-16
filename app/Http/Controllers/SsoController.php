<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SsoController extends Controller {

    public function index() {
        return $this->login();
    }

    public function login() {

        $user = User::firstByUsername('admin');
        if ($user) {
            Auth::login($user);
        }

    }

}

