<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // Method to list asset types
    public function index(Request $request)
    {
        $name = $request->query('name', '');

        // Fetch asset types, optionally filtering by name
        $teams = Team::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->get();
    
        return response()->json($teams);
    }
    
    // Method to store a new asset type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create($validated);

        return response()->json($team, 201);
    }

    // Method to show a specific asset type by ID
    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json($team);
    }

    // Method to update an existing asset type
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $team = Team::findOrFail($id);
        $team->update($validated);

        return response()->json($team);
    }

    // Method to delete an asset type
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(null, 204);
    }
}
