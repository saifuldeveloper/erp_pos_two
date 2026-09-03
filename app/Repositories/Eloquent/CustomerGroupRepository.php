<?php

namespace App\Repositories\Eloquent;

use App\Models\CustomerGroup;
use App\Repositories\Contracts\CustomerGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerGroupRepository extends BaseRepository implements CustomerGroupRepositoryInterface
{
    /**
     * CustomerGroupRepository constructor.
     *
     * @param CustomerGroup $model
     */
    public function __construct(CustomerGroup $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active customer groups.
     *
     * @return Collection
     */
    public function getActiveCustomerGroups(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Deactivate a customer group.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $group = $this->find($id);
        if ($group) {
            $group->is_active = false;
            return (bool) $group->save();
        }
        return false;
    }

    /**
     * Deactivate multiple customer groups.
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
     * @return CustomerGroup
     */
    public function firstOrNew(array $attributes, array $values = []): CustomerGroup
    {
        return $this->model->firstOrNew($attributes, $values);
    }
}
