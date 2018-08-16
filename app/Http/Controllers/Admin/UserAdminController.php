<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Repositories\UserRepository;
use App\Models\Department;
use App\Models\Permission;

class UserAdminController extends AdminController {

    protected $users;

    public function __construct(UserRepository $users) {
        parent::__construct();
        $this->users = $users;
    }

    public function index() {
        $query = $this->users->newQuery();

        $query = $query->where('role_uuid', '<>', 'role-admin');

        $request = request();
        if ($request->has('keyword')) {
            $query = $query->where(function ($search_query) {
                $keyword = request('keyword').'%';
                $like_keyword = '%' . $keyword . '%';
                $search_query
                    ->where('username','like', $keyword)
                    ->orWhere('title', 'like', $like_keyword)
                    ->orWhere('realname', 'like', $like_keyword);
            });
        }
        $users = $query->orderBy('id','desc')->paginate(10);

        return $this->success($users);
    }

    public function save(Request $request) {
        $inputs = $this->validateForm($request, $this->rules());

        $username = $request->input('username');
        $password = $request->input('password');
        $team = $request->input('team_uuid');
        if(!$team){
            $team = 'back';
        }

        $exist = User::where('username', $username)->first();

        if ($exist) {
            return $this->error([], '此工号已经被使用,请输入其他工号');
        }
        $uuid = $this->newUuid($team, $username);

        $inputs['uuid'] = $uuid;
        $inputs['token'] = bcrypt($uuid);
        // $inputs['password'] = bcrypt($username);
        $inputs['password'] = bcrypt($password);
        if(!$request->input('realname')){
            $inputs['realname'] = '用户';
        }
 
        $user = $this->users->save($inputs);
        if (! $user) {
            return $this->error([], trans('action.save_error'));
        }

        return $this->success($user);
        
    }

    public function delete(Request $request) {
        $request = request();

        $user = $this->users->delete($request->uuid);
        if(!$user ){
            return $this->error([], trans('action.delete_error'));
        }

        return $this->success('删除成功');
    }

    public function edit(Request $request) {
        $request = request();

        $user = $this->users->findByUuid($request->uuid);
        if (! $user) {
            return $this->back();
        }

        return $this->success($user);
    }

    public function update(Request $request) {
        $uuid = $request->input('uuid');

        $inputs = $this->validateForm($request);

        if (! $this->users->update($uuid, $inputs)) {
            return $this->error([], trans('action.update_error'));

        }
        return $this->success('数据修改完成');
    }

    public function updateDepartment(Request $request) {
        $uuid = $request->input('uuid');
        if (! $this->users->updateDepartment($uuid, $request->input('department_uuid'))) {
            return $this->back()->with('error', trans('action.update_error'));
        }
        return $this->success('所属单位修改完成');
    }

    public function updatePassword(Request $request) {
        $uuid = $request->input('uuid');
        if (! $this->users->updatePassword($uuid, bcrypt($request->input('password')))) {
            return $this->back()->with('error', trans('action.update_error'));
        }
        return $this->success('密码修改完成');
    }

    public function show(Request $request) {
        $uuid = $request->input('uuid');

        $user = $this->users->findByUuid($uuid);
        if (! $user) {
            return $this->error([], '没有找到相应数据');

        }
        return $this->success($user);
    }

    protected function rules() {
        return [
            'username' => 'required',
            'password' => 'required',
            // 'realname' => 'required',
            // 'team_uuid' => 'required',
            // 'role_uuid' => 'required'
        ];
    }

    protected function rulesUpdate(){
        return [
            'realname' => 'required',
            'team_uuid' => 'required',
            'role_uuid' => 'required'
        ];
    }

    protected function newUuid($team_uuid, $username) {
        $uuid = $team_uuid . '-' . $username;

        $exist = $this->users->withTrashed()->where('uuid',$uuid)->first();
        if ($exist) {
            $uuid = $uuid . '-' . str_random(4);
        }
        return $uuid;
    }

    protected function roles() {
        //return Role::all()->pluck('title', 'uuid')->toArray();
        return Role::where('status', 'online')->where('uuid', '<>', 'role-admin')->pluck('title', 'uuid')->toArray();
    }

    protected function departments() {
        //return Department::all()->pluck('title', 'uuid')->toArray();
        return Department::where('parent', 'dept-1')->pluck('title', 'uuid')->toArray();
    }

    protected function teams() {

        return Department::where('parent', $this->departmentUuid())->pluck('title', 'uuid')->toArray();
    }
}