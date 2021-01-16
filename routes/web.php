<?php
include("staff.php");
include("admin.php");
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'User','prefix' => env('user')], function() {

    Route::get('/','AdminController@index');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');

    Route::group(['middleware' => 'auth'], function() {

        /*
        |-----------------------------------------
        |Dashboard and Account Setting & Logout
        |-----------------------------------------
        */
        Route::get('home','AdminController@home');
        Route::get('setting','AdminController@setting');
        Route::post('setting','AdminController@update');
        Route::get('logout','AdminController@logout');
        Route::get('close','AdminController@close');

        /*
        |--------------------------------------
        |Menu Category
        |--------------------------------------
        */
        Route::resource('category','CategoryController');
        Route::get('category/delete/{id}','CategoryController@delete');
        Route::get('category/status/{id}','CategoryController@status');

        /*
        |--------------------------------------
        |Item Type
        |--------------------------------------
        */
        Route::resource('type','TypeController');
        Route::get('type/delete/{id}','TypeController@delete');

        /*
        |--------------------------------------
        |Manage Addon
        |--------------------------------------
        */
        Route::resource('addon','AddonController');
        Route::get('addon/delete/{id}','AddonController@delete');

        /*
        |--------------------------------------
        |Menu Items
        |--------------------------------------
        */
        Route::resource('item','ItemController');
        Route::get('item/delete/{id}','ItemController@delete');
        Route::get('item/status/{id}','ItemController@status');
        Route::post('itemAddon','ItemController@addon');
        Route::get('export','ItemController@export');
        Route::get('import','ItemController@import');
        Route::post('import','ItemController@_import');

        /*
        |------------------------------
        |Manage Offer
        |------------------------------
        */
        Route::resource('offer','OfferController');
        Route::get('offer/delete/{id}','OfferController@delete');
        Route::get('offer/status/{id}','OfferController@status');

        /*
        |------------------------------
        |Delivery Staff
        |------------------------------
        */
        Route::resource('delivery','DeliveryController');
        Route::get('delivery/delete/{id}','DeliveryController@delete');
        Route::get('delivery/status/{id}','DeliveryController@status');

        /*
        |-------------------------------
        |Manage Orders
        |-------------------------------
        */
        Route::get('order','OrderController@index');
        Route::get('orderStatus','OrderController@orderStatus');
        Route::get('order/print/{id}','OrderController@printBill');
        Route::post('order/dispatched','OrderController@dispatched');
        Route::get('order/edit/{id}','OrderController@edit');
        Route::post('order/edit/{id}','OrderController@_edit');
        Route::get('orderItem','OrderController@orderItem');
        Route::get('getUnit/{id}','OrderController@getUnit');
        Route::get('order/add','OrderController@add');
        Route::post('order/add','OrderController@_add');
        Route::get('getUser/{id}','OrderController@getUser');

    });
});
