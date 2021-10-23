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

// Auth routes
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware(['api-token'])->delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::middleware(['api-token'])->get('/user', [\App\Http\Controllers\AuthController::class, 'getUserByToken']);

// Routes with authorization
Route::middleware(['api-token'])->group(function () {

    // User routes
    Route::options('/user', [\App\Http\Controllers\AuthController::class, 'checkToken']);

    // Note routes
    Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index']);
    Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show']);
    Route::post('/notes', [\App\Http\Controllers\NoteController::class, 'store']);
    Route::delete('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'destroy']);

});



// Test route
Route::get('/test', [\App\Http\Controllers\Controller::class, 'test']);
