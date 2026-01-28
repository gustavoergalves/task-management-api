<?php

use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\GetTaskStatisticsController;
use App\Http\Controllers\Task\ListTasksController;
use App\Http\Controllers\Task\FindByIdTaskController;
use App\Http\Controllers\Task\UpdateTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('tasks')->group(function () {
    Route::post('/', CreateTaskController::class);
    Route::get('/', ListTasksController::class);
    Route::get('/statistics', GetTaskStatisticsController::class);
    Route::get('/{task}', FindByIdTaskController::class);
    Route::patch('/{task}', UpdateTaskController::class);
    Route::delete('/{task}', DeleteTaskController::class);
});
