<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed a basic role and admin user
        $role = \App\Models\Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);

        // Ensure an admin@example.com user exists (idempotent)
        \App\Models\User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin User',
            'role_id' => $role->id,
            'password' => bcrypt('admin123')
        ]);

        // Run all seeders
        $this->call(DummyUsersSeeder::class);
        $this->call(DummyFeedbackSeeder::class);
        $this->call(DummyAssignmentSeeder::class);
    }
}
