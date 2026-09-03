<?php

namespace App\Repositories\Eloquent;

use App\Models\Warehouse;
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class WarehouseRepository extends BaseRepository implements WarehouseRepositoryInterface
{
    /**
     * WarehouseRepository constructor.
     *
     * @param Warehouse $model
     */
    public function __construct(Warehouse $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active warehouses.
     *
     * @return Collection
     */
    public function getActiveWarehouses(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Get warehouses filtered by user role and warehouse assignment.
     *
     * @param int|null $roleId
     * @param int|null $warehouseId
     * @return Collection
     */
    public function getWarehousesForUser(?int $roleId = null, ?int $warehouseId = null): Collection
    {
        if ($roleId !== null && $roleId > 2 && $roleId != 3 && $warehouseId) {
            return $this->model->where([
                ['is_active', true],
                ['id', $warehouseId]
            ])->get();
        }

        return $this->model->where('is_active', true)->get();
    }

    /**
     * Deactivate a warehouse (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $warehouse = $this->find($id);
        if ($warehouse) {
            $warehouse->is_active = false;
            return (bool) $warehouse->save();
        }
        return false;
    }

    /**
     * Deactivate multiple warehouses by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool
    {
        return (bool) $this->model->whereIn('id', $ids)->update(['is_active' => false]);
    }

    /**
     * Get the first record matching attributes or instantiate it.
     *
     * @param array $attributes
     * @param array $values
     * @return Warehouse
     */
    public function firstOrNew(array $attributes, array $values = []): Warehouse
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
