<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Student::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $student = Student::query()->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'nt_id' => $request['nt_id'],
            'image' => $request['image'],
            'phone' => $request['phone'],
            'profession' => $request['profession'],
            'biography' => $request['biography'],
        ]);

        $token = $student->createToken($student->first_name)->plainTextToken;

        return response()->json([
            'message' => 'Student created successfully',
            'status' => 'success',
            'token' => $token,
            'student' => $student,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        return response()->json(Student::query()->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $student = Student::query()->findOrFail($id);

        $student->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'nt_id' => $request['nt_id'],
            'image' => $request['image'],
            'phone' => $request['phone'],
            'profession' => $request['profession'],
            'biography' => $request['biography'],
        ]);

        $token = $student->createToken($student->first_name)->plainTextToken;

        return response()->json([
            'message' => 'Student updated successfully',
            'status' => 'success',
            'token' => $token,
            'student' => $student,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $student = Student::query()->findOrFail($id);
        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully',
            'status' => 'success',
        ]);
    }
}
