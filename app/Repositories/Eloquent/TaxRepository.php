<?php

namespace App\Repositories\Eloquent;

use App\Models\Tax;
use App\Repositories\Contracts\TaxRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxRepository extends BaseRepository implements TaxRepositoryInterface
{
    /**
     * TaxRepository constructor.
     *
     * @param Tax $model
     */
    public function __construct(Tax $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active taxes.
     *
     * @return Collection
     */
    public function getActiveTaxes(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Search taxes by name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByNamePaginated(string $name, int $perPage = 5): LengthAwarePaginator
    {
        return $this->model->where('name', $name)->paginate($perPage);
    }

    /**
     * Deactivate a tax (is_active = false).
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $tax = $this->find($id);
        if ($tax) {
            $tax->is_active = false;
            return (bool) $tax->save();
        }
        return false;
    }

    /**
     * Deactivate multiple taxes by IDs.
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
     * @return Tax
     */
    public function firstOrNew(array $attributes, array $values = []): Tax
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
