<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController; // Import the StudentController
use App\Http\Controllers\EmployeeController; // Import the EmployeeController

// Student Routes
Route::prefix('students')->group(function () {
    Route::post('/', [StudentController::class, 'store']); // Create a new student
    Route::get('/', [StudentController::class, 'index']); // Get all students
    Route::get('{student}', [StudentController::class, 'show']); // Get a single student
    Route::put('{student}', [StudentController::class, 'update']); // Update a student
    Route::delete('{student}', [StudentController::class, 'destroy']); // Delete a student
});


Route::prefix('employees')->group(function () {
    Route::post('/', [EmployeeController::class, 'store']); 
    Route::get('/', [EmployeeController::class, 'index']); 
    Route::get('{employee}', [EmployeeController::class, 'show']); 
    Route::put('{employee}', [EmployeeController::class, 'update']); 
    Route::delete('{employee}', [EmployeeController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
