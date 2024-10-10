<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expenses::with('user', 'category')->get();
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:expense_categories,id',
            'user_id' => 'required|exists:users,id', 
            'entry_date' => 'required|date', 
        ]);

        // Create the expense
        $expense = Expenses::create([
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'user_id'=> $request->user_id,
            'entry_date' => $request->entry_date,
        ]);

        
        return response()->json([
            'message' => 'Expense created successfully.',
            'expenses' => $expense
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch a single expense with user and category relationships
        $expense = Expenses::with('user', 'category')->findOrFail($id);
        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenses $expenses, $id)
    {
        $expenses = Expenses::findOrFail($id);
        // Validate update data
        $request->validate([
            'amount' => 'sometimes|numeric',
            'entry_date' => 'sometimes|date',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:expense_categories,id',
            'user_id' => 'sometimes|exists:users,id',
        ]);
    
        // Update the expense
        $expenses->update($request->only([
            'amount',
            'entry_date',
            'description',
            'category_id',
            'user_id',
        ]));
        $expenses->save();
        
        return response()->json($expenses);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        // Delete the expense
        $expenses = Expenses::findOrFail($id);
        $expenses->delete();
        return response()->json(null, 204);
    }
    
}
