<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserLoginApiController extends Controller {

    public function __construct() {
    }

    public function index() {
        return $this->authentication(request());
    }

    public function store(Request $request) {
        return $this->authentication($request);
    }
    
    protected function authentication(Request $request) {
        $inputs = $request->all();

        if($request->has('username')) {
            $username = $request->input('username');
        } else if($request->has('uuid')) {
            $username = $request->input('uuid');
        } else {
            return $this->error($inputs, trans('auth.username_required'));
        }

        if($request->has('password')) {
            $password = $request->input('password');
        } else {
            return $this->error($inputs, trans('auth.password_required'));
        }

        if (empty($username) || (strlen($username) < 3)) {
            return $this->error($inputs, trans('auth.username_or_password_incorrect'));
        }

        $by_uuid = array(
            'uuid' => $username,
            'password' => $password
        );

        $by_username = array(
            'username' => $username,
            'password' => $password
        );

        /*
        if (! Auth::once($by_username)) {
            return $this->error($inputs, trans('auth.username_or_password_incorrect'));
        }
        */

        if (! Auth::once($by_uuid)) {
            if (! Auth::once($by_username)) {
                return $this->error($inputs, trans('auth.username_or_password_incorrect'));
            }
        }
        
        $user = Auth::user();
        if (! $user) {
            return $this->error($inputs, trans('auth.username_or_password_incorrect'));
        } else {
            if($request->has('channel_id')) {
                $user->channel_id = $request->input('channel_id');
            }
            if($request->has('app_version')) {
                $user->app_version = $request->input('app_version');
            }
            if($request->has('device_id')) {
                //$user->token = bcrypt($user->uuid . 'on' . $request->input('device_id'));
            }
            $user->status = 'online';
            $user->save();
            return $this->success($user);
        }
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

}
