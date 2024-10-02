<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Chef;
use Illuminate\Http\Request;

//movie==CONTRACT 
class RecipeController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $title = $request->query('title', '');
    $difficulty = $request->query('difficulty', '');
    $chef = $request->query('chef', '');

    // Query contracts with employees, applying filters if provided
    $recipes = Recipe::with('chef')
        ->when($title, function ($query, $title) {
            return $query->where('title', 'like', "%$title%");
        })
        ->when($difficulty, function ($query, $difficulty) {
            return $query->where('difficulty', 'like', "%$difficulty%");
        })
        ->when($chef, function ($query, $chef) {
            return $query->whereHas('chef', function ($query) use ($chef) {
                $query->where('name', 'like', "%$chef%")
                      ->orWhere('birth_year', $chef);
            });
        })
        ->get();

    return response()->json($recipes);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'difficulty' => 'required|string|max:255',
            'chef_id' => 'required|exists:chefs,id', // Ensure the director exists
        ]);

        $recipe = Recipe::create($validated);

        return response()->json($recipe, 201);
    }

    public function show($id)
    {
        return Recipe::with('chef')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'difficulty' => 'required|string|max:255',
            'chef_id' => 'required|exists:chefs,id', // Ensure the director exists
       ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->update($validated);

        return response()->json($recipe);
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json(null, 204);
    }
}
