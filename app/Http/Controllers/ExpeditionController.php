<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use App\Models\Explorer;
use Illuminate\Http\Request;

//movie==CONTRACT 
class ExpeditionController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $destination = $request->query('destination', '');
    $crew_size = $request->query('crew_size', '');
    $explorer = $request->query('explorer', '');

    // Query contracts with employees, applying filters if provided
    $expeditions = Expedition::with('explorer')
        ->when($destination, function ($query, $destination) {
            return $query->where('destination', 'like', "%$destination%");
        })
        ->when($crew_size, function ($query, $crew_size) {
            return $query->where('crew_size', $crew_size);
        })
        ->when($explorer, function ($query, $explorer) {
            return $query->whereHas('explorer', function ($query) use ($explorer) {
                $query->where('name', 'like', "%$explorer%")
                      ->orWhere('nationality', 'like', "%$explorer%");
            });
        })
        ->get();

    return response()->json($expeditions);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'crew_size' => 'required|integer|min:0',
            'explorer_id' => 'required|exists:explorers,id', // Ensure the director exists
        ]);

        $expedition = Expedition::create($validated);

        return response()->json($expedition, 201);
    }

    public function show($id)
    {
        return Expedition::with('explorer')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'destination' => 'required|string|max:255',
            'crew_size' => 'required|integer|min:0',
            'explorer_id' => 'required|exists:explorers,id', // Ensure the director exists
       ]);

        $expedition = Expedition::findOrFail($id);
        $expedition->update($validated);

        return response()->json($expedition);
    }

    public function destroy($id)
    {
        $expedition = Expedition::findOrFail($id);
        $expedition->delete();

        return response()->json(null, 204);
    }
}
