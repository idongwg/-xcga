<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Repositories\SweeperRepository;

class SweeperApiController extends ApiController {

    protected $sweepers;

    public function __construct(SweeperRepository $sweepers) {
        parent::__construct();
        $this->sweepers = $sweepers;
    }

    public function index() {
        $query = $this->sweepers->newQuery();

        //$query = $query->select('uuid', 'code', 'rfid', 'title', 'contact', 'phone', 'address', 'latitude', 'longitude', 'department_uuid', 'level_type', 'manage_type', 'cleaner', 'start_time', 'end_time', 'status');

        $request = request();
        
        if ($request->has('sweeper_type')) {
            $query = $query->where('sweeper_type', $request->input('sweeper_type'));
        }

        if ($request->has('status')) {
            $query = $query->where('status', $request->input('status'));
        }

        if ($request->has('page')) {
            $page_size = $request->input('page_size', 15);
            $query = $query->forPage($request->input('page'), $page_size);
        }

        $query = $query->orderBy('code');

        $data = $query->get();

        return $this->success($data);
    }

    public function show($uuid) {
        $sweeper = $this->sweepers->get($uuid);
        if (! $sweeper) {
            return $this->error([], trans('action.get_error'));
        }
        return $this->success($sweeper);
    }

}