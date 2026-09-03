<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    /**
     * SupplierRepository constructor.
     *
     * @param Supplier $model
     */
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active suppliers.
     *
     * @return Collection
     */
    public function getActiveSuppliers(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Count total active suppliers.
     *
     * @return int
     */
    public function countTotalActiveSuppliers(): int
    {
        return $this->model->where('is_active', true)->count();
    }

    /**
     * Deactivate a supplier.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $supplier = $this->find($id);
        if ($supplier) {
            $supplier->is_active = false;
            return (bool) $supplier->save();
        }
        return false;
    }

    /**
     * Deactivate multiple suppliers.
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
     * @return Supplier
     */
    public function firstOrNew(array $attributes, array $values = []): Supplier
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
