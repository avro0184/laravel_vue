<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }
        return StudentResource::collection($students);
    }

    public function show($id)
    {
        $student = Student::find($id);
        return $student ? new StudentResource($student) : response()->json(['message' => 'Student not found'], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | min:3 |  string',
            'email' => 'required | email | unique:student',
            'phone' => 'required | max:10 | min:10 |  string',
            'address' => 'max:255 | min:3 |  string',
            'id_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $student = Student::create($request->all());
        return response()->json([
            'message' => 'Student created successfully',
            'student' => $student
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:255 | min:3 |  string',
            'email' => 'required | email',
            'phone' => 'required | max:10 | min:10 |  string',
            'address' => 'required | max:255 | min:3 |  string',
            'id_number' => 'required | max:10 | min:10 |  string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $student->update($request->all());
        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student
        ], 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully',
        ], 200);
    }

}
