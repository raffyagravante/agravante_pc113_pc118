<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
Route::middleware('api')->group(function () {

    Route::get('/students', [StudentController::class, 'index']);  
    Route::post('/students', [StudentController::class, 'store']); 
    Route::get('/students/{student}', [StudentController::class, 'show']); 
    Route::put('/students/{student}', [StudentController::class, 'update']); 
    Route::delete('/students/{student}', [StudentController::class, 'destroy']); 
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);


    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
     Route::post('/logout', [AuthController::class, 'logout']);
    });
}); 
