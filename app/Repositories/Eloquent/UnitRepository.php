<?php

namespace App\Repositories\Eloquent;

use App\Models\Unit;
use App\Repositories\Contracts\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitRepository extends BaseRepository implements UnitRepositoryInterface
{
    /**
     * UnitRepository constructor.
     *
     * @param Unit $model
     */
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active units.
     *
     * @return Collection
     */
    public function getActiveUnits(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Find a unit by unit_code.
     *
     * @param string $unitCode
     * @return Unit|null
     */
    public function findByUnitCode(string $unitCode): ?Unit
    {
        return $this->model->where('unit_code', $unitCode)->first();
    }

    /**
     * Search units by unit name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByNamePaginated(string $name, int $perPage = 5): LengthAwarePaginator
    {
        return $this->model->where('unit_name', $name)->paginate($perPage);
    }

    /**
     * Deactivate a unit (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $unit = $this->findOrFail($id);
        $unit->is_active = false;
        return (bool) $unit->save();
    }

    /**
     * Deactivate multiple units by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool
    {
        return (bool) $this->model->whereIn('id', $ids)->update(['is_active' => false]);
    }

    /**
     * Get first record matching attributes or instantiate new model.
     *
     * @param array $attributes
     * @param array $values
     * @return Unit
     */
    public function firstOrNew(array $attributes, array $values = []): Unit
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
