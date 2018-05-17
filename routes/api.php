<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' =>'v1', 'middleware' => 'cors'], function(){
    Route::resource('hidangan', 'HidanganController',[
        'except' => ['create','edit']
    ]);

    Route::resource('pesanan', 'PesananController',[
        'except' => ['create','edit']
    ]);

    // Route::resource('hidangan/pesanan', 'PesananController',[
    //     'only' => ['store','destroy']
    // ]);

    Route::post('/user/register', [
        'uses' => 'AuthController@store'
    ]);

    Route::post('/user/signin',[
        'uses' => 'AuthController@signin'
    ]);
    Route::get('/users',[
        'uses' => 'AuthController@index'
    ]);

    Route::get('/antrian',[
        'uses' => 'AntrianController@index'
    ]);
});

