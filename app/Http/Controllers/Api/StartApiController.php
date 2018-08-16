<?php 

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Repositories\SweeperRepository;

class StartApiController extends ApiController {

    protected $sweepers;

    public function __construct(SweeperRepository $sweepers) {
        parent::__construct();
        $this->sweepers = $sweepers;
    }

    public function index() {
        return $this->start(request());
    }

    public function store(Request $request) {
        return $this->start($request);
    }
    
    protected function start(Request $request) {
        $inputs = $request->all();

        if(! $request->has('title')) {
            return $this->error($inputs, trans('缺少车辆title'));
        }
        if(! $request->has('device_uuid')) {
            return $this->error($inputs, trans('缺少设备uuid'));
        }
        $title = $request->input('title');
        $device = $request->input('device_uuid');


        $sweeper = $this->sweepers->findBy('title',$title)->Where('device_uuid', $device)->where('status', 'online')->first();

        if (! $sweeper) {
            return $this->error($inputs, '没有找到车辆信息');
        }

        $array=array();
        $array['status'] = 'onstart';

        $this->sweepers->update($sweeper->uuid,$array);

        return $this->success();
    }

}
