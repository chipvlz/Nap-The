<?php

/**
 * -----------------------------Backend-----------------------------
 */

Route::get('/',[
    'as' => 'auth.login',
    'uses' => 'Backend\AuthController@login'
]);
Route::get('/dang-xuat',[
    'as' => 'auth.logout',
    'uses' => 'Backend\AuthController@logout'
]);
Route::post('/',[
    'as' => 'auth.post-login',
    'uses' => 'Backend\AuthController@processLogin'
]);

/**
 * --------------------------- system---------------------------------
 */

Route::get('/bao-cao',[
    'as' => 'home.add',
    'uses' => 'Backend\HomeController@index'
]);

Route::get('/nhap-so-dien-thoai',[
    'as' => 'phone.add',
    'uses' => 'Backend\PhoneController@index'
]);
Route::get('/so-dien-thoai',[
    'as' => 'phone.index',
    'uses' => 'Backend\PhoneController@listPhone'
]);
Route::post('/so-dien-thoai',[
    'as' => 'phone.post-index',
    'uses' => 'Backend\PhoneController@processListPhone'
]);

Route::post('/upload-file',[
    'as' => 'phone.upload',
    'uses' => 'Backend\PhoneController@processUploadFile'
]);
Route::post('/nhap-sim',[
    'as' => 'phone.sim',
    'uses' => 'Backend\PhoneController@processEnterPhone'
]);
