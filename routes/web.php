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
    return view('welcome');
});

//Route::get('/test/vue', function () {
//    return view('vue.main');
//});

Route::get('/test/vue/{any}', function () {
    return view('vue.main');
})->where('any','.*');

//测试新建provider来实例化service
Route::get('/test/index', 'TestController@index');
