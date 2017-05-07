<?php


Route::group([], function () {
    // 会员后台
    $this->get('login', 'Auth\WechatAuthController@showLoginForm');
});
Route::group(array('domain' => config('administrator.domain'), 'prefix' => config('administrator.uri'), 'middleware' => ['web']), function () {
    // 会员后台
    //$this->get('user', 'Admin\AdminUserController@index');
    Route::resource('users', 'Admin\AdminUserController');
});
