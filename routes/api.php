<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/search', [StudentController::class, 'search']);
Route::post('/students', [StudentController::class, 'create']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'delete']);

Route::get('/employees', [EmployeeController::class, 'employee']);
Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::post('/employees', [EmployeeController::class, 'create']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);