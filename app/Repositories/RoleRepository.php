<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    protected function getModel()
    {
        return new Role();
    }

    /**
     * Get by name
     */
    public function getByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * Get all with user count
     */
    public function getAllWithCount()
    {
        return $this->model->withCount('users')->get();
    }

    /**
     * Get default roles
     */
    public function getDefaultRoles()
    {
        return [
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'officer'],
            ['id' => 3, 'name' => 'citizen'],
        ];
    }
}
