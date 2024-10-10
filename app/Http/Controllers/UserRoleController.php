<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userRoles = UserRole::all(['id', 'roleName', 'description', 'created_at']);
        return response()->json($userRoles);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $userRole = UserRole::create($request->all());

        return response()->json([
            'message' => 'Role Created Successfully!',
            'userRole' => $userRole
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        return response()->json($userRole);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'roleName' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $userRole = UserRole::findOrFail($id);
        $userRole->fill($request->post())->save();

        return response()->json([
            'message' => 'User Role Updated Successfully!',
            'userRole' => $userRole
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userRole = UserRole::findOrFail($id);
        $userRole->delete();

        return response()->json([
            'message' => 'User Role Deleted Successfully!'
        ], 200);
    }

    
}
