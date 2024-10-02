<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //director==employee
    public function index(Request $request)
    {
        // Get the 'name' and 'surname' query parameters for filtering
        $name = $request->query('name', '');
        $surname = $request->query('surname', '');

        // Query employees and apply filters if provided
        $employees = Employee::query()
            ->when($name, function ($query, $name) {
                return $query->where('name', 'like', "%{$name}%");
            })
            ->when($surname, function (self $query, $surname) {
                return $query->where('surname', 'like', "%{$surname}%");
            })
            ->get();

        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',

        ]);

        $employee = Employee::create($validated);

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'required|string|max:255',

        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($validated);

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
