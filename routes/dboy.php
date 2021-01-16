<?php

Route::post('dboy/login','DboyController@login');
Route::get('dboy/logout','DboyController@logout');
Route::post('dboy/forgot','DboyController@forgot');
Route::get('dboy/homepage','DboyController@homepage');
Route::get('dboy/startRide','DboyController@startRide');
Route::get('dboy/userInfo/{id}','DboyController@userInfo');
Route::post('dboy/updateInfo','DboyController@updateInfo');
Route::get('dboy/lang','ApiController@lang');
Route::post('dboy/updateLocation','DboyController@updateLocation');
Route::get('dboy/configuration','ApiController@configuration');
Route::get('dboy/pages','ApiController@pages');

?>
