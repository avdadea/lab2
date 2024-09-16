<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;

//movie==CONTRACT 
class ContractController extends Controller
{
   public function index(Request $request)
{
    // Get the filter query from the request
    $title = $request->query('title', '');
    $description = $request->query('description', '');
    $employee = $request->query('employee', '');

    // Query contracts with employees, applying filters if provided
    $contracts = Contract::with('employee')
        ->when($title, function ($query, $title) {
            return $query->where('title', 'like', "%$title%");
        })
        ->when($description, function ($query, $description) {
            return $query->where('description', 'like', "%$description%");
        })
        ->when($employee, function ($query, $employee) {
            return $query->whereHas('employee', function ($query) use ($employee) {
                $query->where('name', 'like', "%$employee%")
                      ->orWhere('surname', 'like', "%$employee%");
            });
        })
        ->get();

    return response()->json($contracts);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id', // Ensure the director exists
        ]);

        $contract = Contract::create($validated);

        return response()->json($contract, 201);
    }

    public function show($id)
    {
        return Contract::with('employee')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'required|string|max:255',
            'employee_id' => 'required|exists:employees,id', // Ensure the director exists
       ]);

        $contract = Contract::findOrFail($id);
        $contract->update($validated);

        return response()->json($contract);
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        return response()->json(null, 204);
    }
}
