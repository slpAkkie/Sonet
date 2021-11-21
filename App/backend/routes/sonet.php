<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sonet API Routes
|--------------------------------------------------------------------------
*/

/** Auth -------------------------------------- */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/** Authorization require --------------------- */
Route::middleware('auth.token')->group(function () {

    /** User ---------------------------------- */
    Route::prefix('/user')->group(function () {
        Route::get('/verify', [AuthController::class, 'verify']);
        Route::get('/identify', [AuthController::class, 'identify']);
        Route::delete('/logout', [AuthController::class, 'logout']);
    });

    /** Notes --------------------------------- */
    Route::apiResource('/notes', NoteController::class);

    /** Folders ------------------------------- */
    Route::apiResource('/folders', FolderController::class);

    /** Categories ---------------------------- */
    Route::apiResource('/categories', CategoryController::class);

});
