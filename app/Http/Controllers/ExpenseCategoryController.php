<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::all(['id', 'expenseCategory', 'description', 'created_at']);
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expenseCategory' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $category = ExpenseCategory::create($request->all());
        return response()->json([
            'message' => 'Expense Category created successfully',
            'category' => $category
        ],  201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return response()->json($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, $id)
{
    $request->validate([
        'expenseCategory' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
    ]);

    $expenseCategory = ExpenseCategory::findOrFail($id);
    $expenseCategory->fill($request->post());
    $expenseCategory->save(); // Ensure the parentheses are present

    return response()->json([
        'message' => 'Expense Category updated successfully',
        'category' => $expenseCategory // This now has the updated data
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        $expenseCategory->delete();

        return response()->json([
            'message' => 'Expense Category Deleted Successfully!'
        ],  200);
    }
}
