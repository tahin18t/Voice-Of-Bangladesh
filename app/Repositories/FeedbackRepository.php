<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository extends BaseRepository
{
    protected function getModel()
    {
        return new Feedback();
    }

    /**
     * Get feedbacks with filters
     */
    public function getWithFilters($filters = [], $perPage = 15)
    {
        $query = $this->model->query();

        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (isset($filters['tracking_id'])) {
            $query->where('tracking_id', 'like', '%' . $filters['tracking_id'] . '%');
        }

        if (isset($filters['assigned']) && $filters['assigned'] === true) {
            $query->whereNotNull('assigned_to');
        }

        $query->with(['assignee', 'reporter', 'aiInsight']);
        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get by tracking ID
     */
    public function getByTrackingId($trackingId)
    {
        return $this->model->where('tracking_id', $trackingId)
            ->with(['assignee', 'reporter', 'aiInsight', 'assignments'])
            ->first();
    }

    /**
     * Get by user
     */
    public function getByUser($userId, $perPage = 15)
    {
        return $this->model->where('user_id', $userId)
            ->with(['assignee', 'aiInsight'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get assigned to officer
     */
    public function getAssignedToOfficer($officerId, $perPage = 15)
    {
        return $this->model->where('assigned_to', $officerId)
            ->with(['reporter', 'aiInsight'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get by status
     */
    public function getByStatus($status, $perPage = 15)
    {
        return $this->model->where('status', $status)
            ->with(['assignee', 'reporter'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get recent feedbacks
     */
    public function getRecent($limit = 10)
    {
        return $this->model->with(['reporter', 'assignee', 'aiInsight'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get pending feedbacks
     */
    public function getPending($perPage = 15)
    {
        return $this->model->where('status', 'pending')
            ->with(['reporter', 'aiInsight'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Count by status
     */
    public function countByStatus($status = null)
    {
        if ($status) {
            return $this->model->where('status', $status)->count();
        }

        return $this->model->count();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        return [
            'total' => $this->model->count(),
            'pending' => $this->model->where('status', 'pending')->count(),
            'assigned' => $this->model->where('status', 'assigned')->count(),
            'in_progress' => $this->model->where('status', 'in_progress')->count(),
            'resolved' => $this->model->where('status', 'resolved')->count(),
            'closed' => $this->model->where('status', 'closed')->count(),
        ];
    }
}
