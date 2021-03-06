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

Route::get('/','ObjetsController@index');
Route::post('/','ObjetsController@store');
Route::get('/create','ObjetsController@create');
Route::get('/take/{id}','ObjetsController@take');
Route::get('/delete/{id}','ObjetsController@delete');
Route::get('/panel','ObjetsController@viewPanel');
Route::get('/cat/{id}','ObjetsController@viewCat');
Auth::routes();
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();





Route::get('/home', 'HomeController@index')->name('home');
