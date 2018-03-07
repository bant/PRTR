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

Route::get('chemical', 'ChemicalController@index');

Route::get('chemical/search', 'ChemicalController@find');
Route::post('chemical/search', 'ChemicalController@search');

Route::get('factory/search', 'FactoryController@find');
Route::post('factory/search', 'FactoryController@search');

Route::get('company/search', 'CompanyController@find');
Route::post('company/search', 'CompanyController@search');

//Route::get('report/ListByFactory/{id?}', 'ReportController@ListByFactory');
/*
Route::get('report/ListByFactory/{id?}', function ($id) {
    dd($id);
    // {id}が数値の場合のみ呼び出される
});

*/

Route::get('report/ListByFactory/{id?}', 'ReportController@ListByFactory');
//Route::post('report/ListByFactory/{id?}', 'ReportController@ListByFactory');
