<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hprose\Http\Server;
use Hprose\Client;
use Hprose\InvokeSettings;
use Hprose\ResultMode;

class RpcController extends Controller {

    public function index() {
        return $this->server();
    }

    public function server() {
        $server = new Server();
        //$server->addMethod('hello');
        $server->addFunction(array(__NAMESPACE__ . '\\' . class_basename($this), 'hello'));
        $server->start();
    }

    public function client() {
        $client = new \Hprose\Http\Client('http://127.0.0.1/xchw/v2/public/rpc.php', false);
        dd($client->complaints('dept-xjwy'));
    }

    public function test() {
        $client = new \Hprose\Http\Client('http://119.90.36.235/v3/public/rpc.php', false);

        //$client->addFilter(new CompressFilter());
        dd($client->hello('world'));

//        $client->hello()
//            ->then(function ($result) {
//                var_dump($result);
//            });
    }

    /*
    public function test() {
        $client = new \Hprose\Http\Client('http://127.0.0.1/xchw/v2/public/rpc', false);
        dd($client->hello());
    }*/


    public function hello() {
        return "Hello!";
    }

}

