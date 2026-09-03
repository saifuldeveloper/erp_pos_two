<?php

namespace App\Repositories\Eloquent;

use App\Models\Roles;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * RoleRepository constructor.
     *
     * @param Roles $model
     */
    public function __construct(Roles $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active roles.
     *
     * @return Collection
     */
    public function getActiveRoles(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
