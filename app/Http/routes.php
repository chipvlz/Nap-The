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
    'as' => 'home.index',
    'uses' => 'Backend\HomeController@index'
]);