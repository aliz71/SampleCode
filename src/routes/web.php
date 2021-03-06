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

Route::get('/', 'IndexController@index');
Route::resource('books', 'BookController')->only([
    'store', 'destroy', 'update', 'index'
]);
Route::get('books/csv-export', 'BookController@cvsExport');
Route::get('books/xml-export', 'BookController@xmlExport');
