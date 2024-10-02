<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Illuminate\Http\Request;

//employee==explorer
class PlanetController extends Controller
{
    //director==employee
    public function index(Request $request)
    {
        $name = $request->query('name', '');
        $type = $request->query('type', '');
    
        $planets = Planet::query()
   //   ->where('is_deleted', false)  // Only fetch planets that are not deleted
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', 'like', "%{$type}%");
            })
            ->get();
    
        return response()->json($planets);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',

        ]);

        $planet = Planet::create($validated);

        return response()->json($planet, 201);
    }

    public function show($id)
    {
        $planet = Planet::findOrFail($id);
        return response()->json($planet);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'required|string|max:255',

        ]);

        $planet = Planet::findOrFail($id);
        $planet->update($validated);

        return response()->json($planet);
    }

    public function destroy($id)
    {
        $planet = Planet::findOrFail($id);
        $planet->is_deleted = true; // Set is_deleted to true (1)
        $planet->save();

    return response()->json(['message' => 'Planet soft deleted successfully.'], 200);

    }
}
