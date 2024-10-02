<?php

namespace App\Http\Controllers;

use App\Models\Renovation;
use App\Models\Building;
use Illuminate\Http\Request;

//movie==CONTRACT 
class RenovationController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $description = $request->query('description', '');
    $cost = $request->query('cost', '');
    $building = $request->query('building', '');

    // Query contracts with employees, applying filters if provided
    $renovations = Renovation::with(relations: 'building')
        ->when($description, function ($query, $description) {
            return $query->where('description', 'like', "%$description%");
        })
        ->when($cost, function ($query, $cost) {
            return $query->where('cost', $cost);
        })
        ->when($building, function ($query, $building) {
            return $query->whereHas('building', function ($query) use ($building) {
                $query->where('name', 'like', "%$building%")
                      ->orWhere('location', 'like', "%$building%");
            });
        })
        ->get();

    return response()->json($renovations);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'cost' => 'required|integer|min:0',
            'building_id' => 'required|exists:buildings,id', // Ensure the director exists
        ]);

        $renovation = Renovation::create($validated);

        return response()->json($renovation, 201);
    }

    public function show($id)
    {
        return Renovation::with('building')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'cost' => 'required|integer|min:0',
            'building_id' => 'required|exists:buildings,id', // Ensure the director exists
       ]);

        $renovation = Renovation::findOrFail($id);
        $renovation->update($validated);

        return response()->json($renovation);
    }

    public function destroy($id)
    {
        $renovation = Renovation::findOrFail($id);
        $renovation->delete();

        return response()->json(null, 204);
    }
}
