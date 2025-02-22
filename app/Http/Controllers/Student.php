<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 

class StudentController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'hello'
        ], 200);
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string', 
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:8',
        ]);

        $employee = Employee::create($validatedData); 

        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee
        ], 201);
    }
}
