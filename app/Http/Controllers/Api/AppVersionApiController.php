<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\GeneralApiController;
use App\Models\AppVersion;

class AppVersionApiController extends GeneralApiController {

    protected $need_auth = false;

    public function __construct() {
        parent::__construct('App\Models\AppVersion');
    }

    public function index($platform = 'android') {
        $version=AppVersion::where('platform', $platform)->where('status', 'online')->orderBy('id', 'DESC')->first();

        return $this->success($version);
    }

    public function show($id) {
        if ($id == 'android') {
            $version = $this->latest($id);
        } else if ($id == 'ios') {
            $version = $this->latest($id);
        } else {
            $version = $this->findByUuid($id);
        }
        return $this->success($version);
    }

    protected function latest($platform = 'android') {
        return AppVersion::where('platform', $platform)->where('status', 'online')->orderBy('id', 'DESC')->first();
    }
}