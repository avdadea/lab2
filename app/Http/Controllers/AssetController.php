<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        // Get the filter query from the request
        $brand_name = $request->query('brand_name', '');
        $production_date = $request->query('production_date', '');
        $asset_type = $request->query('asset_type', '');

        // Query assets with asset_type, applying filters if provided
        $assets = Asset::with('asset_type')
            ->when($brand_name, function ($query, $brand_name) {
                return $query->where('brand_name', 'like', "%$brand_name%");
            })
            ->when($production_date, function ($query, $production_date) {
                return $query->where('production_date', $production_date);
            })
            ->when($asset_type, function ($query, $asset_type) {
                return $query->whereHas('asset_type', function ($query) use ($asset_type) {
                    $query->where('name', 'like', "%$asset_type%");
                });
            })
            ->get();

        return response()->json($assets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'production_date' => 'required|date',
            'asset_type_id' => 'required|exists:asset_types,id', // Ensure the asset type exists by ID
        ]);

        // Creating the asset with the validated data
        $asset = Asset::create($validated);

        return response()->json($asset, 201);
    }

    public function show($id)
    {
        return Asset::with('asset_type')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'brand_name' => 'sometimes|required|string|max:255',
            'production_date' => 'sometimes|required|date',
            'asset_type_id' => 'required|exists:asset_types,id', // Ensure the asset type exists by ID
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update($validated);

        return response()->json($asset);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json(null, 204);
    }
}
