<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Experience::all());
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

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
        ]);


        $experience = Experience::query()->create([
            'user_id' => $request['user_id'],
            'name' => $request['name'],
            'position' => $request['position'],
            'description' => $request['description'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
        ]);

       return response()->json([
           'message' => 'Experience added successfully',
           'status_code' => 'success',
           'data' => $experience
       ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $experience = Experience::query()->findOrFail($id);
        return response()->json([
            'message' => 'Experience retrieved successfully',
            'status_code' => 'success',
            'data' => $experience
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        $experience = Experience::query()->findOrFail($id);

        $experience->update([
            'user_id' => $request['user_id'],
            'name' => $request['name'],
            'position' => $request['position'],
            'description' => $request['description'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
        ]);
        return response()->json([
            'message' => 'Experience updated successfully',
            'status_code' => 'success',
            'data' => $experience
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $experience = Experience::query()->findOrFail($id);
        $experience->delete();
        return response()->json([
            'message' => 'Experience deleted successfully',
            'status_code' => 'success',
            'data' => $experience
        ], 204);
    }
}
