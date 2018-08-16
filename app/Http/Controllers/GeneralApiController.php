<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BaseRepositoryService;


class GeneralApiController extends ApiController {

    protected $repository;

    public function __construct($model) {
        parent::__construct();
        if ($model) {
            $this->repository = new BaseRepositoryService($model);
        }
    }

    public function index() {
        $data = $this->repository->get();
        return $this->success($data);
    }

    public function store(Request $request) {
        return $this->save($request);
    }

    public function save(Request $request) {
        $inputs = $request->all();
        $inputs['uuid'] = $this->newUuid();

        if (! $this->repository->save($inputs)) {
            return $this->error($inputs, trans('action.save_error'));
        }
        return $this->success();
    }

    public function show($uuid) {
        $model_info = $this->findByUuid($uuid);
        if (! $model_info) {
            return $this->error([], trans('action.get_error'));
        }
        return $this->success($model_info);
    }

    public function update(Request $request, $uuid) {
        $inputs = $request->all();
        if (! $this->repository->update($uuid, $inputs)) {
            return $this->error($inputs, trans('action.update_error'));
        }
        return $this->success();
    }

    public function destroy($uuid) {
        return $this->delete($uuid);
    }

    public function delete($uuid) {
        $this->repository->delete($uuid);
        return $this->success();
    }
    
    public function newQuery() {
        return $this->repository->newQuery();
    }
    
    protected  function findByUuid($uuid) {
        return $this->repository->findByUuid($uuid);
    }
    
    protected function newUuid() {
        return $this->randomUuid($this->repository->getModelName());
    }
    
}
