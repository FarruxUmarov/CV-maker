<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Language::all());
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
        $language = Language::query()->create([
            'name' => $request['name'],
            'level' => $request['level'],
        ]);
        return response()->json([
            'message' => 'Language created successfully.',
            'status_code' => 'success',
            'language' => $language,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id ): \Illuminate\Http\JsonResponse
    {
        $language = Language::query()->findOrFail($id);
        return response()->json([
            'message' => 'Language retrieved successfully.',
            'status_code' => 'success',
            'language' => $language,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  string $id): \Illuminate\Http\JsonResponse
    {
        $language = Language::query()->findOrFail($id);
        $language->update([
            'name' => $request['name'],
            'level' => $request['level'],
        ]);
        return response()->json([
            'message' => 'Language updated successfully.',
            'status_code' => 'success',
            'language' => $language,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $language = Language::query()->findOrFail($id);
        $language->delete();
        return response()->json([
            'message' => 'Language deleted successfully.',
            'status_code' => 'success',
            'language' => $language,
        ]);
    }
}
