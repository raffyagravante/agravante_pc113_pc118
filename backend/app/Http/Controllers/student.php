<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student; 

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query(); 

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('age', 'like', "%{$search}%")
                ->orWhere('gender', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('course', 'like', "%{$search}%")
                ->orWhere('contact_number', 'like', "%{$search}%");
        }

        $students = $query->get(); 
        return response()->json($students, 200);
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,',
            'course' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
        ]);

        $student = Student::create($validatedData); 

        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student,
        ], 201);
    }

    public function show(Student $student) 
    {
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id); 
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'course' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
        ]);

        $student->update($validatedData);
        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student,
        ]);
    }

    public function destroy($id)
    {
        $student = Student::find($id); 
        if (is_null($student)) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
