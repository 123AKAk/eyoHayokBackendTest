<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::group(['prefix' => 'patients'], function () {
//     Route::get('/', [PatientsController::class, 'index']);
//     Route::post('/store', [PatientsController::class, 'store']);
//     Route::get('/search', [PatientsController::class, 'search']);
//     Route::post('/getByDateRange', [PatientsController::class, 'getByDateRange']);
// });


Route::middleware('handle.unauthenticated')->group(function () {
    Route::group(['prefix' => 'patients'], function () {
        Route::get('/', [PatientsController::class, 'index']);
        Route::post('/store', [PatientsController::class, 'store'])->middleware('auth:sanctum');
        Route::get('/search', [PatientsController::class, 'search']);
        Route::post('/getByDateRange', [PatientsController::class, 'getByDateRange']);
    });
});


// Route::apiResource('patients', PatientsController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');