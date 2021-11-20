<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sonet API Routes
|--------------------------------------------------------------------------
*/

/** Auth --------------- */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('api-token')->delete('/logout', [AuthController::class, 'logout']);
Route::middleware('api-token')->get('/user', [AuthController::class, 'getAuthenticatedUser']);

/** Authorization require --------------- */
Route::middleware('api-token')->group(function () {

    /** User --------------- */
    Route::options('/user', [AuthController::class, 'checkToken']);

    /** Notes --------------- */
    Route::get('/notes', [NoteController::class, 'index']);
    Route::get('/notes/{note}', [NoteController::class, 'show']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']);

    /** Folders --------------- */
    Route::get('/folders', [FolderController::class, 'index']);
    Route::post('/folders', [FolderController::class, 'store']);
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy']);

    /** Categories --------------- */
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{category}', [FolderController::class, 'destroy']);

});



/** Test --------------- */
Route::get('/test', [Controller::class, 'test']);
