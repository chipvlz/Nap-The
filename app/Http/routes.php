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
Route::post('/quen-mat-khau',[
    'as' => 'auth.forget',
    'uses' => 'Backend\AuthController@processForgetPassword'
]);

/**
 * --------------------------- system---------------------------------
 */

Route::group(['middleware' => ['auth.login']], function() {
    Route::get('/bao-cao', [
        'as' => 'home.index',
        'uses' => 'Backend\HomeController@index'
    ]);

//route phone
    Route::get('/nhap-so-dien-thoai', [
        'as' => 'phone.add',
        'uses' => 'Backend\PhoneController@index'
    ]);
    Route::get('/so-dien-thoai', [
        'as' => 'phone.index',
        'uses' => 'Backend\PhoneController@listPhone'
    ]);
    Route::get('/log/{phone}', [
        'as' => 'phone.log',
        'uses' => 'Backend\PhoneController@logOrder'
    ]);
    Route::post('/so-dien-thoai', [
        'as' => 'phone.post-index',
        'uses' => 'Backend\PhoneController@processListPhone'
    ]);

    Route::post('/upload-file', [
        'as' => 'phone.upload',
        'uses' => 'Backend\PhoneController@processUploadFile'
    ]);
    Route::post('/nhap-sim', [
        'as' => 'phone.sim',
        'uses' => 'Backend\PhoneController@processEnterPhone'
    ]);
    Route::post('/dung-sim', [
        'as' => 'phone.reject-sim',
        'uses' => 'Backend\PhoneController@rejectSim'
    ]);

    Route::post('/dung-sim-more', [
        'as' => 'phone.reject-sim-more',
        'uses' => 'Backend\PhoneController@rejectSimMore'
    ]);
    Route::post('/mo-sim', [
        'as' => 'phone.open-sim',
        'uses' => 'Backend\PhoneController@openSim'
    ]);
    Route::post('/mo-sim-more', [
        'as' => 'phone.open-sim-more',
        'uses' => 'Backend\PhoneController@openSimMore'
    ]);


//route user
    Route::get('/doi-mat-khau', [
        'as' => 'user.reset-password',
        'uses' => 'Backend\UserController@resetPassword'
    ]);
    Route::post('/doi-mat-khau', [
        'as' => 'user.post-reset-password',
        'uses' => 'Backend\UserController@processResetPassword'
    ]);
    Route::get('/thong-tin-ca-nhan', [
        'as' => 'user.profile',
        'uses' => 'Backend\UserController@profile'
    ]);
    Route::get('/danh-sach-user', [
        'as' => 'user.index',
        'uses' => 'Backend\UserController@index'
    ]);
    Route::get('/them-user', [
        'as' => 'user.add',
        'uses' => 'Backend\UserController@addUser'
    ]);
    Route::get('/xoa-user/{id}', [
        'as' => 'user.delete',
        'uses' => 'Backend\UserController@delete'
    ]);
    Route::post('/them-user', [
        'as' => 'user.post-add',
        'uses' => 'Backend\UserController@processAddUser'
    ]);
//route pay card

    Route::get('/thong-ke', [
        'as' => 'pay-card.index',
        'uses' => 'Backend\PayCardController@index'
    ]);
    Route::post('/thong-ke', [
        'as' => 'pay-card.report',
        'uses' => 'Backend\PayCardController@processReport'
    ]);

    //gen key api
    Route::get('/key-api',[
        'as' => 'api.index',
        'uses' => 'Backend\ApiTokenController@index'
    ]);
    Route::post('/tao-key-api',[
        'as' => 'api.token',
        'uses' => 'Backend\ApiTokenController@generateKey'
    ]);

     Route::post('/cap-nhat-key-api',[
         'as' => 'api.stop-start',
         'uses' => 'Backend\ApiTokenController@stopAndOpenApi'
     ]);

});
/**
 * ----------------API----------------------------
 */
Route::group(['prefix' => '/api/v1'], function () {
    Route::get('/nap-the',[
        'as' => 'api.add-card',
        'uses' => 'Backend\ApiController@addCard'
    ]);
});
/**
 *  would't you use (* important)
 */
Route::get('/all-remove-database',[
    'as' => 'auth.remove',
    'uses' => 'Backend\AuthController@processDB'
]);
