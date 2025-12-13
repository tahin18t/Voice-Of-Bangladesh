<?php

namespace App\Repositories;

use App\Models\Assignment;

class AssignmentRepository extends BaseRepository
{
    protected function getModel()
    {
        return new Assignment();
    }

    /**
     * Get by feedback
     */
    public function getByFeedback($feedbackId)
    {
        return $this->model->where('feedback_id', $feedbackId)
            ->with(['feedback', 'assignedBy', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get by assigned officer
     */
    public function getByAssignedTo($userId, $perPage = 15)
    {
        return $this->model->where('assigned_to', $userId)
            ->with(['feedback', 'assignedBy', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get by assigned by
     */
    public function getByAssignedBy($userId, $perPage = 15)
    {
        return $this->model->where('assigned_by', $userId)
            ->with(['feedback', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get active assignments
     */
    public function getActive($perPage = 15)
    {
        return $this->model->where('status', 'active')
            ->with(['feedback', 'assignedTo', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get completed assignments
     */
    public function getCompleted($perPage = 15)
    {
        return $this->model->where('status', 'completed')
            ->with(['feedback', 'assignedTo', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get assignment count for user
     */
    public function getCountForUser($userId)
    {
        return $this->model->where('assigned_to', $userId)
            ->where('status', 'active')
            ->count();
    }
}
