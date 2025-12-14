<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DummyAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get officer role
        $officerRole = Role::where('name', 'officer')->first();
        if (!$officerRole) {
            $this->command->warn('Officer role not found. Skipping assignment seeding.');
            return;
        }

        // Get officer users
        $officers = User::where('role_id', $officerRole->id)->get();
        if ($officers->isEmpty()) {
            $this->command->warn('No officers found. Skipping assignment seeding.');
            return;
        }

        // Get some feedbacks to assign
        $feedbacks = Feedback::where('status', 'pending')->limit(5)->get();

        foreach ($feedbacks as $feedback) {
            // Assign to random officer
            $officer = $officers->random();

            Assignment::updateOrCreate(
                [
                    'feedback_id' => $feedback->id,
                    'assigned_to' => $officer->id,
                ],
                [
                    'assigned_by' => 1, // Admin user
                    'note' => "Assigned for investigation and follow-up action",
                    'status' => 'assigned',
                ]
            );

            // Update feedback status to assigned
            $feedback->update([
                'assigned_to' => $officer->id,
                'status' => 'assigned',
            ]);
        }

        $this->command->info('Dummy assignments seeded successfully!');
    }
}
