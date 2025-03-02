<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;


Route::middleware('api')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);  
    Route::post('/students', [StudentController::class, 'store']); 
    Route::get('/students/{student}', [StudentController::class, 'show']); 
    Route::put('/students/{student}', [StudentController::class, 'update']); 
    Route::delete('/students/{student}', [StudentController::class, 'destroy']); 
});