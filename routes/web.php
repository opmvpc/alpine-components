<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ComponentController@index')->name('components.index');
Route::get('/components/{slug}', 'ComponentController@show')->name('components.show');
Route::get('/components/{id}/edit', 'ComponentController@edit')->name('components.edit');

Route::get('/categories', 'CategoryController@index')->name('categories.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
