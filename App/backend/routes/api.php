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
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::middleware(['api-token'])->delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Routes with authorization
Route::middleware(['api-token'])->group(function () {

    // Note routes
    Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index']);
    Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show']);

});



// Test route
Route::get('/test', [\App\Http\Controllers\Controller::class, 'test'])->name('test');
