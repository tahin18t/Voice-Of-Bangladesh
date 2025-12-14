<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if (! $user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $stored = $user->password;

        // Allow legacy plain-text passwords: detect non-bcrypt hashes and rehash when matched.
        $isBcrypt = password_get_info($stored)['algoName'] === 'bcrypt';
        $passwordOk = $isBcrypt ? Hash::check($credentials['password'], $stored) : hash_equals($stored, $credentials['password']);

        if (! $passwordOk) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // If legacy password matched in plain text, upgrade it to bcrypt.
        if (! $isBcrypt) {
            $user->forceFill(['password' => Hash::make($credentials['password'])])->save();
        }

        // Log the user in for session + Sanctum token issuing.
        Auth::login($user);

        // Issue Sanctum token when available
        $token = method_exists($user, 'createToken')
            ? $user->createToken('api-token')->plainTextToken
            : null;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
            $token = $request->user()->currentAccessToken();
            if ($token) {
                $token->delete();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
