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

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
//---------------------Client-------------------------
Route::name('clients.list')->get('/clients/list','ClientController@getIndex');
Route::get('/clients/search','ClientController@search');
Route::get('/clients/search/dni','ClientController@searchDNI');
Route::get('/clients/get/{dni}','ClientController@getClient');
Route::resource('clients','ClientController',['except' => ['edit']]); 

//----------------Dealers-----------------------------
Route::name('dealers.list')->get('/dealers/list','DealerController@getIndex');
Route::get('/dealers/search','DealerController@search');
Route::get('/dealers/combo','DealerController@combo');
Route::get('/dealers/get/{id}','DealerController@getDealer');
Route::resource('dealers','DealerController',['except' => ['edit', 'show']]); 

//---------------------Laboratory---------------------------------
Route::name('laboratories.list')->get('/laboratories/list','LaboratoryController@getIndex');
Route::get('/laboratories/search','LaboratoryController@search');
Route::get('/laboratories/combo','LaboratoryController@combo');
Route::get('/laboratories/get/{id}','LaboratoryController@getLaboratory');
Route::resource('laboratories','LaboratoryController',['except' => ['edit', 'show']]); 

//--------------------Presentation---------------------------------
Route::name('presentations.list')->get('/presentations/list','PresentationController@getIndex');
Route::get('/presentations/combo','PresentationController@combo');
Route::get('/presentations/search','PresentationController@search');
Route::get('/presentations/get/{id}','PresentationController@getPresentation');
Route::resource('presentations','PresentationController',['except' => ['edit', 'show']]);

//-------------------------Medicine------------------------------------
Route::name('medicines.list')->get('/medicines/list','MedicineController@getIndex');
Route::get('/medicines/search','MedicineController@search');
Route::get('/medicines/combo','MedicineController@combo');
Route::get('/medicines/get/{id}','MedicineController@getMedicine');
Route::get('/medicines/saleprice/{id}','MedicineController@getMedicinePrice');
Route::resource('medicines','MedicineController',['except' => ['edit', 'show']]); 

//-------------------------Purchase------------------------------------
Route::name('purchases.list')->get('/purchases/list','PurchaseController@getIndex');
Route::name('purchases.report')->get('/purchases/report','PurchaseController@getReport');
Route::get('/purchases/search','PurchaseController@search');
Route::get('/purchases/search_report','PurchaseController@report');
Route::get('/purchases/code','PurchaseController@code');
Route::get('/purchases/show/{id}','PurchaseController@showDetails');

Route::name('purchases.create')->get('/purchases/create','PurchaseController@create');
Route::post('/purchases','PurchaseController@store');
Route::get('/purchases','PurchaseController@index');

//--------------------PurchaseDetail---------------------------------
Route::post('/purchasedetails','PurchaseDetailController@store');
Route::put('/purchasedetails/stock','PurchaseDetailController@updateStock');

//-------------------------- Sale ------------------------------------
Route::name('sales.list')->get('/sales/list','SaleController@getIndex');
Route::name('sales.report')->get('/sales/report','SaleController@getReport');
Route::get('/sales/search_report','SaleController@report');

Route::name('sales.bill')->get('/sales/bill','SaleController@bill');
Route::name('sales.invoce')->get('/sales/invoce','SaleController@invoce');
Route::name('sales.cancel')->get('/sales/cancel','SaleController@getCancel');

Route::get('/sales/search','SaleController@search');
Route::get('/sales/code/invoce','SaleController@numberInvoce');
Route::get('/sales/code/bill','SaleController@numberBill');
Route::get('/sales/show/{series}/{number}','SaleController@showDetails');
Route::put('/sales/edit/{series}/{number}','SaleController@cancelSale');

Route::post('/sales','SaleController@store');
Route::get('/sales','SaleController@index');
Route::get('/sales/{series}/{number}','SaleController@show');
//--------------------------SaleDetail---------------------------------
Route::post('/saledetails','SaleDetailController@store');
Route::put('/saledetails/stock','SaleDetailController@updateStock');
//----------------------- USER  -------
Route::get('/getuser','UserAuthController@getUserAuth');
Route::get('/getuser/{id}','UserAuthController@getSaleUser');
Route::get('/roles','RoleController@index');