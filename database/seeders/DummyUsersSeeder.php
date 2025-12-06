<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $officerRole = Role::firstOrCreate(['name' => 'officer'], ['guard_name' => 'web']);

        // Create admin user
        User::updateOrCreate([
            'email' => 'admin@cfpip.gov.bd'
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('admin456'),
            'role_id' => $adminRole->id,
            'is_active' => 1,
        ]);

        // Create officer user
        User::updateOrCreate([
            'email' => 'officer@cfpip.gov.bd'
        ], [
            'name' => 'Officer User',
            'password' => Hash::make('password123'),
            'role_id' => $officerRole->id,
            'is_active' => 1,
        ]);
    }
}
