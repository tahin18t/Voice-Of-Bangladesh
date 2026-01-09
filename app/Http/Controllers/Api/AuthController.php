<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


// Note: this controller issues Sanctum personal access tokens. Ensure Laravel Sanctum
// is installed and configured in your app (`composer require laravel/sanctum`), then
// run vendor:publish and migrations. See README instructions below.

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        // Update last login timestamp
        $user->last_login_at = now();
        $user->save();

        // Load role relationship
        $user->load('role');

        // Create Sanctum token
        if (method_exists($user, 'createToken')) {
            $token = $user->createToken('api-token')->plainTextToken;
        } else {
            $token = null;
        }

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->role ? $user->role->name : null,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $user = $request->user();

        if ($user) {
            // Delete all tokens for this user (or just current token)
            $user->tokens()->delete();
        }

        // Handle session logout only if session exists
        if ($request->hasSession()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json(['message' => 'Logged out'], 200);
    }
}
