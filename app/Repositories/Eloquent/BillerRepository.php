<?php

namespace App\Repositories\Eloquent;

use App\Models\Biller;
use App\Repositories\Contracts\BillerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BillerRepository extends BaseRepository implements BillerRepositoryInterface
{
    /**
     * BillerRepository constructor.
     *
     * @param Biller $model
     */
    public function __construct(Biller $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active billers.
     *
     * @return Collection
     */
    public function getActiveBillers(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Deactivate a biller.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $biller = $this->find($id);
        if ($biller) {
            $biller->is_active = false;
            return (bool) $biller->save();
        }
        return false;
    }

    /**
     * Deactivate multiple billers.
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
     * @return Biller
     */
    public function firstOrNew(array $attributes, array $values = []): Biller
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
