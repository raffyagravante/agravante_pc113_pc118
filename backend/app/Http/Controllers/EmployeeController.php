<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function employeeD()
    {
        return view('employee.dashboard');
    }

    public function list()
    {
        return response()->json(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $employee = Employee::create($request->all());

        return response()->json([
            'status' => true, 
            'message' => 'Employee created successfully', 
            'employee' => $employee
        ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

   
    
    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $employees = Employee::where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->get();

            if ($employees->isNotEmpty()) {
                return response()->json($employees);
            } else {
                return response()->json(['message' => 'Employee not found'], 404);
            }
        }

        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $employee = Employee::find($id); // Correct variable name and case
        try {
            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404); // Corrected message
            }
    
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email,' . $employee->id, // Correct table name
                'position' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $employee->update($request->all());
    
            return response()->json([
                'message' => 'Employee updated successfully',
                'employee' => $employee,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Employee deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $Employee = Employee::find($id);
    
        if (!$Employee) {
            return response()->json(['status' => false, 'message' => 'Employee not found'], 404);
        }
    
        return response()->json($Employee, 200);
    }
    
    

}
