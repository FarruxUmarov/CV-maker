<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Project::all());
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
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'source_link' => 'required|url',
            'demo_link' => 'required|url',
        ]);

        $project = Project::query()->create([
            'user_id' => $request['user_id'],
            'name' => $request['name'],
            'description' => $request['description'],
            'source_link' => $request['source_link'],
            'demo_link' => $request['demo_link'],
        ]);

        return response()->json([
            'message' => 'Project created successfully',
            'status_code' => 'success',
            'project' => $project
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $project = Project::query()->findOrFail($id);
        return response()->json([
            'message' => 'Project retrieved successfully',
            'status_code' => 'success',
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'source_link' => 'required|url',
            'demo_link' => 'required|url',
        ]);

        $project = Project::query()->findOrFail($id);

        $project->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'source_link' => $request->source_link,
            'demo_link' => $request->demo_link
        ]);
        return response()->json([
            'message' => 'Project updated successfully',
            'status_code' => 'success',
            'project' => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $project = Project::query()->findOrFail($id);
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully',
            'status_code' => 'success',
        ],204);
    }
}
