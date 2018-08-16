<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Repositories\LicensePlateRepository;
use App\Models\LicensePlate;

class LicensePlatesController extends AdminController {

    protected $licenseplates;

    public function __construct(LicensePlateRepository $licenseplates) {
        parent::__construct();
        $this->licenseplates = $licenseplates;
    }

    public function index() {
        $query = $this->licenseplates->newQuery();

        $request = request();

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

        if ($request->has('statistics')) {
            
            $query = $query->groupBy('title');
            
            $query = $query->orderBy('created_at','desc')->paginate(5);
            
            return $this->success($query);
        }

        if ($request->has('count')) {
            
            $query = $query->select('title');
            $query = $query->distinct()->get();

            return $query->count();
        }

        if ($request->has('day')) {
            $day=date('Y-m-d',$request->input('day'));

            $query = $query->where('day', $day);
        }

        if ($request->has('status')) {
            $query = $query->where('status', $request->input('status'));
        }

        if ($request->has('device_uuid')) {
            $query = $query->where('device_uuid', $request->input('device_uuid'));
        }

        if ($request->has('sweepers_title')) {
            $query = $query->where('sweepers_title', $request->input('sweepers_title'));
        }

        if ($request->has('title')) {
            $query = $query->where('title', $request->input('title'));
        }

        $query = $query->orderBy('created_at','desc')->paginate(5);

        return $this->success($query);
    }
    
    public function delete(Request $request)
    {
        $request = request();

        // if ($this->is_Admin()) {
        //  return $this->error([], trans('您没有权限操作，请联系管理员！！'));
        // }
        $exits = $this->licenseplates->deleteById($request->id);
        if (!$exits) {
            return $this->error([], trans('action.delete_error'));
        }

        return $this->success('成功');
    }

    public function edit(Request $request)
    {
        $request = request();

        $model = $this->licenseplates->findById($request->id);

        return $this->success($model);
    }

    public function update(Request $request)
    {

        $request = request();

        $inputs = $this->validateForm($request);

        if (!$this->licenseplates->updateById($request->id, $inputs)) {
            return $this->error([], trans('action.update_error'));
        }
        return $this->success('成功');
    }

    public function show(Request $request) {
        $request = request();

        $sweeper = $this->licenseplates->findById($request->id);
        if (! $sweeper) {
            return $this->error([], trans('action.get_error'));
        }
        return $this->success($sweeper);
    }

    public function vague() {
        $query = $this->licenseplates->newQuery();

        $request = request();

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
        
        $query = $query->where('status', 'new');

        if ($request->has('location')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('location').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('location','like', $like_keyword);
            });
        }

        if ($request->has('sweepers_title')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('sweepers_title').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('sweepers_title','like', $like_keyword);
            });
        }

        if ($request->has('title')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('title').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('title','like', $like_keyword);
            });
        }

        $query = $query->orderBy('created_at','desc')->paginate(4);

        return $this->success($query);
    }

    protected function rules()
    {
        return [
            'title' => 'required',
            'device_uuid' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }

}