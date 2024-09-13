<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return response()->json([
            'status' => true,
            'message' => 'Teams retrieved successfully',
            'data' => $teams
        ], 200);
    }

    public function show($id)
    {
        $team = Team::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Team found successfully',
            'data' => $team
        ], 200);
    }

    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:customers|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $team = Team::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Team created successfully',
            'data' => $team
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $team = Team::findOrFail($id);
        $team->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Team updated successfully',
            'data' => $team
        ], 200);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Team deleted successfully'
        ], 204);
    }
}