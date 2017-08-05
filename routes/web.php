<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/list_dealers', function () {
    return view('dealers.index');
});
Route::get('/dealer/create', 'DealerController@create' );
Route::post('/dealers', 'DealerController@store' );
Route::patch('/dealer/{id}', 'DealerController@update');
Route::delete('/dealer/{id}', 'DealerController@delete' );


Route::get('/dealers', 'DealerController@index' );