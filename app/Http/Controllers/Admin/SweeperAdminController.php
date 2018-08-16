<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Repositories\SweeperRepository;
use App\Repositories\LicensePlateRepository;

class SweeperAdminController extends AdminController {

    protected $sweepers;
    protected $licenseplates;
    protected $field = 'image';

    public function __construct(SweeperRepository $sweepers,LicensePlateRepository $licenseplates) {
        parent::__construct();
        $this->sweepers = $sweepers;
        $this->licenseplates = $licenseplates;

    }

    public function index() {
        $query = $this->sweepers->newQuery();

        $request = request();
        
        if ($request->has('keyword')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('keyword').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('uuid','like', $keyword)
                    ->orWhere('title', 'like', $like_keyword)
                    ->orWhere('device_uuid', 'like', $like_keyword);
            });
        }
        
        if ($request->has('sweeper_type')) {
            $query = $query->where('sweeper_type', $request->input('sweeper_type'));
        }

        if ($request->has('status')) {
            $query = $query->where('status', $request->input('status'));
        }

        $query = $query->orderBy('code')->paginate(10);

        return $this->success($query);
    }

    public function create(){
        $strToken = csrf_token();
        return $strToken;
    }

    public function save(Request $request) {
        $inputs = $this->validateForm($request, $this->rules());

        $uuid=$request->input('uuid');
        if(!$uuid){
            $title=$request->input('title');
            $titlename=substr($title,3);

            $uuid=time().$titlename;
        }
        
        $inputs['uuid'] = $uuid;
        $inputs['code'] = $uuid;

        $models = $this->sweepers->save($inputs);
        if (! $models) {
            return $this->error([], trans('action.save_error'));
        }

        return $this->success($models);
    }

    public function delete(Request $request)
    {
        $request = request();

        // if ($this->is_Admin()) {
            // return $this->error([], trans('您没有权限操作，请联系管理员！！'));
        // }
        $exits = $this->sweepers->delete($request->uuid);
        if (!$exits) {
            return $this->error([], trans('action.delete_error'));
        }

        return $this->success('成功');

    }

    public function edit(Request $request)
    {
        $request = request();

        $model = $this->sweepers->findByUuid($request->uuid);
        return $this->success($model);

    }

    public function update(Request $request)
    {
        $request = request();

        $inputs = $this->validateForm($request);
        $uuid=$request->input('uuid');

        if (!$this->sweepers->update($request->uuid, $inputs)) {
            return $this->error([], trans('action.update_error'));
        }
        
        return $this->success('成功');
    }

    public function show(Request $request) {
        $request = request();

        $sweeper = $this->sweepers->get($request->uuid);
        if (! $sweeper) {
            return $this->error([], trans('action.get_error'));
        }
        return $this->success($sweeper);
    }

    public function status(){
        $query = $this->sweepers->newQuery();
        $request = request();

        $data=array();
        $sweeper_count=$query->count(); //总车辆

        $countdata = $query->where('status', 'onstart')->count();
        $sweeper_onstart=$countdata; //正在工作的车辆

        $license_count = $this->licenseplates->newQuery();
        $license_count = $license_count->select('title');

        $license = $license_count->distinct()->get();
        $license=$license->count();  //总共扫到的车牌号

        $day=date('Y-m-d');
        $license_day = $license_count->where('day', $day);

        $license_day = $license_day->distinct()->get();
        $license_day=$license_day->count(); //今天扫到的车牌号

        $data['sweeper_count'] = $sweeper_count;
        $data['sweeper_onstart'] = $sweeper_onstart;
        $data['license_count'] = $license;
        $data['license_day'] = $license_day;

        return $data;
    }

    public function statistics(){
        $request = request();

        $license_count=$this->licenseplates->groupBy('title')->get();

        if ($request->has('day')) {
            $day=date('Y-m-d');
            $license_count = $license_count->where('day', $day);
        }

        $license_count = $license_count->orderBy('created_at','desc')->paginate(5);

        return $this->success($license_count);
    }

    public function license(Request $request) {
        $request = request();

        $query = $this->licenseplates->newQuery();

        if ($request->has('device_uuid')) {
            $query = $query->where('device_uuid',$request->input('device_uuid'));
        }

        if ($request->has('day')) {
            
            $day=date('Y-m-d',$request->input('day'));
            $query = $query->where('day', $day);
        }
        
        if ($request->has('keyword')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('keyword').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('title','like', $keyword)
                    ->orWhere('location', 'like', $like_keyword)
                    ->orWhere('device_uuid', 'like', $like_keyword);
            });
        }

        if ($request->has('start_time') && $request->has('end_time')) {

            $start_time=date('Y-m-d H:i:s',$request->input('start_time'));
            $end_time=date('Y-m-d H:i:s',$request->input('end_time'));
            $query = $query->whereBetween('created_at', [$start_time, $end_time]);
        }

        $query = $query->orderBy('created_at','desc')->paginate(5);

        return $this->success($query);
    }

    protected function rules()
    {
        return [
            // 'uuid' => 'required',
            // 'code' => 'required',
            'title' => 'required',
            // 'device_uuid' => 'required',
        ];
    }

}