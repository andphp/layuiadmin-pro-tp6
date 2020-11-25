<?php

/**
 * Created by PhpStorm.
 * User: DaXiong
 * Date: 2020/10/15
 * Time: 10:21 PM
 */

use \think\facade\Route;
Route::get('login','User/login');
Route::get('test','Test/index');

Route::group('', function () {
Route::group('menu', function () {
    Route::get('/main','Menu/main');
    Route::post('/save','Menu/save');
    Route::get('/list','Menu/list');
    Route::get('/select','Menu/select');
    Route::post('/del','Menu/delete');
    Route::get('/select_adopt','Menu/selectAdopt');
});

Route::group('role',function (){
    Route::get('/','Role/index');
    Route::post('/save','Role/save');
    Route::post('/del','Role/delete');
    Route::post('/del_batch','Role/deleteBatch');
    Route::post('/update_status_batch','Role/updateStatusBatch');
    Route::get('/select','Role/select');
});

Route::group('department',function (){
    Route::get('/','Department/index');
    Route::post('/save','Department/save');
    Route::get('/select','Department/select');
    Route::post('/del','Department/delete');
});

Route::group('job',function (){
    Route::get('/','Job/index');
    Route::post('/save','Job/save');
    Route::post('/del','Job/delete');
    Route::post('/del_batch','Job/deleteBatch');
    Route::post('/update_status_batch','Job/updateStatusBatch');
    Route::get('/select','Job/select');
});

Route::group('user',function (){
    Route::get('/','User/index');
    Route::post('/save','User/save');
    Route::post('/del','User/delete');
    Route::post('/del_batch','User/deleteBatch');
    Route::post('/update_status_batch','User/updateStatusBatch');
});

Route::group('config',function (){
    Route::get('/','Conf/index');
    Route::get('/group','Conf/group');
    Route::post('/save','Conf/save');
    Route::post('/update_batch','Conf/updateBatch');
});

Route::group('upload',function (){
    Route::get('/','Upload/index');
    Route::post('/img','Upload/uploadImg');
    Route::post('/del','Upload/delete');
});

})->middleware(app\middleware\AdminAuth::class);