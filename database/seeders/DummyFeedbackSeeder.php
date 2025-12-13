<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use App\Models\Role;
use App\Models\AiInsight;
use Illuminate\Database\Seeder;

class DummyFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create citizen role if it doesn't exist
        $citizenRole = Role::firstOrCreate(['name' => 'citizen'], ['guard_name' => 'web']);

        // Get a citizen user
        $citizen = User::where('role_id', $citizenRole->id)->first();
        if (!$citizen) {
            $citizen = User::create([
                'name' => 'John Doe',
                'email' => 'citizen@cfpip.gov.bd',
                'password' => bcrypt('password123'),
                'role_id' => $citizenRole->id,
                'is_active' => true,
            ]);
        }

        // Sample feedback data
        $feedbacks = [
            [
                'title' => 'Garbage accumulation on Main Street',
                'description' => 'There is significant garbage accumulation near the market area on Main Street. It has been there for several days and is affecting the area aesthetically and hygienically.',
                'category' => 'sanitation',
                'priority' => 'high',
                'location' => 'Main Street, Market Area',
            ],
            [
                'title' => 'Pothole on Airport Road',
                'description' => 'There is a large pothole on Airport Road that is dangerous for vehicles. It needs immediate repair to prevent accidents.',
                'category' => 'infrastructure',
                'priority' => 'high',
                'location' => 'Airport Road, Sector 5',
            ],
            [
                'title' => 'Water supply disruption',
                'description' => 'Water supply has been disrupted in the residential area for more than 2 days. Residents are facing difficulty.',
                'category' => 'water',
                'priority' => 'critical',
                'location' => 'Green Valley Housing, Block A',
            ],
            [
                'title' => 'Traffic signal malfunction',
                'description' => 'The traffic signal at the intersection of Main Road and Elm Street is not functioning properly. This is causing traffic congestion.',
                'category' => 'traffic',
                'priority' => 'high',
                'location' => 'Main Road & Elm Street Junction',
            ],
            [
                'title' => 'Street light outage',
                'description' => 'Multiple street lights on Riverside Avenue are not working, making the area unsafe at night.',
                'category' => 'electricity',
                'priority' => 'medium',
                'location' => 'Riverside Avenue',
            ],
            [
                'title' => 'Noise pollution from construction',
                'description' => 'Construction work is ongoing near the residential area with excessive noise pollution at odd hours.',
                'category' => 'general',
                'priority' => 'medium',
                'location' => 'Park Lane, Near School',
            ],
            [
                'title' => 'Drainage system blockage',
                'description' => 'The drainage system on Garden Road is blocked, causing waterlogging during rainy season.',
                'category' => 'sanitation',
                'priority' => 'high',
                'location' => 'Garden Road, Sector 2',
            ],
            [
                'title' => 'Broken water pipe',
                'description' => 'There is a broken water pipe on Elm Street causing water wastage and flooding on the road.',
                'category' => 'water',
                'priority' => 'high',
                'location' => 'Elm Street, Block C',
            ],
            [
                'title' => 'Illegal parking obstruction',
                'description' => 'Vehicles are being parked illegally on the sidewalk, obstructing pedestrian movement.',
                'category' => 'traffic',
                'priority' => 'medium',
                'location' => 'Central Market Area',
            ],
            [
                'title' => 'Public park maintenance needed',
                'description' => 'The public park needs maintenance. Equipment is broken and the area is not clean.',
                'category' => 'general',
                'priority' => 'low',
                'location' => 'Central Park',
            ],
        ];

        // Create feedbacks
        foreach ($feedbacks as $feedbackData) {
            $feedback = Feedback::updateOrCreate(
                ['title' => $feedbackData['title']],
                [
                    'tracking_id' => 'CFPIP-' . date('Y') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
                    'user_id' => $citizen->id,
                    'description' => $feedbackData['description'],
                    'category' => $feedbackData['category'],
                    'priority' => $feedbackData['priority'],
                    'location' => $feedbackData['location'],
                    'status' => 'pending',
                ]
            );

            // Create AI insights for each feedback
            AiInsight::updateOrCreate(
                ['feedback_id' => $feedback->id],
                [
                    'summary' => substr($feedbackData['description'], 0, 200) . '...',
                    'confidence_score' => rand(70, 95),
                    'urgency_score' => $this->calculateUrgency($feedbackData['priority']),
                    'suggested_action' => $this->suggestAction($feedbackData),
                    'raw_payload' => [
                        'category' => $feedbackData['category'],
                        'priority' => $feedbackData['priority'],
                        'location' => $feedbackData['location'],
                    ],
                    'processed_at' => now(),
                ]
            );
        }

        $this->command->info('Dummy feedback data seeded successfully!');
    }

    /**
     * Calculate urgency score based on priority
     */
    private function calculateUrgency($priority)
    {
        return match($priority) {
            'critical' => 95,
            'high' => 75,
            'medium' => 50,
            'low' => 30,
            default => 40,
        };
    }

    /**
     * Suggest action based on feedback type
     */
    private function suggestAction($feedbackData)
    {
        $category = $feedbackData['category'];
        $priority = $feedbackData['priority'];

        $actions = [
            'sanitation' => [
                'critical' => 'Immediate emergency response required',
                'high' => 'Schedule cleanup within 24 hours',
                'medium' => 'Plan for next week',
                'low' => 'Monitor and include in routine',
            ],
            'infrastructure' => [
                'critical' => 'Emergency repair team dispatch',
                'high' => 'Urgent inspection and repair',
                'medium' => 'Schedule repair',
                'low' => 'Monitor condition',
            ],
            'water' => [
                'critical' => 'Emergency water dept response',
                'high' => 'Immediate investigation',
                'medium' => 'Schedule inspection',
                'low' => 'Monitor',
            ],
            'traffic' => [
                'critical' => 'Emergency traffic management',
                'high' => 'Urgent signal repair',
                'medium' => 'Schedule maintenance',
                'low' => 'Monitor',
            ],
            'electricity' => [
                'critical' => 'Emergency power restoration',
                'high' => 'Urgent repair needed',
                'medium' => 'Schedule for next week',
                'low' => 'Include in maintenance',
            ],
            'default' => 'Assign to relevant department for review and action',
        ];

        $categoryActions = $actions[$category] ?? $actions['default'];

        return is_array($categoryActions) ? ($categoryActions[$priority] ?? $categoryActions['medium']) : $categoryActions;
    }
}
