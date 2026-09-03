<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    /**
     * BrandRepository constructor.
     *
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active brands.
     *
     * @return Collection
     */
    public function getActiveBrands(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Get brands by an array of IDs.
     *
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Deactivate a brand by setting is_active = false.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $brand = $this->findOrFail($id);
        $brand->is_active = false;
        return (bool) $brand->save();
    }

    /**
     * Deactivate multiple brands by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deactivateMultiple(array $ids): bool
    {
        return (bool) $this->model->whereIn('id', $ids)->update(['is_active' => false]);
    }

    /**
     * Get the first record matching attributes or create it.
     *
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function firstOrCreate(array $attributes, array $values = []): Model
    {
        return $this->model->firstOrCreate($attributes, $values);
    }
}
