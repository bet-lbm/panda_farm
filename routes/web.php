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
//---------------------Client-------------------------
Route::name('clients.list')->get('/clients/list',function(){
	return view('clients.index');
});
Route::get('/clients/search','ClientController@search');
Route::get('/clients/search/dni','ClientController@searchDNI');
Route::resource('clients','ClientController',['except' => ['edit', 'show']]); 

//----------------Dealers-----------------------------
Route::name('dealers.list')->get('/dealers/list', function () {
    return view('dealers.index');
});
Route::get('/dealers/search','DealerController@search');
Route::get('/dealers/combo','DealerController@combo');
Route::get('/dealers/get/{id}','DealerController@getDealer');
Route::resource('dealers','DealerController',['except' => ['edit', 'show']]); 

//---------------------Laboratory---------------------------------
Route::name('laboratories.list')->get('/laboratories/list',function(){
	return view('laboratories.index');
});
Route::get('/laboratories/search','LaboratoryController@search');
Route::get('/laboratories/combo','LaboratoryController@combo');
Route::get('/laboratories/get/{id}','LaboratoryController@getLaboratory');
Route::resource('laboratories','LaboratoryController',['except' => ['edit', 'show']]); 

//--------------------Presentation---------------------------------
Route::name('presentations.list')->get('/presentations/list',function(){
	return view('presentations.index');
});
Route::get('/presentations/combo','PresentationController@combo');
Route::get('/presentations/search','PresentationController@search');
Route::get('/presentations/get/{id}','PresentationController@getPresentation');
Route::resource('presentations','PresentationController',['except' => ['edit', 'show']]);

//-------------------------Medicine------------------------------------
Route::name('medicines.list')->get('/medicines/list', function () {
    return view('medicines.index');
});

Route::get('/medicines/search','MedicineController@search');
Route::get('/medicines/combo','MedicineController@combo');
Route::get('/medicines/get/{id}','MedicineController@getMedicine');
Route::resource('medicines','MedicineController',['except' => ['edit', 'show']]); 

//-------------------------Purchase------------------------------------
Route::name('purchases.list')->get('/purchases/list',function(){
	return view('purchases.index');
});
Route::name('purchases.report')->get('/purchases/report',function(){
	return view('purchases.report');
});
Route::get('/purchases/search','PurchaseController@search');
Route::get('/purchases/search_report','PurchaseController@report');
Route::name('purchases.create')->get('/purchases/create','PurchaseController@create');
Route::get('/purchases/code','PurchaseController@code');
Route::get('/purchases/show/{id}','PurchaseController@showDetails');
Route::post('/purchases','PurchaseController@store');
Route::get('/purchases','PurchaseController@index');

//--------------------PurchaseDetail---------------------------------
Route::post('/purchasedetails','PurchaseDetailController@store');
Route::put('/purchasedetails/stock','PurchaseDetailController@updateStock');

//-------------------------- Sale ------------------------------------
Route::name('sales.bill')->get('/sales/bill','SaleController@bill');
Route::name('sales.invoce')->get('/sales/invoce','SaleController@invoce');
Route::get('/sales/code/invoce','SaleController@numberInvoce');
Route::get('/sales/code/bill','SaleController@numberBill');
//--------------------------SaleDetail---------------------------------