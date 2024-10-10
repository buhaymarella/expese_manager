<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8', 
        ]);

        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and if the password is valid
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Log the failed login attempt
            Log::warning('Invalid login attempt', ['email' => $request->email]);
            
            // Return a JSON response with an error message
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials. Please try again.'],
            ]);
        }

        // Return user information including role and ID
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
            ],
        ]);
    }
}
