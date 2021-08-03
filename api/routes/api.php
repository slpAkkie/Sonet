<?php

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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::middleware(['token_auth'])->delete('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware(['token_auth'])->prefix('notes')->group(function () {
    Route::post('/', [\App\Http\Controllers\NoteController::class, 'store']);
    Route::put('/{note}', [\App\Http\Controllers\NoteController::class, 'update']);
    Route::get('/', [\App\Http\Controllers\NoteController::class, 'index']);
    Route::get('/shared', [\App\Http\Controllers\NoteController::class, 'index_shared']);
});
