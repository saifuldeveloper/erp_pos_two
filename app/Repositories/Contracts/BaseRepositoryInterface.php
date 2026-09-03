<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get paginated records.
     *
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator;

    /**
     * Find record by ID.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function find($id, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * Find record by ID or throw Exception.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @return Model
     */
    public function findOrFail($id, array $columns = ['*'], array $relations = []): Model;

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * Update a record by ID.
     *
     * @param int|string $id
     * @param array $attributes
     * @return Model|bool
     */
    public function update($id, array $attributes);

    /**
     * Delete a record by ID.
     *
     * @param int|string $id
     * @return bool|null
     */
    public function delete($id);

    /**
     * Get active records (where is_active = true).
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getActive(array $columns = ['*'], array $relations = []): Collection;
}
