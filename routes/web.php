<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Route::get("/",function(){
    return view('welcome');
    // return redirect("/login");
});
Route::get("admin/login","AdminController@login");

// Route::get("login",function(){
//     return redirect("/admin/login");
// });

Route::get('/admin', function () {
    return redirect("/admin/login");
});

Auth::routes();

Route::middleware('auth')->group(function(){

Route::get('admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
Route::get('admin/users', 'AdminController@users')->name('admin.users')->middleware('is_admin');
Route::get('admin/addUser', 'AdminController@addUser')->name('admin.addUser')->middleware('is_admin');
Route::get('admin/storeUser', 'AdminController@storeUser')->name('admin.storeUser')->middleware('is_admin');
Route::get('admin/matchs', 'AdminController@matches')->name('admin.matchs')->middleware('is_admin');
Route::get('admin/walletSend/{id}', 'AdminController@walletSend')->name('admin.walletSend')->middleware('is_admin');
Route::post('admin/walletStore/{id}', 'AdminController@walletStore')->name('admin.walletStore')->middleware('is_admin');



Route::get('/game', "RateController@index");
Route::post("storeRate","RateController@store")->name('rate.store');
Route::post("betStore","RateController@betStore")->name('bet.store');



// Route::get('/home', 'HomeController@index')->name('home');
});

Route::any('{slug}', function () {
    return view('welcome');
})->name('home');
Route::any('/{slug}/{name}', function () {
    return view('welcome');
});
Route::any('/{slug}/{slug1}/{name}', function () {
    return view('welcome');
});
Route::any('/{slug}/{slug1}/{slug2}/{name}', function () {
    return view('welcome');
});

