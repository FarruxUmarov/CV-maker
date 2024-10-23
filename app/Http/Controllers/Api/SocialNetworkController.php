<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $validated = $request->validate([
            'name' => 'required|unique:social_networks|max:255',
            'link' => 'required|url|max:255',
        ]);

        $social_network = SocialNetwork::query()->create([
            'name' => $request['name'],
            'link' => $request['link'],
        ]);

        return response()->json([
            'message' => 'Social network created successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $social_network = SocialNetwork::find($id);

        if (!$social_network) {
            return response()->json(['message' => 'Social network not found.'], 404);
        }

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

        $validated = $request->validate([
            'name' => 'required|unique:social_networks|max:255',
            'link' => 'required|url|max:255',
        ]);

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

        if(!$social_network){
            return response()->json(['message' => 'Social network not found.'], 404);
        }
        $social_network->delete();


        return response()->json([
            'message' => 'Social network deleted successfully.',
            'status_code' => 'success',
            'social_network' => $social_network
        ], 204);
    }
}
