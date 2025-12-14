<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Assignment;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Jobs\AnalyzeFeedbackJob;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $feedbacks = $query->latest()->paginate(15);
        return response()->json($feedbacks);
    }

    public function store(StoreFeedbackRequest $request)
    {
        $data = $request->validated();
        $data['tracking_id'] = $data['tracking_id'] ?? 'FB-'.time();
        $feedback = Feedback::create($data);

        // Dispatch AI analysis job
        AnalyzeFeedbackJob::dispatch($feedback);

        return response()->json($feedback, 201);
    }

    public function show($id)
    {
        $feedback = Feedback::with(['aiInsight', 'assignments', 'reporter', 'assignee'])->findOrFail($id);
        return response()->json($feedback);
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update($request->validated());
        return response()->json($feedback);
    }

    public function assign(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'note' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'deadline' => 'nullable|date'
        ]);

        $assignment = Assignment::create([
            'feedback_id' => $feedback->id,
            'assigned_by' => $request->user() ? $request->user()->id : null,
            'assigned_to' => $request->assigned_to,
            'note' => $request->note,
            'status' => 'assigned',
        ]);

        $feedback->assigned_to = $request->assigned_to;
        $feedback->status = 'in-progress';

        // Update priority if provided
        if ($request->priority) {
            $feedback->priority = $request->priority;
        }

        $feedback->save();

        // Log the assignment activity
        \App\Models\ActivityLog::create([
            'user_id' => $request->user() ? $request->user()->id : null,
            'action' => 'feedback_assigned',
            'description' => "Feedback assigned to user ID: {$request->assigned_to}",
            'subject_type' => 'App\\Models\\Feedback',
            'subject_id' => $feedback->id,
        ]);

        return response()->json([
            'success' => true,
            'assignment' => $assignment,
            'feedback' => $feedback->load('assignee')
        ], 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,in-progress,resolved,rejected',
            'comment' => 'nullable|string|max:1000'
        ]);

        $feedback->status = $request->status;

        // If comment is provided, you might want to save it somewhere
        // For now, we'll just log it or you can add a comments table
        if ($request->comment) {
            // Option 1: Add to activity log
            \App\Models\ActivityLog::create([
                'user_id' => $request->user() ? $request->user()->id : null,
                'action' => 'status_update',
                'description' => "Status changed to {$request->status}. Comment: {$request->comment}",
                'subject_type' => 'App\\Models\\Feedback',
                'subject_id' => $feedback->id,
            ]);
        }

        $feedback->save();

        return response()->json(['success' => true, 'feedback' => $feedback]);
    }

    public function track($tracking_id)
    {
        $feedback = Feedback::where('tracking_id', $tracking_id)
            ->with('aiInsight', 'assignments')
            ->first();

        if (!$feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json($feedback);
    }
}
