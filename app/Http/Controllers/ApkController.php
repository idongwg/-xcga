<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppVersion;

class ApkController extends Controller {

    public function download() {
        $version = AppVersion::where('platform', 'android')->where('status', 'online')->orderBy('id', 'DESC')->first();
        if ($version && $version->upgrade_url) {
            //return response()->download($version->upgrade_url);
            return response()->download(rtrim(base_path(utf8_decode('xxx.apk'))));
        }
        return '没有找到下载的APK';
    }

}

