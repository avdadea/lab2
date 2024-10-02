<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

//movie==CONTRACT 
class PlayerController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $name = $request->query('name', '');
    $number = $request->query('number', '');
    $birth_year = $request->query('birth_year', '');
    $team = $request->query('team', '');

    // Query contracts with employees, applying filters if provided
    $players = Player::with(relations: 'team')
    
        ->when($name, function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })
        ->when($number, function ($query, $number) {
            return $query->where('number', $number);
        })
        ->when($birth_year, function ($query, $birth_year) {
            return $query->where('birth_year', $birth_year);
        })
        ->when($team, function ($query, $team) {
            return $query->whereHas('team', function ($query) use ($team) {
                $query->where('name', 'like', "%$team%");
            });
        })
        ->get();

    return response()->json($players);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|min:0',
            'birth_year' => 'required|integer|min:1900|max:'.date('Y'),
            'team_id' => 'required|exists:teams,id', // Ensure the team exists
        ]);

        $player = Player::create($validated);

        return response()->json($player, 201);
    }

    public function show($id)
    {
        return Player::with('team')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|min:0',
            'birth_year' => 'required|integer|min:1900|max:'.date('Y'),
            'team_id' => 'required|exists:teams,id', // Ensure the team exists
       ]);

        $player = Player::findOrFail($id);
        $player->update($validated);

        return response()->json($player);
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        return response()->json(null, 204);
    }
}
