<?php

namespace App\Services;

use App\Models\Feedback;
use App\Models\User;
use App\Models\AiInsight;
use App\Models\Assignment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class FeedbackService
{
    /**
     * Get all feedbacks with optional filters
     */
    public function getAllFeedbacks($filters = [], $perPage = 15)
    {
        $query = Feedback::query();

        // Filter by status
        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Filter by category
        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        // Filter by priority
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        // Filter by tracking_id
        if (isset($filters['tracking_id'])) {
            $query->where('tracking_id', 'like', '%' . $filters['tracking_id'] . '%');
        }

        // Filter by assigned status
        if (isset($filters['assigned']) && $filters['assigned'] === true) {
            $query->whereNotNull('assigned_to');
        }

        // Include relationships
        $query->with(['assignee:id,name,email', 'aiInsight', 'reporter:id,name,email']);

        // Order by recent first
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get feedback by ID
     */
    public function getFeedbackById($id)
    {
        return Feedback::with(['assignee', 'aiInsight', 'reporter', 'assignments'])
            ->findOrFail($id);
    }

    /**
     * Get feedback by tracking ID
     */
    public function getFeedbackByTrackingId($trackingId)
    {
        return Feedback::where('tracking_id', $trackingId)
            ->with(['assignee', 'aiInsight', 'reporter', 'assignments'])
            ->first();
    }

    /**
     * Create new feedback
     */
    public function createFeedback($data, $userId = null)
    {
        // Generate unique tracking ID
        $trackingId = $this->generateTrackingId();

        $feedbackData = [
            'tracking_id' => $trackingId,
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'] ?? 'general',
            'priority' => $data['priority'] ?? 'medium',
            'location' => $data['location'] ?? null,
            'status' => 'pending',
            'user_id' => $userId,
            'attachments' => $this->handleAttachments($data['attachments'] ?? null),
        ];

        $feedback = Feedback::create($feedbackData);

        // Trigger AI analysis via job
        \App\Jobs\AnalyzeFeedbackJob::dispatch($feedback);

        return $feedback->load(['aiInsight', 'reporter']);
    }

    /**
     * Update feedback
     */
    public function updateFeedback($id, $data)
    {
        $feedback = Feedback::findOrFail($id);

        $updateData = [];
        if (isset($data['title'])) $updateData['title'] = $data['title'];
        if (isset($data['description'])) $updateData['description'] = $data['description'];
        if (isset($data['category'])) $updateData['category'] = $data['category'];
        if (isset($data['priority'])) $updateData['priority'] = $data['priority'];
        if (isset($data['location'])) $updateData['location'] = $data['location'];

        $feedback->update($updateData);

        return $feedback->load(['aiInsight', 'assignee']);
    }

    /**
     * Assign feedback to officer
     */
    public function assignFeedback($feedbackId, $assignedToUserId, $note = '', $assignedByUserId = null)
    {
        $feedback = Feedback::findOrFail($feedbackId);

        // Update feedback assignment
        $feedback->update([
            'assigned_to' => $assignedToUserId,
            'status' => 'assigned'
        ]);

        // Create assignment record for audit trail
        Assignment::create([
            'feedback_id' => $feedbackId,
            'assigned_by' => $assignedByUserId,
            'assigned_to' => $assignedToUserId,
            'note' => $note,
            'status' => 'active'
        ]);

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => $assignedByUserId,
            'type' => 'assigned_feedback',
            'subject_type' => 'Feedback',
            'subject_id' => $feedbackId,
            'message' => "Feedback assigned to user {$assignedToUserId}",
            'meta' => ['note' => $note]
        ]);

        return $feedback->load(['assignee', 'assignments']);
    }

    /**
     * Update feedback status
     */
    public function updateFeedbackStatus($id, $status)
    {
        $feedback = Feedback::findOrFail($id);

        $validStatuses = ['pending', 'assigned', 'in_progress', 'resolved', 'closed'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException("Invalid status: {$status}");
        }

        $feedback->update(['status' => $status]);

        return $feedback;
    }

    /**
     * Get feedback statistics
     */
    public function getStatistics()
    {
        return [
            'total' => Feedback::count(),
            'pending' => Feedback::where('status', 'pending')->count(),
            'assigned' => Feedback::where('status', 'assigned')->count(),
            'in_progress' => Feedback::where('status', 'in_progress')->count(),
            'resolved' => Feedback::where('status', 'resolved')->count(),
            'closed' => Feedback::where('status', 'closed')->count(),
        ];
    }

    /**
     * Generate unique tracking ID
     */
    private function generateTrackingId()
    {
        do {
            $trackingId = 'CFPIP-' . date('Y') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Feedback::where('tracking_id', $trackingId)->exists());

        return $trackingId;
    }

    /**
     * Handle file attachments
     */
    private function handleAttachments($files)
    {
        if (!$files) return null;

        $attachments = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                if ($file->isValid()) {
                    $path = $file->store('feedbacks', 'public');
                    $attachments[] = [
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
            }
        }

        return !empty($attachments) ? $attachments : null;
    }
}
