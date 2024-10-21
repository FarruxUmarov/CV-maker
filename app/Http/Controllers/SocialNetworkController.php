<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;

class SocialNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(SocialNetwork::all());
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
        $social_network = SocialNetwork::query()->create([
            'name' => $request['name'],
            'link' => $request['link'],
        ]);

        return response()->json([
            'message' => 'Social network created successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $social_network = SocialNetwork::query()->find($id);
        return response()->json([
            'message' => 'Social network retrieved successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialNetwork $socialNetwork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        $social_network = SocialNetwork::query()->find($id);
        $social_network->update([
            'name' => $request['name'],
            'link' => $request['link'],
        ]);
        return response()->json([
            'message' => 'Social network updated successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $social_network = SocialNetwork::query()->find($id);
        $social_network->delete();
        return response()->json([
            'message' => 'Social network deleted successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ]);
    }
}
