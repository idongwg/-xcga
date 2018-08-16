<?php namespace App\Http\Controllers\Api;

use App\Models\LicensePlate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Repositories\LicensePlateRepository;
use App\Models\User;

class LicensePlateApiController extends ApiController {

    protected $licensePlates;
    protected $need_auth = false;

    public function __construct(LicensePlateRepository $licensePlates) {
        parent::__construct();
        $this->licensePlates = $licensePlates;
    }

    public function index(Request $request) {
        $query = $this->licensePlates->newQuery();

        $query = $query->select('title', 'latitude', 'longitude', 'location', 'image', 'created_at');

        if ($request->has('device')) {
            $query = $query->where('device_uuid', $request->input('device'));
        }

        if ($request->has('year')) {
            $query = $query->where('year', $request->input('year'));
        }

        if ($request->has('month')) {
            $query = $query->where('month', $request->input('month'));
        }

        if ($request->has('day')) {
            $query = $query->where('day', $request->input('day'));
        }

        if ($request->has('keyword')) {
            $query = $query->where('keyword', $request->input('keyword'));
        }

        if ($request->has('page')) {
            $page_size = $request->input('page_size', 15);
            $query = $query->forPage($request->input('page'), $page_size);
        }

        $query = $query->orderBy('id', 'DESC');

        $data = $query->get();

        return $this->success($data);
    }

}
