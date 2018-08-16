<?php
//require_once "vendor/autoload.php";
require __DIR__.'/../bootstrap/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Hprose\Http\Server;
use App\Models\Complaint;

function complaints($department) {
    return Complaint::where('department_uuid', $department)->get()->toArray();
}

function hello($name) {
    return "Hello $name!";
}

$server = new Server();
//$server->addFilter(new CompressFilter());
$server->addFunction('complaints');
$server->addFunction('hello');
$server->crossDomain = true;
$server->start();