<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Login user and return token
     */
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception("Invalid email or password");
        }

        if (!$user->is_active) {
            throw new \Exception("User account is inactive");
        }

        // Update last login timestamp
        $user->update(['last_login_at' => now()]);

        // Create personal access token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user->load('role'),
            'message' => 'Login successful'
        ];
    }

    /**
     * Logout user by revoking current token
     */
    public function logout($user)
    {
        // Revoke the current token
        $user->currentAccessToken()->delete();

        return ['message' => 'Logged out successfully'];
    }

    /**
     * Register new user
     */
    public function register($data)
    {
        // Check if email exists
        if (User::where('email', $data['email'])->exists()) {
            throw new \Exception("Email already registered");
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 3, // Default to citizen role
            'is_active' => true,
        ];

        $user = User::create($userData);

        // Create personal access token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user->load('role'),
            'message' => 'Registration successful'
        ];
    }

    /**
     * Verify token
     */
    public function verifyToken($user)
    {
        return [
            'authenticated' => true,
            'user' => $user->load('role')
        ];
    }

    /**
     * Refresh user data
     */
    public function refreshUser($user)
    {
        return $user->fresh('role');
    }
}
