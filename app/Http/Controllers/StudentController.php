<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // GET: View all students
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // POST: Add a student
    public function store(Request $request)
{
    $validated = $request->validate([
        'student_no' => 'required|string|max:20|unique:students,student_no',
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'course' => 'required|string|max:50',
        'year_level' => 'required|integer|between:1,4',
        'email' => 'nullable|email|max:150',
    ]);

    $student = Student::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Student created successfully.',
        'data' => $student,
    ], 201);
}

    // GET: View one student
    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json($student, 200);
    }

    // PUT: Update a student
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'course' => 'required|string|max:255',
            'year_level' => 'required|integer|min:1|max:6',
        ]);

        $student->update($validated);

        return response()->json($student, 200);
    }

    // DELETE: Delete a student
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }
}