<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('login', 'Api\UserLoginApiController', ['only' => ['index', 'store']]);

Route::resource('logout', 'Api\UserLogoutApiController', ['only' => ['index', 'store']]);
Route::resource('sweeper', 'Api\SweeperApiController', ['only' => ['index', 'show']]);

Route::resource('set-sweeper-device', 'Api\SetSweeperDeviceApiController', ['only' => ['index', 'store']]); //手持登录 online
Route::resource('start', 'Api\StartApiController', ['only' => ['index', 'store']]); // 开始工作 onstart
Route::resource('upload', 'Api\UploadApiController', ['only' => ['index', 'store']]); // 手持设备上传储存
Route::resource('stop', 'Api\StopApiController', ['only' => ['index', 'store']]); // 工作结束 offline

Route::resource('license-plate', 'Api\LicensePlateApiController', ['only' => ['index', 'store']]);

Route::resource('upload-file', 'Api\UploadFileApiController', ['only' => ['index', 'store']]);

Route::resource('app-version', 'Api\AppVersionApiController', ['only' => ['index', 'show']]);

Route::resource('data-updated', 'Api\DataUpdatedApiController', ['only' => ['index']]);
