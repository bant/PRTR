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
