<?php

use App\Modules\Sonet\Controllers\CommentController;
use App\Modules\Sonet\Controllers\AccessLevelController;
use App\Modules\Sonet\Controllers\AttachmentController;
use App\Modules\Sonet\Controllers\AuthController;
use App\Modules\Sonet\Controllers\CategoryController;
use App\Modules\Sonet\Controllers\FolderController;
use App\Modules\Sonet\Controllers\NoteController;
use App\Modules\Sonet\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Sonet API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('sonet')->middleware('api')->group(function() {

    /** Auth -------------------------------------- */
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    /** Authorization require --------------------- */
    Route::middleware('auth.token')->group(function () {

        /** User ---------------------------------- */
        Route::prefix('/user')->group(function () {
            Route::get('/verify', [AuthController::class, 'verify']);
            Route::get('/identify', [AuthController::class, 'identify']);
            Route::get('/auth-logs', [AuthController::class, 'authLog']);
            Route::delete('/auth-logs/{userToken}', [AuthController::class, 'removeAuthRecord']);
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
        Route::delete('/comments/{comment}', [CommentController::class, 'destroyComment']);

        /** Attachments --------------------------- */
        Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy']);

        /** Folders ------------------------------- */
        Route::apiResource('/folders', FolderController::class);

        /** Categories ---------------------------- */
        Route::apiResource('/categories', CategoryController::class);

        /** Access Levels ------------------------- */
        Route::get('/access_levels', [AccessLevelController::class, 'index']);

    });

});
