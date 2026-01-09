<?php

namespace App\Services;

use App\Models\NotificationEntry;
use App\Models\User;

class NotificationService
{
    /**
     * Get notifications for user
     */
    public function getNotifications($userId, $perPage = 20)
    {
        return NotificationEntry::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount($userId)
    {
        return NotificationEntry::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Create notification
     */
    public function createNotification($userId, $type, $data = [])
    {
        return NotificationEntry::create([
            'user_id' => $userId,
            'type' => $type,
            'data' => $data,
        ]);
    }

    /**
     * Mark as read
     */
    public function markAsRead($notificationId)
    {
        $notification = NotificationEntry::findOrFail($notificationId);
        $notification->update(['read_at' => now()]);

        return $notification;
    }

    /**
     * Mark all as read for user
     */
    public function markAllAsRead($userId)
    {
        return NotificationEntry::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Delete notification
     */
    public function deleteNotification($notificationId)
    {
        return NotificationEntry::destroy($notificationId);
    }

    /**
     * Notify feedback assignment
     */
    public function notifyFeedbackAssigned($feedbackId, $userId, $feedback)
    {
        $this->createNotification(
            $userId,
            'feedback_assigned',
            [
                'feedback_id' => $feedbackId,
                'title' => 'New Feedback Assignment',
                'message' => "Feedback #{$feedback->tracking_id} has been assigned to you",
                'category' => $feedback->category,
                'priority' => $feedback->priority,
            ]
        );
    }

    /**
     * Notify feedback status changed
     */
    public function notifyFeedbackStatusChanged($feedbackId, $userId, $oldStatus, $newStatus, $feedback)
    {
        $this->createNotification(
            $userId,
            'feedback_status_changed',
            [
                'feedback_id' => $feedbackId,
                'title' => 'Feedback Status Updated',
                'message' => "Feedback #{$feedback->tracking_id} status changed from {$oldStatus} to {$newStatus}",
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]
        );
    }

    /**
     * Notify feedback resolved
     */
    public function notifyFeedbackResolved($feedbackId, $userId, $feedback)
    {
        $this->createNotification(
            $userId,
            'feedback_resolved',
            [
                'feedback_id' => $feedbackId,
                'title' => 'Feedback Resolved',
                'message' => "Thank you! Your feedback #{$feedback->tracking_id} has been resolved.",
                'category' => $feedback->category,
            ]
        );
    }

    /**
     * Notify AI insights generated
     */
    public function notifyAiInsightGenerated($feedbackId, $userId, $feedback, $aiInsight)
    {
        $this->createNotification(
            $userId,
            'ai_insight_generated',
            [
                'feedback_id' => $feedbackId,
                'title' => 'AI Analysis Complete',
                'message' => "AI analysis for feedback #{$feedback->tracking_id} is ready",
                'urgency_score' => $aiInsight->urgency_score,
                'suggested_action' => $aiInsight->suggested_action,
            ]
        );
    }
}
