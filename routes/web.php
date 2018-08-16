<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){

	Route::get('sweeper/create/', 'SweeperAdminController@create');
	
	// 用户管理
	Route::get('users','UserAdminController@index');
	Route::post('users/save/', 'UserAdminController@save');
	Route::get('users/delete/', 'UserAdminController@delete');
	Route::get('users/edit/', 'UserAdminController@edit');
	Route::post('users/update/', 'UserAdminController@update');
	Route::post('users/updatepassword/', 'UserAdminController@updatePassword');
	Route::get('users-show/', 'UserAdminController@show');

	// 后台车辆信息
	Route::get('sweeper','SweeperAdminController@index');
	Route::post('sweeper/save/', 'SweeperAdminController@save');
	Route::get('sweeper/delete/', 'SweeperAdminController@delete');
	Route::get('sweeper/edit/', 'SweeperAdminController@edit');
	Route::post('sweeper/update', 'SweeperAdminController@update');
	Route::get('sweepe-show/', 'SweeperAdminController@show');
	Route::get('sweeper-license/', 'SweeperAdminController@license');
	Route::get('sweeper-status/', 'SweeperAdminController@status');
	// Route::get('sweeper/statistics', 'SweeperAdminController@statistics');
	

	// 拍照管理
	Route::get('license-plates','LicensePlatesController@index');
	Route::get('license-plates/delete/', 'LicensePlatesController@delete');
	Route::get('license-plates/edit/', 'LicensePlatesController@edit');
	Route::post('license-plates/update/', 'LicensePlatesController@update');
	Route::get('license-show/', 'LicensePlatesController@show');
	Route::get('license-vague/', 'LicensePlatesController@vague');

	// app版本信息
	Route::get('app-version','AppVersionAdminController@index');
	Route::post('version/save','AppVersionAdminController@save');
	Route::get('version/delete', 'AppVersionAdminController@delete');
	Route::get('version/edit', 'AppVersionAdminController@edit');
	Route::post('version/update', 'AppVersionAdminController@update');
	Route::post('version/publish', 'AppVersionAdminController@publish');
	Route::post('version/unpublish', 'AppVersionAdminController@unPublish');
});
