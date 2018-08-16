<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\User;


class DataUpdatedApiController extends Controller {

    protected $cache_minutes = 10080;   //一周

    public function __construct() {
    }

    public function index() {
        $data = [
            'sweepers' => $this->dataUpdatedAt('sweepers')
        ];
        return $this->success($data);
    }

    protected function dataUpdatedAt($table) {
        $key = $table . 'updated-at';
        $value = Cache::remember($key, $this->cache_minutes, function () use ($table) {;
            return strtotime(DB::table($table)->max('updated_at'));
        });
        if ($value) {
            return $value;
        }
        return 0;
    }

}
