<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

//employee==explorer
class BuildingController extends Controller
{
    //director==employee
    public function index(Request $request)
    {
        $name = $request->query('name', '');
        $location = $request->query('location', '');
    
        $buildings = Building::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($location, function ($query, $location) {
                return $query->where('location', 'like', "%{$location}%");
            })
            ->get();
    
        return response()->json($buildings);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',

        ]);

        $building = Building::create($validated);

        return response()->json($building, 201);
    }

    public function show($id)
    {
        $building = Building::findOrFail($id);
        return response()->json($building);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'required|string|max:255',

        ]);

        $building = Building::findOrFail($id);
        $building->update($validated);

        return response()->json($building);
    }

    public function destroy($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return response()->json(null, 204);
    }
}
