<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected function inputJson() {
        return $this->getRawPostData();
    }

    protected function responseJson($data, $status = 200) {
        return response()->json($data, $status);
    }

    protected function success($data = [], $message = '成功') {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return $this->responseJson(array(
            'success' => true,
            'data' => $data,
            'message' => $message
        ));
    }

    protected function error($data = [], $message = '', $code = 200) {
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return $this->responseJson(array(
            'success' => false,
            'data' => $data,
            'message' => $message
        ), $code);
    }

    protected function getRawPostData() {
        if (isset($HTTP_RAW_POST_DATA)) {
            $json_data = $HTTP_RAW_POST_DATA;
        } else {
            $json_data = file_get_contents('php://input');
        }
        return json_decode($json_data, true);
    }

    protected function randomUuid($prefix = 'N') {
        $random = date("Ymd-His");
        $suffix = str_random(4);    //rand(1000,9999);
        return strtolower($prefix . '-' . $random . '-' . $suffix);
    }
    
}

