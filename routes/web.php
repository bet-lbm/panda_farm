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
Route::get('/dealers/list', function () {
    return view('dealers.index');
});

Route::get('/dealers/search','DealerController@search');
Route::get('/dealers/combo','DealerController@combo');
Route::resource('dealers','DealerController'); 


//---------------------Clientes-------------------------
Route::get('/clients/list',function(){
	return view('clients.index');
});
Route::get('/clients/search','ClientController@search');
Route::get('/clients/create','ClientController@create');
Route::post('/clients','ClientController@store');
Route::put('/clients/{id}','ClientController@update');
Route::delete('/clients/{id}','ClientController@delete'); 
Route::get('/clients','ClientController@index');

//---------------------Laboratorio---------------------------------
Route::get('/laboratories/list',function(){
	return view('laboratories.index');
});
Route::get('/laboratories/search','LaboratoryController@search');
Route::get('/laboratories/create','LaboratoryController@create');
Route::post('/laboratories','LaboratoryController@store');
Route::put('/laboratories/{id}','LaboratoryController@update');
Route::delete('/laboratories/{id}','LaboratoryController@delete');
Route::get('/laboratories','LaboratoryController@index');
Route::get('/laboratories/combo','LaboratoryController@combo');

//--------------------Presentacion---------------------------------
Route::get('/presentations/list',function(){
	return view('presentations.index');
});
Route::get('/presentations/search','PresentationController@search');
Route::get('/presentations/create','PresentationController@create');
Route::post('/presentations','PresentationController@store');
Route::put('/presentations/{id}','PresentationController@update');
Route::delete('/presentations/{id}','PresentationController@delete');
Route::get('/presentations','PresentationController@index');
Route::get('/presentations/combo','PresentationController@combo');

//-------------------------Medicine------------------------------------
Route::get('/medicines/list', function () {
    return view('medicines.index');
});

Route::get('/medicines/search','MedicineController@search');
Route::get('/medicines/combo','MedicineController@combo');
Route::resource('medicines','MedicineController'); 

//--------------------PurchaseDetail---------------------------------
Route::post('/purchasedetails','PurchaseDetailController@store');
Route::get('/purchasedetails/{id}','PurchaseDetailController@updateStock');

Route::get('/purchasedetails','PurchaseDetailController@find');


//-------------------------Purchase------------------------------------
Route::get('/purchases/list',function(){
	return view('purchases.index');
});
Route::get('/purchases/code','PurchaseController@code');
Route::get('/purchases/create','PurchaseController@create');
Route::post('/purchases','PurchaseController@store');
Route::get('/purchases','PurchaseController@index');
Route::get('/purchases/{id}','PurchaseController@showDetails');


