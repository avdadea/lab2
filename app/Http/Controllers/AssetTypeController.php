<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    // Method to list asset types
    public function index(Request $request)
    {
        $name = $request->query('name', '');

        // Fetch asset types, optionally filtering by name
        $asset_types = AssetType::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->get();
    
        return response()->json($asset_types);
    }
    
    // Method to store a new asset type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $asset_type = AssetType::create($validated);

        return response()->json($asset_type, 201);
    }

    // Method to show a specific asset type by ID
    public function show($id)
    {
        $asset_type = AssetType::findOrFail($id);
        return response()->json($asset_type);
    }

    // Method to update an existing asset type
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'is_active' => 'sometimes|required|boolean',
        ]);

        $asset_type = AssetType::findOrFail($id);
        $asset_type->update($validated);

        return response()->json($asset_type);
    }

    // Method to delete an asset type
    public function destroy($id)
    {
        $asset_type = AssetType::findOrFail($id);
        $asset_type->delete();

        return response()->json(null, 204);
    }
}
