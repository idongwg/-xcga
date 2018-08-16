<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserLogoutApiController extends Controller {

    public function __construct() {
    }

    public function index() {
        return $this->save(request());
    }

    public function save(Request $request) {
        //Auth::logout();
        $token = $request->input('token', $request->header('token'));
        if ($token) {
            $user = User::firstByToken($token);
            if ($user) {
                $user->status = 'offline';
                $user->channel_id = '';
                $user->save();

                return $this->success();
            }
        }

    }

}
