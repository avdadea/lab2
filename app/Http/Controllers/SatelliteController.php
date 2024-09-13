<?php

namespace App\Http\Controllers;

use App\Models\Satellite;
use Illuminate\Http\Request;
use App\Http\Requests\SatelliteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class SatelliteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request): JsonResponse
{
    $query = Satellite::query()
        ->join('planets', 'satellites.planet_id', '=', 'planets.id')
        ->select('satellites.*', 'planets.name as planet_name')
        ->where('satellites.isDeleted', false);

    // Filter by satellite name
    if ($request->has('name') && $request->input('name') !== '') {
        $query->where('satellites.name', 'like', '%' . $request->input('name') . '%');
    }

    // Filter by planet name
    if ($request->has('planet_name') && $request->input('planet_name') !== '') {
        $query->where('planets.name', 'like', '%' . $request->input('planet_name') . '%');
    }

    $satellites = $query->paginate();

    return response()->json([
        'status' => true,
        'message' => 'Satellites retrieved successfully',
        'data' => $satellites
    ], 200);
}

    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(SatelliteRequest $request): JsonResponse
    {
        $satellite = Satellite::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Satellite created successfully',
            'data' => $satellite
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $satellite = Satellite::find($id);

        if (!$satellite) {
            return response()->json([
                'status' => false,
                'message' => 'Satellite not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Satellite retrieved successfully',
            'data' => $satellite
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SatelliteRequest $request, $id): JsonResponse
    {
        $satellite = Satellite::find($id);

        if (!$satellite) {
            return response()->json([
                'status' => false,
                'message' => 'Satellite not found'
            ], 404);
        }

        $satellite->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Satellite updated successfully',
            'data' => $satellite
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        // Find the planet by its ID
        $satellite = Satellite::findOrFail($id);
        
        // Mark the planet as deleted by setting isDeleted to 1 (soft delete)
        $satellite->isDeleted = 1;
        
        // Save the changes to the database
        $satellite->save();
        
        // Return a JSON response indicating success
        return response()->json([
            'status' => true,
            'message' => 'Satellite marked as deleted successfully',
            'data' => $satellite
        ], 200);
    }
}


