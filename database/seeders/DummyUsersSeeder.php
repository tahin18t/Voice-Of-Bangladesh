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

        // Admin Users
        $admins = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@cfpip.gov.bd',
                'password' => 'admin456',
                'department' => 'IT & Administration',
            ],
            [
                'name' => 'Chief Administrator',
                'email' => 'chief.admin@cfpip.gov.bd',
                'password' => 'admin123',
                'department' => 'Central Administration',
            ],
        ];

        foreach ($admins as $adminData) {
            User::updateOrCreate(
                ['email' => $adminData['email']],
                [
                    'name' => $adminData['name'],
                    'password' => Hash::make($adminData['password']),
                    'role_id' => $adminRole->id,
                    'department' => $adminData['department'],
                    'is_active' => 1,
                ]
            );
        }

        // Officer Users
        $officers = [
            [
                'name' => 'Md. Rahman Ahmed',
                'email' => 'officer@cfpip.gov.bd',
                'password' => 'password123',
                'department' => 'Roads & Highways Ministry',
            ],
            [
                'name' => 'Fatema Begum',
                'email' => 'fatema.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Health & Family Welfare Ministry',
            ],
            [
                'name' => 'Kamal Hossain',
                'email' => 'kamal.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Education Ministry',
            ],
            [
                'name' => 'Sharmin Akter',
                'email' => 'sharmin.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Water Resources Ministry',
            ],
            [
                'name' => 'Abdul Karim',
                'email' => 'abdul.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Environment Ministry',
            ],
            [
                'name' => 'Nasrin Sultana',
                'email' => 'nasrin.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Urban Development',
            ],
            [
                'name' => 'Rafiq Islam',
                'email' => 'rafiq.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Agriculture Ministry',
            ],
            [
                'name' => 'Ayesha Rahman',
                'email' => 'ayesha.officer@cfpip.gov.bd',
                'password' => 'officer123',
                'department' => 'Transport Authority',
            ],
        ];

        foreach ($officers as $officerData) {
            User::updateOrCreate(
                ['email' => $officerData['email']],
                [
                    'name' => $officerData['name'],
                    'password' => Hash::make($officerData['password']),
                    'role_id' => $officerRole->id,
                    'department' => $officerData['department'],
                    'is_active' => 1,
                ]
            );
        }

        $this->command->info('✓ Created ' . count($admins) . ' admin users');
        $this->command->info('✓ Created ' . count($officers) . ' officer users');
        $this->command->info('✓ Total users seeded: ' . (count($admins) + count($officers)));
    }
}
