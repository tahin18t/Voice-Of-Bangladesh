<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();
        $user->last_login_at = now();
        $user->save();
        $user->load('role');

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'department' => $user->department,
                'avatar' => $user->avatar,
                'role' => $user->role ? [
                    'id' => $user->role->id,
                    'name' => $user->role->name
                ] : null
            ],
            'role' => $user->role ? $user->role->name : null,
            'redirect' => $user->role ? match($user->role->name) {
                'admin' => '/admin-dashboard',
                'officer' => '/officer-dashboard',
                'citizen' => '/citizen-dashboard',
                default => '/officer-dashboard'
            } : '/officer-dashboard'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials'
    ], 401);
})->name('login.post');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['success' => true, 'message' => 'Logged out successfully']);
})->middleware('auth')->name('logout');

// Protected dashboard routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/officer-dashboard', function () {
        $user = Auth::user();
        $user->load('role');

        // Redirect if wrong dashboard
        if ($user->role && $user->role->name === 'admin') {
            return redirect('/admin-dashboard');
        } elseif ($user->role && $user->role->name === 'citizen') {
            return redirect('/citizen-dashboard');
        }

        return view('officer-dashboard');
    })->name('officer.dashboard');

    Route::get('/admin-dashboard', function () {
        $user = Auth::user();
        $user->load('role');

        // Check admin access
        if (!$user->role || $user->role->name !== 'admin') {
            return redirect('/officer-dashboard');
        }

        return view('officer-dashboard');
    })->name('admin.dashboard');

    Route::get('/citizen-dashboard', function () {
        $user = Auth::user();
        $user->load('role');

        // Redirect if wrong dashboard
        if ($user->role && $user->role->name === 'admin') {
            return redirect('/admin-dashboard');
        } elseif ($user->role && $user->role->name === 'officer') {
            return redirect('/officer-dashboard');
        }

        return view('officer-dashboard');
    })->name('citizen.dashboard');

    // Dashboard data API endpoint
    Route::get('/api/dashboard/stats', function () {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user->load('role');

        $stats = [];

        if ($user->role && $user->role->name === 'admin') {
            // Admin sees all statistics
            $stats = [
                'total_feedback' => \App\Models\Feedback::count(),
                'pending_feedback' => \App\Models\Feedback::where('status', 'pending')->count(),
                'in_progress' => \App\Models\Feedback::where('status', 'in-progress')->count(),
                'resolved' => \App\Models\Feedback::where('status', 'resolved')->count(),
                'total_users' => \App\Models\User::count(),
                'active_officers' => \App\Models\User::whereHas('role', function($q) {
                    $q->where('name', 'officer');
                })->where('is_active', true)->count(),
                'avg_response_time' => \App\Models\Feedback::where('status', 'resolved')
                    ->selectRaw('AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) as avg_days')
                    ->value('avg_days') ?? 0,
                'satisfaction_rate' => 85,
                'resolved_today' => \App\Models\Feedback::where('status', 'resolved')
                    ->whereDate('updated_at', today())->count(),
            ];
        } else {
            // Officers see their assigned feedback statistics
            $stats = [
                'total_feedback' => \App\Models\Feedback::count(),
                'pending_feedback' => \App\Models\Feedback::where('status', 'pending')->count(),
                'in_progress' => \App\Models\Feedback::where('status', 'in-progress')->count(),
                'resolved' => \App\Models\Feedback::where('status', 'resolved')->count(),
                'assigned_to_me' => \App\Models\Feedback::where('assigned_to', $user->id)->count(),
                'avg_response_time' => \App\Models\Feedback::where('status', 'resolved')
                    ->selectRaw('AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) as avg_days')
                    ->value('avg_days') ?? 0,
                'satisfaction_rate' => 85,
                'resolved_today' => \App\Models\Feedback::where('status', 'resolved')
                    ->whereDate('updated_at', today())->count(),
            ];
        }

        return response()->json(['success' => true, 'stats' => $stats]);
    })->name('dashboard.stats');

    // Recent feedback endpoint
    Route::get('/api/dashboard/recent-feedback', function () {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user->load('role');

        $query = \App\Models\Feedback::with(['reporter'])
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($user->role && $user->role->name !== 'admin') {
            // Officers see their assigned feedbacks
            $query->where('assigned_to', $user->id);
        }

        $feedbacks = $query->get();

        return response()->json(['success' => true, 'feedbacks' => $feedbacks]);
    })->name('dashboard.recent-feedback');

    // All feedbacks endpoint with pagination and filters
    Route::get('/api/feedbacks', function (\Illuminate\Http\Request $request) {
        $user = Auth::user();
        $user->load('role');

        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');
        $priority = $request->input('priority');
        $category = $request->input('category');
        $search = $request->input('search');

        $query = \App\Models\Feedback::with(['reporter'])
            ->orderBy('created_at', 'desc');

        // Role-based filtering
        if ($user->role && $user->role->name !== 'admin') {
            // Officers see their assigned feedbacks
            $query->where('assigned_to', $user->id);
        }

        // Apply filters
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($priority && $priority !== 'all') {
            $query->where('priority', $priority);
        }

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                  ->orWhere('description', 'like', '%'.$search.'%')
                  ->orWhere('tracking_id', 'like', '%'.$search.'%');
            });
        }

        $feedbacks = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'feedbacks' => $feedbacks->items(),
            'pagination' => [
                'total' => $feedbacks->total(),
                'per_page' => $feedbacks->perPage(),
                'current_page' => $feedbacks->currentPage(),
                'last_page' => $feedbacks->lastPage(),
                'from' => $feedbacks->firstItem(),
                'to' => $feedbacks->lastItem()
            ]
        ]);
    })->name('api.feedbacks.index');

    // Update feedback status endpoint
    Route::put('/api/feedbacks/{id}/status', function (\Illuminate\Http\Request $request, $id) {
        $user = Auth::user();
        $user->load('role');

        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,resolved,closed'
        ]);

        $feedback = \App\Models\Feedback::findOrFail($id);

        // Check permission - admin or assigned officer can update
        if ($user->role && $user->role->name !== 'admin' && $feedback->assigned_to !== $user->id) {
            return response()->json(['success' => false, 'message' => 'You can only update feedback assigned to you'], 403);
        }

        $oldStatus = $feedback->status;
        $feedback->status = $validated['status'];
        $feedback->save();

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => "Updated feedback #{$feedback->tracking_id} status from {$oldStatus} to {$validated['status']}",
            'model_type' => 'Feedback',
            'model_id' => $feedback->id,
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback status updated successfully',
            'feedback' => $feedback->load(['user', 'aiInsights'])
        ]);
    })->name('api.feedbacks.update-status');

    // Get single feedback details
    Route::get('/api/feedbacks/{id}', function ($id) {
        $user = Auth::user();
        $user->load('role');

        $feedback = \App\Models\Feedback::with(['reporter', 'assignee', 'aiInsight'])->findOrFail($id);

        // Check permission - admin can view all, officers can view their assigned ones
        if ($user->role && $user->role->name !== 'admin' && $feedback->assigned_to !== $user->id) {
            // Allow viewing if no one is assigned yet (for assignment purposes)
            if ($feedback->assigned_to !== null) {
                return response()->json(['success' => false, 'message' => 'You can only view feedback assigned to you'], 403);
            }
        }

        return response()->json($feedback);
    })->name('api.feedbacks.show');

    // Update feedback status endpoint
    Route::post('/api/feedbacks/{id}/status', function (\Illuminate\Http\Request $request, $id) {
        $user = Auth::user();
        $user->load('role');

        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,resolved,rejected',
            'comment' => 'nullable|string|max:1000'
        ]);

        $feedback = \App\Models\Feedback::findOrFail($id);

        // Check permission - admin or assigned officer can update
        if ($user->role && $user->role->name !== 'admin' && $feedback->assigned_to !== $user->id) {
            return response()->json(['success' => false, 'message' => 'You can only update feedback assigned to you'], 403);
        }

        $oldStatus = $feedback->status;
        $feedback->status = $validated['status'];
        $feedback->save();

        // Log activity with comment if provided
        $description = "Updated feedback #{$feedback->tracking_id} status from {$oldStatus} to {$validated['status']}";
        if (!empty($validated['comment'])) {
            $description .= ". Comment: {$validated['comment']}";
        }

        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'status_update',
            'description' => $description,
            'subject_type' => 'App\\Models\\Feedback',
            'subject_id' => $feedback->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback status updated successfully',
            'feedback' => $feedback->load(['reporter', 'assignee'])
        ]);
    })->name('api.feedbacks.update-status');

    // Assign feedback endpoint
    Route::post('/api/feedbacks/{id}/assign', function (\Illuminate\Http\Request $request, $id) {
        $user = Auth::user();
        $user->load('role');

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'note' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'deadline' => 'nullable|date'
        ]);

        $feedback = \App\Models\Feedback::findOrFail($id);

        // Only admin can assign
        if ($user->role && $user->role->name !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Only admins can assign feedback'], 403);
        }

        // Create assignment record
        $assignment = \App\Models\Assignment::create([
            'feedback_id' => $feedback->id,
            'assigned_by' => $user->id,
            'assigned_to' => $validated['assigned_to'],
            'note' => $validated['note'] ?? null,
            'status' => 'assigned',
        ]);

        // Update feedback
        $feedback->assigned_to = $validated['assigned_to'];
        $feedback->status = 'in-progress';

        if (isset($validated['priority'])) {
            $feedback->priority = $validated['priority'];
        }

        $feedback->save();

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'feedback_assigned',
            'description' => "Feedback #{$feedback->tracking_id} assigned to user ID: {$validated['assigned_to']}",
            'subject_type' => 'App\\Models\\Feedback',
            'subject_id' => $feedback->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback assigned successfully',
            'assignment' => $assignment,
            'feedback' => $feedback->load(['reporter', 'assignee'])
        ]);
    })->name('api.feedbacks.assign');

    // Get users for assignment dropdown (admin only)
    Route::get('/api/users', function () {
        $user = Auth::user();
        $user->load('role');

        // Only admin can view users
        if ($user->role && $user->role->name !== 'admin') {
            // Return only officers for non-admins
            $users = \App\Models\User::with('role')
                ->whereHas('role', function($q) {
                    $q->whereIn('name', ['officer', 'staff']);
                })
                ->where('is_active', true)
                ->get();

            return response()->json($users);
        }

        // Admin gets all active users
        $users = \App\Models\User::with('role')
            ->where('is_active', true)
            ->get();

        return response()->json($users);
    })->name('api.users.index');

    // Notifications endpoint
    Route::get('/api/dashboard/notifications', function () {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $notifications = \App\Models\NotificationEntry::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unreadCount = \App\Models\NotificationEntry::where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    })->name('dashboard.notifications');

    // Activity logs endpoint
    Route::get('/api/dashboard/activity-logs', function () {
        $user = Auth::user();
        $user->load('role');

        $query = \App\Models\ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20);

        if ($user->role && $user->role->name !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $activityLogs = $query->get();

        return response()->json(['success' => true, 'activity_logs' => $activityLogs]);
    })->name('dashboard.activity-logs');

    // Analytics endpoint for charts
    Route::get('/api/dashboard/analytics', function () {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user->load('role');

        // Last 7 days feedback trend
        $feedbackTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $query = \App\Models\Feedback::whereDate('created_at', $date);

            if ($user->role && $user->role->name !== 'admin') {
                // Officers see their assigned feedbacks
                $query->where('assigned_to', $user->id);
            }

            $feedbackTrend[] = [
                'date' => $date->format('M d'),
                'count' => $query->count()
            ];
        }

        // Category distribution
        $categoryQuery = \App\Models\Feedback::selectRaw('category, COUNT(*) as count')
            ->groupBy('category');

        if ($user->role && $user->role->name !== 'admin') {
            $categoryQuery->where('assigned_to', $user->id);
        }

        $categoryData = $categoryQuery->get();

        // Status distribution
        $statusQuery = \App\Models\Feedback::selectRaw('status, COUNT(*) as count')
            ->groupBy('status');

        if ($user->role && $user->role->name !== 'admin') {
            $statusQuery->where('assigned_to', $user->id);
        }

        $statusData = $statusQuery->get();

        // Priority distribution
        $priorityQuery = \App\Models\Feedback::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority');

        if ($user->role && $user->role->name !== 'admin') {
            $priorityQuery->where('assigned_to', $user->id);
        }

        $priorityData = $priorityQuery->get();

        return response()->json([
            'success' => true,
            'trend' => $feedbackTrend,
            'categories' => $categoryData,
            'status' => $statusData,
            'priority' => $priorityData
        ]);
    })->name('dashboard.analytics');

    // AI Insights endpoint
    Route::get('/api/dashboard/ai-insights', function () {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user->load('role');

        $query = \App\Models\AiInsight::with('feedback')
            ->orderBy('created_at', 'desc')
            ->limit(5);

        if ($user->role && $user->role->name !== 'admin') {
            $query->whereHas('feedback', function($q) use ($user) {
                $q->where('assigned_to', $user->id);
            });
        }

        $insights = $query->get();

        return response()->json(['success' => true, 'insights' => $insights]);
    })->name('dashboard.ai-insights');
});
Route::get('/submit-feedback', function () {
    return view('submit-feedback');
});

Route::get('/track', function () {
    return view('track');
});


Route::get('/public-insights', function () {
    return view('index');
});
