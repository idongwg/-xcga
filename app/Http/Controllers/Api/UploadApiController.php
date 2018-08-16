<?php namespace App\Http\Controllers\Api;

use App\Models\LicensePlate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Repositories\LicensePlateRepository;
use App\Models\User;

class UploadApiController extends ApiController {

    protected $licensePlate;
    protected $field = 'file';

    public function __construct(LicensePlateRepository $licensePlate) {
        parent::__construct();
        $this->licensePlate = $licensePlate;
    }

    public function index() {
        return $this->save(request());
    }

    public function store(Request $request) {
        return $this->save($request);
    }
    
    protected function save(Request $request) {
        if (! $request->has('device_uuid')) {
            return $this->error([], '缺少设备uuid');
        }

        $inputs = $request->all();

        $title = $request->input('title');

        $date_info = getdate();
        if (isset($date_info['year'])) {
            $inputs['year'] = $date_info['year'];
        }
        if (isset($date_info['mon'])) {
            $inputs['month'] = $date_info['mon'];
        }

        $inputs['day'] = date('Y-m-d');

        $titlename=substr($title,6);
        if ($request->hasFile($this->field)) {
            $file = $request->file($this->field);
            if ($file->isValid()) {
                $file_type = $file->getClientOriginalExtension();
                $file_path = 'uploads/' . date('Y-m-d') . '/';
                $uuid = date("His") . '-' . $titlename . '-' . str_random(4);
                $file_name = $uuid . '.' . $file_type;

                $real_path = public_path($file_path);
                if (!file_exists($real_path)) {
                    if (!mkdir($real_path, 0777, true)) {
                        return false;
                    }
                }

                $file->move($real_path, $file_name);
            }
        }

        $inputs['image'] = $file_path.$file_name;

        if (! $this->licensePlate->save($inputs)) {
            return $this->error($inputs, trans('action.save_error'));
        }

        return $this->success();
    }

}
