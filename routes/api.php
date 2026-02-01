<?php

use App\Http\Controllers\Employee\CreateEmployeeController;
use App\Http\Controllers\Employee\DeleteEmployeeController;
use App\Http\Controllers\Employee\FindByIdEmployeeController;
use App\Http\Controllers\Employee\ListEmployeesController;
use App\Http\Controllers\Employee\UpdateEmployeeController;
use App\Http\Controllers\EmployeeTask\AssignTaskController;
use App\Http\Controllers\EmployeeTask\ListAssignmentsByEmployeeController;
use App\Http\Controllers\EmployeeTask\ListAssignmentsByTaskController;
use App\Http\Controllers\EmployeeTask\UnassignTaskController;
use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\FindByIdTaskController;
use App\Http\Controllers\Task\GetTaskStatisticsController;
use App\Http\Controllers\Task\ListTasksController;
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

Route::prefix('employees')->group(function () {
    Route::post('/', CreateEmployeeController::class);
    Route::get('/', ListEmployeesController::class);
    Route::get('/{employee}', FindByIdEmployeeController::class);
    Route::patch('/{employee}', UpdateEmployeeController::class);
    Route::delete('/{employee}', DeleteEmployeeController::class);
});

Route::prefix('assignments')->group(function () {
    Route::post('/', AssignTaskController::class);
    Route::delete('/employee/{employee}/task/{task}', UnassignTaskController::class);
    Route::get('/employee/{employee}', ListAssignmentsByEmployeeController::class);
    Route::get('/task/{task}', ListAssignmentsByTaskController::class);
});
