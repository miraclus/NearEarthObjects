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

Route::get('/', [\App\Http\Controllers\MainController::class, 'index']);

Route::prefix('neo')->group(function (){
    Route::get('/hazardous', [\App\Http\Controllers\NearEarthObjectController::class, 'getHazardous']);
    Route::get('/fastest', [\App\Http\Controllers\NearEarthObjectController::class, 'getFastest']);
});

