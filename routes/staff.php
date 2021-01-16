<?php

Route::group(['namespace' => 'Staff','prefix' => env('staff')], function(){

    Route::get('/','AdminController@index');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('home','AdminController@home');
    Route::get('logout','AdminController@logout');
    Route::get('deliverOrder/{id}','AdminController@deliver');


});
?>
