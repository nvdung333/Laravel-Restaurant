<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'home'], function()
{
    Route::get('admin', 'App\Http\Controllers\HomeController@adminHome')
    ->middleware("checkrole:admin|smod")->name('adminHome');

    Route::get('mod', 'App\Http\Controllers\HomeController@modHome')
    ->middleware("checkrole:admin|smod|mod")->name('modHome');

    Route::get('user', 'App\Http\Controllers\HomeController@userHome');
});

// Backend
Route::get('/backend', "App\Http\Controllers\Backend\DashboardController@index")->middleware("auth")->middleware("checkrole:admin|smod|mod")->name('backendhome');
