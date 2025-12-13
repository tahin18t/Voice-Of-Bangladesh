<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get all users with optional filters
     */
    public function getAllUsers($filters = [], $perPage = 15)
    {
        $query = User::query();

        // Filter by role
        if (isset($filters['role'])) {
            $query->where('role_id', $filters['role']);
        }

        // Filter by active status
        if (isset($filters['active'])) {
            $query->where('is_active', $filters['active']);
        }

        // Search by name or email
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->with('role')->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get user by ID
     */
    public function getUserById($id)
    {
        return User::with('role')->findOrFail($id);
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create new user
     */
    public function createUser($data)
    {
        // Check if email exists
        if (User::where('email', $data['email'])->exists()) {
            throw new \Exception("Email already exists");
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? 2, // Default to citizen role
            'is_active' => $data['is_active'] ?? true,
            'department' => $data['department'] ?? null,
            'avatar' => $data['avatar'] ?? null,
        ];

        return User::create($userData);
    }

    /**
     * Update user
     */
    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id);

        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['email'])) {
            // Check if new email already exists
            if ($data['email'] !== $user->email && User::where('email', $data['email'])->exists()) {
                throw new \Exception("Email already exists");
            }
            $updateData['email'] = $data['email'];
        }
        if (isset($data['role_id'])) $updateData['role_id'] = $data['role_id'];
        if (isset($data['department'])) $updateData['department'] = $data['department'];
        if (isset($data['is_active'])) $updateData['is_active'] = $data['is_active'];
        if (isset($data['avatar'])) $updateData['avatar'] = $data['avatar'];

        $user->update($updateData);

        return $user->load('role');
    }

    /**
     * Change user password
     */
    public function changePassword($id, $oldPassword, $newPassword)
    {
        $user = User::findOrFail($id);

        if (!Hash::check($oldPassword, $user->password)) {
            throw new \Exception("Current password is incorrect");
        }

        $user->update(['password' => Hash::make($newPassword)]);

        return $user;
    }

    /**
     * Reset user password (admin only)
     */
    public function resetPassword($id, $newPassword)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($newPassword)]);

        return $user;
    }

    /**
     * Deactivate user
     */
    public function deactivateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);

        return $user;
    }

    /**
     * Activate user
     */
    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => true]);

        return $user;
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return true;
    }

    /**
     * Get officers only
     */
    public function getOfficers($perPage = 15)
    {
        // Assuming role_id 2 is officer role
        return User::where('role_id', 2)
            ->where('is_active', true)
            ->with('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get user statistics
     */
    public function getStatistics()
    {
        return [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'officers' => User::where('role_id', 2)->count(),
            'citizens' => User::where('role_id', 3)->count(),
            'admins' => User::where('role_id', 1)->count(),
        ];
    }
}
