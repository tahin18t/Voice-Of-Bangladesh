<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected function getModel()
    {
        return new User();
    }

    /**
     * Get with filters
     */
    public function getWithFilters($filters = [], $perPage = 15)
    {
        $query = $this->model->query();

        if (isset($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        if (isset($filters['active'])) {
            $query->where('is_active', $filters['active']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->with('role')->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get by email
     */
    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Get active users
     */
    public function getActive($perPage = 15)
    {
        return $this->model->where('is_active', true)
            ->with('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get by role
     */
    public function getByRole($roleId, $perPage = 15)
    {
        return $this->model->where('role_id', $roleId)
            ->with('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get officers
     */
    public function getOfficers($perPage = 15)
    {
        return $this->model->where('role_id', 2)
            ->where('is_active', true)
            ->with('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get citizens
     */
    public function getCitizens($perPage = 15)
    {
        return $this->model->where('role_id', 3)
            ->where('is_active', true)
            ->with('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get admins
     */
    public function getAdmins()
    {
        return $this->model->where('role_id', 1)->get();
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        return [
            'total' => $this->model->count(),
            'active' => $this->model->where('is_active', true)->count(),
            'inactive' => $this->model->where('is_active', false)->count(),
            'officers' => $this->model->where('role_id', 2)->count(),
            'citizens' => $this->model->where('role_id', 3)->count(),
            'admins' => $this->model->where('role_id', 1)->count(),
        ];
    }

    /**
     * Count by role
     */
    public function countByRole($roleId)
    {
        return $this->model->where('role_id', $roleId)->count();
    }
}
