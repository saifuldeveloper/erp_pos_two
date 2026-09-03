<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Get paginated records.
     *
     * @param int $perPage
     * @param array $columns
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator
    {
        return $this->model->with($relations)->paginate($perPage, $columns);
    }

    /**
     * Find record by ID.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @return Model|null
     */
    public function find($id, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->with($relations)->find($id, $columns);
    }

    /**
     * Find record by ID or throw Exception.
     *
     * @param int|string $id
     * @param array $columns
     * @param array $relations
     * @return Model
     */
    public function findOrFail($id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->model->with($relations)->findOrFail($id, $columns);
    }

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * Update a record by ID.
     *
     * @param int|string $id
     * @param array $attributes
     * @return Model|bool
     */
    public function update($id, array $attributes)
    {
        $record = $this->findOrFail($id);
        $record->update($attributes);
        return $record;
    }

    /**
     * Delete a record by ID.
     *
     * @param int|string $id
     * @return bool|null
     */
    public function delete($id)
    {
        $record = $this->findOrFail($id);
        return $record->delete();
    }

    /**
     * Get active records (where is_active = true).
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function getActive(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->where('is_active', true)->get($columns);
    }
}
