<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get-user/{user}', [ApiController::class, 'getUser']);
Route::get('/get-cekin-cekout/{user}', [ApiController::class, 'getCekinCekout']);

Route::post('/login', [ApiController::class, 'login']);
Route::post('/cekin', [ApiController::class, 'cekin']);
Route::post('/cekout', [ApiController::class, 'cekout']);
