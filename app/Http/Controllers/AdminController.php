<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class AdminController extends Controller
{
    
    public function __construct()
    {
//        $this->middleware('auth');
    }

    protected function render($template, $data = array()) {
        return view($template, $data);
    }

    protected function back() {
        return back()->withInput();
    }

    protected function redirect($to = null, $message = null,$query=[]) {
        if (!$message) {
            //return redirect($to);
            return redirect()->route($to,$query);
        } else {
            //return redirect($to)->with('info', $message);
            return redirect()->route($to,$query)->with('info', $message);

        }
    }

    protected function validateForm(Request $request, $rules = [], $messages = []) {
        if (! empty($rules)) {
            $this->validate($request, $rules, $messages);
            //$this->validate($request, $rules, $messages, $this->transFields());
        }
        return $request->all();
        //return array_filter($inputs);
    }

    protected function departmentUuid() {
        return config('app.dept');
    }
    
    protected function transFields() {
        $file = new Filesystem();
        $trans_path = resource_path('lang/' . config('app.locale'));
        $field_trans = $trans_path . '/field.php';
        return $file->getRequire($field_trans);
    }
    
    /*
    protected function newUuid() {
        return $this->randomUuid();
    }
    */
    
}
