<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Repositories\BaseRepositoryService;

class AppVersionAdminController extends AdminController {

    protected $versions;

    public function __construct() {
        parent::__construct();
        $this->versions = new BaseRepositoryService('App\Models\AppVersion');
    }

    public function index() {
        $query = $this->versions->newQuery();
        $query = $query->orderBy('id', 'DESC');
        $versions = $query->get();

        return $this->success($versions);
    }

    public function create() {
        return view('version.create');
    }

    public function edit($uuid) {
        $version = $this->versions->findByUuid($uuid);
        if (! $version) {
            return $this->back();
        }

        return $this->success($version);
    }

    public function save(Request $request) {
        $inputs = $this->validateForm($request, $this->rules());
        $inputs['uuid'] = $this->newUuid($request->input('version_name'), $request->input('version_code'));

        if (! $this->versions->save($inputs)) {
            return $this->back()->with('error', trans('action.save_error'));
        }

        return $this->success('版本数据添加完成');
    }

    public function update(Request $request) {
        $uuid = $request->input('uuid');
        $inputs = $this->validateForm($request);
        if (! $this->versions->update($uuid, $inputs)) {
            return $this->back()->with('error', trans('action.update_error'));
        }

        return $this->success('版本数据修改完成');
    }

    public function publish(Request $request) {
        $request = request();

        if (! $this->versions->updateStatus($request->uuid, 'online')) {
            return $this->back()->with('error', '版本发布失败');
        }

        return $this->success('版本已发布');
    }

    public function unPublish(Request $request) {
        $request = request();
        
        if (! $this->versions->updateStatus($request->uuid, 'offline')) {
            return $this->back()->with('error', '版本发布失败');
        }

        return $this->success('版本已取消发布');
    }

    public function delete(Request $request) {
        $request = request();

        if(! $this->versions->delete($request->uuid)){
            return $this->error([], trans('action.delete_error'));
        }

        return $this->success('删除成功');
    }

    public function show($uuid) {
        $version = $this->versions->findByUuid($uuid);
        if (! $version) {
            return $this->back()->with('error', '没有找到相应数据');
        }

        return $this->success($version);
    }

    protected function rules() {
        return [
            'version_name' => 'required',
            'version_code' => 'required',
            'upgrade_url' => 'required|url',
        ];
    }

    protected function newUuid($name, $code) {
        return 'version-' . $name . '-' . $code . '-' . date("His");
    }
    
}