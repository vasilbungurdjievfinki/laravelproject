<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;


Route::post('projects', [ProjectController::class, 'create']);  // Create a project
Route::get('projects', [ProjectController::class, 'index']);    // List all projects
Route::get('projects/filter', [ProjectController::class, 'filterByDueDate']);  // Filter projects by due date

Route::post('categories', [CategoryController::class, 'create']);  // Create a category
Route::get('categories', [CategoryController::class, 'index']);    // List all categories

Route::post('tasks', [TaskController::class, 'create']);  // Create a task
Route::get('tasks', [TaskController::class, 'index']);    // List all tasks (with filters for category and status)
Route::patch('tasks/{task}/complete', [TaskController::class, 'markAsCompleted']);  // Mark task as completed
