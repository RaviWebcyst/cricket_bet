<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register','UserController@register');
Route::post('login','UserController@login');
Route::get('users','UserController@getAuthenticatedUser');
Route::post("betStore","RateController@betStore");

Route::get('/game', "RateController@game");
Route::get('/matchs', "RateController@match");
Route::get('/getTeam', "RateController@getTeam");
Route::get('/session', "RateController@session");
Route::post('/storeSession', "RateController@storeSession");


Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});
