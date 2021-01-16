<?php

Route::group(['namespace' => 'Admin','prefix' => env('admin')], function() {

Route::get('/','AdminController@index');
Route::get('login','AdminController@index');
Route::post('login','AdminController@login');

Route::group(['middleware' => 'admin'], function(){

/*
|-----------------------------------------
|Dashboard and Account Setting & Logout
|-----------------------------------------
*/
Route::get('home','AdminController@home');
Route::get('setting','AdminController@setting');
Route::post('setting','AdminController@update');
Route::get('logout','AdminController@logout');

/*
|------------------------------
|Manage Users
|------------------------------
*/
Route::resource('user','UserController');
Route::get('user/delete/{id}','UserController@delete');
Route::get('user/status/{id}','UserController@status');
Route::get('imageRemove/{id}','UserController@imageRemove');
Route::get('loginWithID/{id}','UserController@loginWithID');

// Ruta para clonar un registro
Route::post('user/clone', 'UserController@clone')->name('cloneUser');

/*
|------------------------------
|Manage Admin Account
|------------------------------
*/
Route::resource('adminUser','AdminUserController');
Route::get('adminUser/delete/{id}','AdminUserController@delete');

/*
|------------------------------
|Manage City
|------------------------------
*/
Route::resource('city','CityController');
Route::get('city/delete/{id}','CityController@delete');
Route::get('city/status/{id}','CityController@status');

/*
|------------------------------
|Manage Language
|------------------------------
*/
Route::resource('language','LanguageController');
Route::get('language/delete/{id}','LanguageController@delete');
Route::get('language/status/{id}','LanguageController@status');

/*
|------------------------------
|Manage App Pages
|------------------------------
*/
Route::resource('page','PageController');
Route::resource('text','TextController');

/*
|------------------------------
|Manage Welcome Slider
|------------------------------
*/
Route::resource('slider','SliderController');
Route::get('slider/delete/{id}','SliderController@delete');

/*
|------------------------------
|Manage Banner
|------------------------------
*/
Route::resource('banner','BannerController');
Route::get('banner/delete/{id}','BannerController@delete');
Route::get('banner/status/{id}','BannerController@status');



/*
|------------------------------
|Manage Offer
|------------------------------
*/
Route::resource('offer','OfferController');
Route::get('offer/delete/{id}','OfferController@delete');
Route::get('offer/status/{id}','OfferController@status');
Route::post('offer/assign','OfferController@assign');

/*
|------------------------------
|Delivery Staff
|------------------------------
*/
Route::get('delivery/all','DeliveryController@all');
Route::resource('delivery','DeliveryController');
Route::get('delivery/delete/{id}','DeliveryController@delete');
Route::get('delivery/status/{id}','DeliveryController@status');


/*
|-------------------------------
|Manage Orders
|-------------------------------
*/
Route::get('order/assing/delivery/{id}','OrderController@assingDelivery');
Route::post('order/assing/delivery/{id}','OrderController@assingDeliveryStore');
Route::get('order/assing','OrderController@assing');
Route::get('order','OrderController@index');
Route::get('orderStatus','OrderController@orderStatus');
Route::post('order/dispatched','OrderController@dispatched');
Route::get('order/print/{id}','OrderController@printBill');
Route::get('order/edit/{id}','OrderController@edit');
Route::post('order/edit/{id}','OrderController@_edit');
Route::get('orderItem','OrderController@orderItem');
Route::get('getUnit/{id}','OrderController@getUnit');
Route::get('order/add','OrderController@add');
Route::post('order/add','OrderController@_add');
Route::get('order/getAvailableOffers','OrderController@getAvailableOffers');
Route::get('getUser/{id}','OrderController@getUser');

Route::resource('category','CategoryController');
Route::get('category/delete/{id}','CategoryController@delete');
Route::get('category/status/{id}','CategoryController@status');

/*
|-------------------------------
|Send Push Notification
|-------------------------------
*/
Route::get('push','PushController@index');
Route::post('push','PushController@send');

/*
|-------------------------------
|Reporting
|-------------------------------
*/
Route::get('report','ReportController@index');
Route::post('report','ReportController@report');
Route::get('payment','ReportController@payment');
Route::get('paymentReport','ReportController@paymentReport');

/*
|-------------------------------
|App Users
|-------------------------------
*/
Route::get('appUser','AdminController@appUser');

});


});

?>
