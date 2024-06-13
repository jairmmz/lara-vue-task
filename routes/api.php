<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Backend
|--------------------------------------------------------------------------*/


// --- Route for register and login - /api/auth
Route::controller(AuthController::class)->prefix('/auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/check-email/{token}', 'checkEmail')->name('check_email');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->prefix('/auth')->group(function () {
        Route::post('/logout', 'logout');
    });

    // --- Route for projects - /api/project
    Route::controller(ProjectController::class)->prefix('/project')->group(function () {
        Route::get('/', 'index');
        Route::post('/save', 'store');
        Route::put('/update/{project}', 'update');
        Route::post('/pinned', 'pinnedProject');
        Route::get('/get-project/{slug}', 'getProject');
        Route::get('/count-projects', 'countProject');
    });

    // --- Route for members - /api/member
    Route::controller(MemberController::class)->prefix('/member')->group(function () {
        Route::get('/', 'index');
        Route::post('/save', 'store');
        Route::put('/update/{member}', 'update');
    });

    // --- Route for task - /api/task
    Route::controller(TaskController::class)->prefix('/task')->group(function () {
        Route::post('/save', 'createTask');
        Route::get('/task-not-started-topending/{task}', 'taskToNotStartedToPending');
        Route::get('/task-pending-to-completed/{task}', 'taskToPendingToComplete');
        Route::get('/task-pending-to-not-started/{task}', 'taskToPendingToNotStarted');
        Route::get('/task-completed-to-pending/{task}', 'taskToCompletedToPending');
        Route::get('/task-completed-to-not-started/{task}', 'taskToCompletedToNotStarted');
    });
});
