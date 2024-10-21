<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Skill::all());
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
        $skill = Skill::query()->create([
        'name' => $request['name'],
        ]);
        return response()->json([
            'message' => 'Skill created successfully',
            'status' => 'success',
            'skill' => $skill
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $skill = Skill::query()->findOrFail($id);
        return response()->json([
            'message' => 'Skill retrieved successfully',
            'status' => 'success',
            'skill' => $skill
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $skill = Skill::query()->findOrFail($id);
        $skill->update([
            'name' => $request['name'],
        ]);

        return response()->json([
            'message' => 'Skill updated successfully',
            'status' => 'success',
            'skill' => $skill
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $skill = Skill::query()->findOrFail($id);
        $skill->delete();
        return response()->json([
            'message' => 'Skill deleted successfully',
            'status' => 'success',
            'skill' => $skill
        ]);
    }
}
