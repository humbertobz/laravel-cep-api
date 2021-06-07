<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

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

Route::apiResource('cep', CepController::class);
Route::get('cep/search/{logradouro}', 'App\Http\Controllers\CepController@search');
