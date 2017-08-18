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

//----------------Deleaders-----------------------------
Route::get('/list_dealers', function () {
    return view('dealers.index');
});
Route::resource('dealers','DealerController'); 

//---------------------Clientes-------------------------
Route::get('/list_clients',function(){
	return view('clients.index');
});
Route::get('/clients/create','ClientController@create');
Route::post('/clients','ClientController@store');
Route::put('/clients/{id}','ClientController@update');
Route::delete('/clients/{id}','ClientController@delete'); 
Route::get('/clients','ClientController@index');

//---------------------Laboratorio---------------------------------
Route::get('/list_laboratories',function(){
	return view('laboratories.index');
});
Route::get('/laboratories/create','LaboratoryController@create');
Route::post('/laboratories','LaboratoryController@store');
Route::put('/laboratories/{id}','LaboratoryController@update');
Route::delete('/laboratories/{id}','LaboratoryController@delete');
Route::get('/laboratories','LaboratoryController@index');

//--------------------Presentacion---------------------------------
Route::get('/list_presentations',function(){
	return view('presentations.index');
});
Route::get('/presentations/create','PresentationController@create');
Route::post('/presentations','PresentationController@store');
Route::put('/presentations/{id}','PresentationController@update');
Route::delete('/presentations/{id}','PresentationController@delete');
Route::get('/presentations','PresentationController@index');

//-------------------------Medicine------------------------------------
Route::get('/list_medicines', function () {
    return view('medicines.index');
});
Route::resource('medicines','MedicineController'); 