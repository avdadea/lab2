<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request): JsonResponse
{
    $query = Player::query();
        // ->join('teams', 'players.team_id', '=', 'teams.id')
        // ->select('players.*', 'teams.name as team_name')
        // ->where('players.isDeleted', false);

    // Filter by players name
    // if ($request->has('name') && $request->input('name') !== '') {
    //     $query->where('players.name', 'like', '%' . $request->input('name') . '%');
    // }

    // // Filter by planet name
    // if ($request->has('team_name') && $request->input('team_name') !== '') {d
    //     $query->where('teams.name', 'like', '%' . $request->input('team_name') . '%');
    // }

    $players = $query->paginate();

    return response()->json([
        'status' => true,
        'message' => 'Players retrieved successfully',
        'data' => $players
    ], 200);
}

    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number'=>'required|integer',
            'birthYear' => 'required|integer',
            'team_id' => 'required|integer|exists:teams,id',
            // Add other fields as needed
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Create the player with validated data
        $player = Player::create($validator->validated());
    
        return response()->json([
            'status' => true,
            'message' => 'Player created successfully',
            'data' => $player
        ], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json([
                'status' => false,
                'message' => 'Player not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Player retrieved successfully',
            'data' => $player
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'birthYear' => 'required|integer',
            'team_id' => 'required|integer|exists:teams,id',
            // Add other fields as needed
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
    
        // Find the player by ID
        $player = Player::find($id);
    
        // If player not found, return 404 response
        if (!$player) {
            return response()->json([
                'status' => false,
                'message' => 'Player not found'
            ], 404);
        }
    
        // Update the player with validated data
        $player->update($validator->validated());
    
        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Player updated successfully',
            'data' => $player
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */

     public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'player deleted successfully'
        ], 204);
    }
}


