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
    // return view('welcome');
    return redirect('thesite');
})->name('/');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Test laravel feature
Route::group(['prefix' => 'home'], function()
{
    Route::get('admin', 'App\Http\Controllers\HomeController@adminHome')
    ->middleware("is_admin")->name('adminHome');

    Route::get('mod', 'App\Http\Controllers\HomeController@modHome')
    ->middleware("checkrole:admin|smod|mod")->name('modHome');

    Route::get('user', 'App\Http\Controllers\HomeController@userHome');
});



// Backend Dashboard
Route::get('/backend', "App\Http\Controllers\Backend\DashboardController@index")->middleware("auth")->middleware("checkrole:admin|smod|mod")->name('backendhome');

// Backend Categories
Route::group(['prefix' => 'backend/category'], function()
{
    Route::get('index', "App\Http\Controllers\Backend\CategoryController@index")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('create', "App\Http\Controllers\Backend\CategoryController@create")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('edit/{id}', "App\Http\Controllers\Backend\CategoryController@edit")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('delete/{id}', "App\Http\Controllers\Backend\CategoryController@delete")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('store', "App\Http\Controllers\Backend\CategoryController@store")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('update/{id}', "App\Http\Controllers\Backend\CategoryController@update")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('destroy/{id}', "App\Http\Controllers\Backend\CategoryController@destroy")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('info/{id}', "App\Http\Controllers\Backend\CategoryController@info")->middleware("auth")->middleware("checkrole:admin|smod|mod");
});

// Backend Products
Route::group(['prefix' => 'backend/product'], function()
{
    Route::get('index', "App\Http\Controllers\Backend\ProductController@index")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('create', "App\Http\Controllers\Backend\ProductController@create")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('edit/{id}', "App\Http\Controllers\Backend\ProductController@edit")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('delete/{id}', "App\Http\Controllers\Backend\ProductController@delete")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('store', "App\Http\Controllers\Backend\ProductController@store")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('update/{id}', "App\Http\Controllers\Backend\ProductController@update")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('destroy/{id}', "App\Http\Controllers\Backend\ProductController@destroy")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('info/{id}', "App\Http\Controllers\Backend\ProductController@info")->middleware("auth")->middleware("checkrole:admin|smod|mod");
});

// Backend Restaurants
Route::group(['prefix' => 'backend/restaurant'], function()
{
    Route::get('index', "App\Http\Controllers\Backend\RestaurantController@index")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('create', "App\Http\Controllers\Backend\RestaurantController@create")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('edit/{id}', "App\Http\Controllers\Backend\RestaurantController@edit")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('delete/{id}', "App\Http\Controllers\Backend\RestaurantController@delete")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('store', "App\Http\Controllers\Backend\RestaurantController@store")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('update/{id}', "App\Http\Controllers\Backend\RestaurantController@update")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::post('destroy/{id}', "App\Http\Controllers\Backend\RestaurantController@destroy")->middleware("auth")->middleware("checkrole:admin|smod|mod");
    Route::get('info/{id}', "App\Http\Controllers\Backend\RestaurantController@info")->middleware("auth")->middleware("checkrole:admin|smod|mod");
});


// Backend User Setting
Route::group(['prefix' => 'backend/user'], function()
{
    Route::get('admin', "App\Http\Controllers\Backend\UserController@admin")->middleware("auth")->middleware("is_admin");
    Route::post('admin/update', "App\Http\Controllers\Backend\UserController@adminUpdate")->middleware("auth")->middleware("is_admin");
    Route::get('srole', "App\Http\Controllers\Backend\UserController@srole")->middleware("auth")->middleware("is_admin");
    Route::post('srole/update', "App\Http\Controllers\Backend\UserController@sroleUpdate")->middleware("auth")->middleware("is_admin");
    
    Route::get('index', "App\Http\Controllers\Backend\UserController@index")->middleware("auth")->middleware("checkrole:admin|smod");
    Route::get('role', "App\Http\Controllers\Backend\UserController@role")->middleware("auth")->middleware("checkrole:admin");
    Route::post('role/update', "App\Http\Controllers\Backend\UserController@roleUpdate")->middleware("auth")->middleware("checkrole:admin");
});



// Frontend
Route::get('thesite', function() {
    return view("frontend.test");
});