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
    return view('index');
});

// 事業所(工場)検索
Route::get('factory/search', 'FactoryController@search');
Route::get('factory/list', 'FactoryController@list');
Route::post('factory/list', 'FactoryController@list');
Route::get('factory/report/{id}', 'FactoryController@report');    // 以前の report/ListByFactory

// 事業者(会社)検索
Route::get('company/search', 'CompanyController@search');
Route::get('company/list', 'CompanyController@list');
Route::post('company/list', 'CompanyController@list');
Route::get('company/factories/{id}', 'CompanyController@factories');
Route::get('company/report/{id}', 'CompanyController@report');

Route::get('chemical/search', 'ChemicalController@search');
Route::get('chemical/list', 'ChemicalController@list');
Route::post('chemical/list', 'ChemicalController@list');
Route::get('chemical/factories/{id}/{select_year?}', 'ChemicalController@factories');
Route::get('chemical/prefectures/{id}/{select_year?}', 'ChemicalController@prefectures');

Route::get('discharge/search', 'DischargeController@search');
Route::get('discharge/compare', 'DischargeController@compare');
Route::post('discharge/compare', 'DischargeController@compare');

