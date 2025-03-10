<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeModel;
use Illuminate\Support\Facades\Log;
class EmployeeController extends Controller
{
    // Constructor to add authentication middleware
    public function __construct()
    {
        $this->middleware('auth:api');  // Ensure user is authenticated
    }

    // Get a list of employees with optional search
    public function index(Request $request)
    {
        $query = EmployeeModel::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('age', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
        }

        $employees = $query->paginate(10);  // Paginate the results
        return response()->json($employees, 200);
    }

    // Store a new employee
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:employees',
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
        ]);

        $employee = EmployeeModel::create($validatedData);

        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ], 201);
    }

    // Show a single employee by ID
    public function show(EmployeeModel $employee)
    {
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }

    // Update an existing employee
    public function update(Request $request, $id)
    {
        $employee = EmployeeModel::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'position' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
        ]);

        $employee->update($validatedData);

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee,
        ]);
    }

    // Delete an employee
    public function destroy($id)
    {
        $employee = EmployeeModel::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
