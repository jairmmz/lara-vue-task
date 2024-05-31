<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// --- Route for register and login - /api/
Route::controller(AuthController::class)->prefix('/auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/check-email/{token}', 'checkEmail')->name('check_email');
});

// --- Route for projects - /api/project
Route::controller(ProjectController::class)->prefix('/project')->group(function () {
    Route::get('/', 'index');
    Route::post('/save', 'store');
    Route::put('/update/{project}', 'update');
    Route::post('/pinned', 'pinnedProject');
    Route::get('get-project/{slug}', 'getProject');
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
});
