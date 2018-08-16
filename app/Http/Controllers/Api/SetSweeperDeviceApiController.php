<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Repositories\SweeperRepository;

class SetSweeperDeviceApiController extends ApiController {

    protected $sweepers;

    public function __construct(SweeperRepository $sweepers) {
        parent::__construct();
        $this->sweepers = $sweepers;
    }

    public function index() {
        return $this->store(request());
    }

    public function store(Request $request) {
        $inputs = $request->all();

        if(! $request->has('title')) {
            return $this->error($inputs, trans('缺少车辆title'));
        }
        if(! $request->has('device_uuid')) {
            return $this->error($inputs, trans('缺少设备uuid'));
        }
        $title = $request->input('title');
        $device = $request->input('device_uuid');

        $sweeper = $this->sweepers->findBy('title',$title);
        if (! $sweeper) {
            return $this->error($inputs, '没有找到车辆信息');
        }

        $sweeper->device_uuid = $device;
        $sweeper->status = 'online';
        $sweeper->save();

        return $this->success($sweeper);

    }


}