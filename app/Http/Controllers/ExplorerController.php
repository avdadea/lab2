<?php

namespace App\Http\Controllers;

use App\Models\Explorer;
use Illuminate\Http\Request;

//employee==explorer
class ExplorerController extends Controller
{
    //director==employee
    public function index(Request $request)
    {
        $name = $request->query('name', '');
        $nationality = $request->query('nationality', '');
    
        $explorers = Explorer::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($nationality, function ($query, $nationality) {
                return $query->where('nationality', 'like', "%{$nationality}%");
            })
            ->get();
    
        return response()->json($explorers);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',

        ]);

        $explorer = Explorer::create($validated);

        return response()->json($explorer, 201);
    }

    public function show($id)
    {
        $explorer = Explorer::findOrFail($id);
        return response()->json($explorer);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'nationality' => 'required|string|max:255',

        ]);

        $explorer = Explorer::findOrFail($id);
        $explorer->update($validated);

        return response()->json($explorer);
    }

    public function destroy($id)
    {
        $explorer = Explorer::findOrFail($id);
        $explorer->delete();

        return response()->json(null, 204);
    }
}
