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

/** ==================================================
 * Separate Sonet API from others ----------------- */

Route::prefix('sonet')->group(function () {

    /** Auth --------------- */
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::middleware(['api-token'])->delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::middleware(['api-token'])->get('/user', [\App\Http\Controllers\AuthController::class, 'getAuthenticatedUser']);

    /** Authorization require --------------- */
    Route::middleware(['api-token'])->group(function () {

        /** User --------------- */
        Route::options('/user', [\App\Http\Controllers\AuthController::class, 'checkToken']);

        /** Notes --------------- */
        Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index']);
        Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show']);
        Route::post('/notes', [\App\Http\Controllers\NoteController::class, 'store']);
        Route::delete('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'destroy']);

        /** Folders --------------- */
        Route::get('/folders', [\App\Http\Controllers\FolderController::class, 'index']);
        Route::post('/folders', [\App\Http\Controllers\FolderController::class, 'store']);
        Route::delete('/folders/{folder}', [\App\Http\Controllers\FolderController::class, 'destroy']);

        /** Categories --------------- */
        Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
        Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store']);
        Route::delete('/categories/{category}', [\App\Http\Controllers\FolderController::class, 'destroy']);

    });



    /** Test --------------- */
    Route::get('/test', [\App\Http\Controllers\Controller::class, 'test']);

});
