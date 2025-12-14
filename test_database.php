<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Feedback;
use App\Models\Role;
use App\Models\AiInsight;
use App\Models\Assignment;
use App\Services\AuthService;
use App\Services\FeedbackService;
use App\Services\UserService;

echo "\n========== DATABASE VERIFICATION TESTS ==========\n\n";

// Test 1: Check users
echo "TEST 1: Users Table\n";
echo "-------------------\n";
$users = User::with('role')->get();
echo "Total users: " . $users->count() . "\n";
foreach($users as $user) {
    echo "- " . $user->email . " (Role: " . $user->role->name . ", Active: " . ($user->is_active ? 'Yes' : 'No') . ")\n";
}

// Test 2: Check roles
echo "\n\nTEST 2: Roles Table\n";
echo "-------------------\n";
$roles = Role::all();
echo "Total roles: " . $roles->count() . "\n";
foreach($roles as $role) {
    echo "- " . $role->name . "\n";
}

// Test 3: Check feedbacks
echo "\n\nTEST 3: Feedbacks Table\n";
echo "-------------------\n";
$feedbacks = Feedback::with('reporter', 'aiInsight')->get();
echo "Total feedbacks: " . $feedbacks->count() . "\n";
echo "Sample feedbacks:\n";
foreach($feedbacks->take(3) as $fb) {
    echo "- " . $fb->tracking_id . ": " . $fb->title . "\n";
    echo "  Status: " . $fb->status . ", Priority: " . $fb->priority . ", Category: " . $fb->category . "\n";
}

// Test 4: Check AI insights
echo "\n\nTEST 4: AI Insights Table\n";
echo "-------------------\n";
$insights = AiInsight::all();
echo "Total AI insights: " . $insights->count() . "\n";
if($insights->count() > 0) {
    $sample = $insights->first();
    echo "Sample insight:\n";
    echo "- Confidence: " . $sample->confidence_score . "%\n";
    echo "- Urgency: " . $sample->urgency_score . "%\n";
}

// Test 5: Check assignments
echo "\n\nTEST 5: Assignments Table\n";
echo "-------------------\n";
$assignments = Assignment::with('feedback', 'assignee')->get();
echo "Total assignments: " . $assignments->count() . "\n";
if($assignments->count() > 0) {
    foreach($assignments->take(3) as $assign) {
        echo "- Feedback " . $assign->feedback->tracking_id . " → " . $assign->assignee->name . "\n";
    }
}

// Test 6: Test Login
echo "\n\nTEST 6: Authentication Service\n";
echo "-------------------\n";
$authService = app(AuthService::class);

try {
    $result = $authService->login('admin@cfpip.gov.bd', 'admin456');
    echo "✓ Admin login successful\n";
    echo "  User: " . $result['user']->name . "\n";
    echo "  Token: " . substr($result['token'], 0, 20) . "...\n";
    echo "  Message: " . $result['message'] . "\n";
} catch(\Exception $e) {
    echo "✗ Admin login failed: " . $e->getMessage() . "\n";
}

try {
    $result = $authService->login('officer@cfpip.gov.bd', 'password123');
    echo "✓ Officer login successful\n";
    echo "  User: " . $result['user']->name . "\n";
} catch(\Exception $e) {
    echo "✗ Officer login failed: " . $e->getMessage() . "\n";
}

try {
    $result = $authService->login('citizen@cfpip.gov.bd', 'password123');
    echo "✓ Citizen login successful\n";
    echo "  User: " . $result['user']->name . "\n";
} catch(\Exception $e) {
    echo "✗ Citizen login failed: " . $e->getMessage() . "\n";
}

// Test 7: Wrong password
echo "\nTest wrong password:\n";
try {
    $authService->login('admin@cfpip.gov.bd', 'wrongpassword');
    echo "✗ ERROR: Should have rejected wrong password\n";
} catch(\Exception $e) {
    echo "✓ Correctly rejected: " . $e->getMessage() . "\n";
}

// Test 8: Feedback Service
echo "\n\nTEST 7: Feedback Service\n";
echo "-------------------\n";
$feedbackService = app(FeedbackService::class);
$stats = $feedbackService->getStatistics();
echo "Feedback Statistics:\n";
foreach($stats as $status => $count) {
    echo "- " . ucfirst(str_replace('_', ' ', $status)) . ": " . $count . "\n";
}

// Test 9: Get feedback by tracking ID
echo "\nTest tracking ID lookup:\n";
$trackingId = $feedbacks->first()->tracking_id;
$feedback = $feedbackService->getFeedbackByTrackingId($trackingId);
if($feedback) {
    echo "✓ Found feedback by tracking ID: " . $trackingId . "\n";
    echo "  Title: " . $feedback->title . "\n";
} else {
    echo "✗ Could not find feedback with tracking ID: " . $trackingId . "\n";
}

// Test 10: User Service
echo "\n\nTEST 8: User Service\n";
echo "-------------------\n";
$userService = app(UserService::class);
$userStats = $userService->getStatistics();
echo "User Statistics:\n";
foreach($userStats as $type => $count) {
    echo "- " . ucfirst(str_replace('_', ' ', $type)) . ": " . $count . "\n";
}

// Test 11: Get officers
echo "\nOfficers in system:\n";
$officers = User::whereHas('role', function($q) {
    $q->where('name', 'officer');
})->get();
foreach($officers as $officer) {
    echo "- " . $officer->name . " (" . $officer->email . ")\n";
}

echo "\n========== ALL TESTS COMPLETED SUCCESSFULLY ==========\n";
?>
