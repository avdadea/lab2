<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use Illuminate\Http\Request;

//employee==explorer
class ChefController extends Controller
{
    //director==employee
    public function index(Request $request)
    {
        $name = $request->query('name', '');
        $birth_year = $request->query('birth_year', '');
    
        $chefs = Chef::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($birth_year, function ($query, $birth_year) {
                return $query->where('birth_year', $birth_year);
            })
            ->get();
    
        return response()->json($chefs);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_year' => 'required|integer|min:1900|max:'.date('Y'),

        ]);

        $chef = Chef::create($validated);

        return response()->json($chef, 201);
    }

    public function show($id)
    {
        $chef = Chef::findOrFail($id);
        return response()->json($chef);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'birth_year' => 'required|integer|min:1900|max:'.date('Y'),

        ]);

        $chef = Chef::findOrFail($id);
        $chef->update($validated);

        return response()->json($chef);
    }

    public function destroy($id)
    {
        $chef = Chef::findOrFail($id);
        $chef->delete();

        return response()->json(null, 204);
    }
}
