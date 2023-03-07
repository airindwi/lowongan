<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('pelamars', PelamarController::class);

Route::middleware(['CekRole:admin'])->group(function () {
Route::apiResource('lowongans', LowonganController::class);
});

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);
});


    Route::get('index', [PelamarController::class, 'index']);
    Route::post('store', [PelamarController::class, 'store']);
    Route::patch('update', [PelamarController::class, 'update']);
    Route::delete('destroy', [PelamarController::class, 'destroy']);