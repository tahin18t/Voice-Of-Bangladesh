<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignupController extends Controller
{
    /**
     * Show the signup form.
     */
    public function create()
    {
        $departments = [
            'Road',
            'Water',
            'Bridge',
            'Crime',
            'Electricity',
            'Environment',
            'Health',
            'Education',
            'Transport',
            'Other',
        ];

        $roles = Role::orderBy('name')->get(['id', 'name']);

        return view('signup', [
            'departments' => $departments,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created user record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
            'department' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Insert directly so the password stays as plain text per the request.
        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'department' => $validated['department'],
            'avatar' => $avatarPath,
            'role_id' => $validated['role_id'],
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('signup.show')
            ->with('success', 'Account created successfully. You can now log in.');
    }
}
