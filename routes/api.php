<?php

Route::post('/auth/register', 'AuthController@register');
Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/forgotpassword', 'PasswordResetController@email');
Route::post('/auth/resetpassword/{token}', 'PasswordResetController@reset');

Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('auth/user', 'AuthController@user');
  Route::post('auth/logout', 'AuthController@logout');

  Route::group(['middleware' => ['role:admin']], function(){
  	Route::resource('/manager', 'IndexController');
  });
});
Route::group(['middleware' => 'jwt.refresh'], function(){
  Route::get('auth/refresh', 'AuthController@refresh');
});
