<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanetController extends Controller
{
    public function index(Request $request)
    {
        $query = Planet::query();

    
        // Search by name
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');

        }

    if ($request->has('type')) {
        $query->where('type', 'like', '%' . $request->input('type') . '%'); // Use 'like' for text search
        $query->where('isDeleted', false);

    }
 
    $query->where('isDeleted', false);

    
        $planets = $query->get();
    
        return response()->json([
            'status' => true,
            'message' => 'Planets retrieved successfully',
            'data' => $planets
        ], 200);
    }
    



    public function show($id)
    {
        $Planet = Planet::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Planet found successfully',
            'data' => $planet
        ], 200);
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:customers|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $planet = Planet::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Planet created successfully',
            'data' => $planet
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $planet = Planet::findOrFail($id);
        $planet->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Planet updated successfully',
            'data' => $planet
        ], 200);
    }

    // public function destroy($id)
    // {
    //     $planet = Planet::findOrFail($id);
    //     $planet->delete();
        
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Planet deleted successfully'
    //     ], 204);
    // }
    public function destroy($id)
    {
        // Find the planet by its ID
        $planet = Planet::findOrFail($id);
        
        // Mark the planet as deleted by setting isDeleted to 1 (soft delete)
        $planet->isDeleted = 1;
        
        // Save the changes to the database
        $planet->save();
        
        // Return a JSON response indicating success
        return response()->json([
            'status' => true,
            'message' => 'Planet marked as deleted successfully',
            'data' => $planet
        ], 200);
    }
    
}