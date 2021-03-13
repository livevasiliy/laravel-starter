<?php

/*
|--------------------------------------------------------------------------
| Service - API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for this service.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Prefix: /api/authentication
use Illuminate\Support\Facades\Route;
use App\Services\Authentication\Http\Controllers\AuthenticationController;

Route::group(['prefix' => 'authentication'], function() {
    // Controllers live in src/Services/Authentication/Http/Controllers
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login',[AuthenticationController::class, 'login']);
    Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/recovery', [AuthenticationController::class, 'recovery']);
    Route::post('/reset', [AuthenticationController::class, 'reset']);
});
