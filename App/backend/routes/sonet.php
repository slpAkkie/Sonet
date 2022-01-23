<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\AccessLevelController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
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
        Route::delete('/', [UserController::class, 'destroy']);
    });
    Route::get('/users', [UserController::class, 'indexForContributors']);

    /** Notes --------------------------------- */
    Route::get('/notes/shared', [NoteController::class, 'indexShared']);
    Route::apiResource('/notes', NoteController::class);
    Route::post('/notes/{note}/attachments', [AttachmentController::class, 'store']);
    Route::get('/notes/{note}/contributors', [NoteController::class, 'indexContributors']);
    Route::put('/notes/{note}/contributors', [NoteController::class, 'addContributor']);
    Route::delete('/notes/{note}/contributors/{user_id}', [NoteController::class, 'destroyContributor']);

    /** Notes comments ------------------------ */
    Route::post('/notes/{note}/comments', [CommentController::class, 'addComment']);
    Route::get('/notes/{note}/comments', [CommentController::class, 'indexComments']);
    Route::delete('/notes/{note}/comments/{comment}', [CommentController::class, 'destroyComment']);

    /** Attachments --------------------------- */
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']);

    /** Folders ------------------------------- */
    Route::apiResource('/folders', FolderController::class);

    /** Categories ---------------------------- */
    Route::apiResource('/categories', CategoryController::class);

    /** Access Levels ------------------------- */
    Route::get('/access_levels', [AccessLevelController::class, 'index']);

});
