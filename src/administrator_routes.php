<?php

/**
 * Temperary solution for middleware in routes
 * TODO: remove in favor of setting the config for middleware outside of the routes file
 */
$middleware_array = array();
//$middleware_array = array('web');
if (is_array(config('administrator.middleware'))) {
    $middleware_array = array_merge(config('administrator.middleware'), $middleware_array);
}

Route::group(array('domain' => config('administrator.domain'), 'prefix' => config('administrator.uri'), 'middleware' => ['web']), function () {
    Route::get('login', '\Vancels\Administrator\Auth\AuthController@showLoginForm')->name(config('administrator.uri') . '.login');
    Route::post('login', '\Vancels\Administrator\Auth\AuthController@login');
    Route::get('logout', '\Vancels\Administrator\Auth\AuthController@logout')->name(config('administrator.uri') . 'logout');
});

/**
 * Routes
 */
Route::group(array('domain' => config('administrator.domain'), 'prefix' => config('administrator.uri'), 'middleware' => $middleware_array), function () {
    Route::get('/', array(
        'as'   => 'admin_dashboard',
        'uses' => 'Vancels\Administrator\AdminController@dashboard',
    ));
});
