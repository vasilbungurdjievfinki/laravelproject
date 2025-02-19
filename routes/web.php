<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/filter', [ProjectController::class, 'filterByDueDate']);

Route::get('tasks', [TaskController::class, 'index']);
Route::patch('tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');


Route::prefix('api')->group(function () {
    Route::post('projects', [ProjectController::class, 'create']);
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/filter', [ProjectController::class, 'filterByDueDate']);

    Route::post('categories', [CategoryController::class, 'create']);
    Route::get('categories', [CategoryController::class, 'index']);

    Route::post('tasks', [TaskController::class, 'create']);
    Route::get('tasks', [TaskController::class, 'index']);
    Route::patch('tasks/{task}/complete', [TaskController::class, 'markAsCompleted']);
});
