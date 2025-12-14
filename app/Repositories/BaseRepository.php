<?php

namespace App\Repositories;

/**
 * Base Repository class for common repository operations
 */
abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * Get model instance
     */
    abstract protected function getModel();

    /**
     * Get all records
     */
    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * Get all with pagination
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Find by ID
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find by ID or fail
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Create new record
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update($id, $data)
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        return $this->findOrFail($id)->delete();
    }

    /**
     * Get where condition
     */
    public function where($column, $operator, $value = null)
    {
        return $this->model->where($column, $operator, $value);
    }

    /**
     * First where
     */
    public function firstWhere($column, $operator = null, $value = null)
    {
        return $this->model->firstWhere($column, $operator, $value);
    }

    /**
     * Count records
     */
    public function count()
    {
        return $this->model->count();
    }
}
