<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use App\Models\Satellite;
use Illuminate\Http\Request;

//movie==CONTRACT 
class SatelliteController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $name = $request->query('name', '');
    $planet = $request->query('planet', '');

    // Query contracts with employees, applying filters if provided
    $satellites = Satellite::with(relations: 'planet')
    
        ->when($name, function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })
        ->when($planet, function ($query, $planet) {
            return $query->whereHas('planet', function ($query) use ($planet) {
                $query->where('name', 'like', "%$planet%")
                      ->orWhere('type', 'like', "%$planet%");
            });
        })
        ->get();

    return response()->json($satellites);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'planet_id' => 'required|exists:planets,id', // Ensure the director exists
        ]);

        $satellite = Satellite::create($validated);

        return response()->json($satellite, 201);
    }

    public function show($id)
    {
        return Satellite::with('planet')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'planet_id' => 'required|exists:planets,id', // Ensure the director exists
       ]);

        $satellite = Satellite::findOrFail($id);
        $satellite->update($validated);

        return response()->json($satellite);
    }

    public function destroy($id)
    {
        $satellite = Satellite::findOrFail($id);
        $satellite->is_deleted = true; // Set is_deleted to true (1)
        $satellite->save();

    return response()->json(['message' => 'Satellite soft deleted successfully.'], 200);
  }
}
