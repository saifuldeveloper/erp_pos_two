<?php

namespace App\Repositories\Contracts;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active roles.
     *
     * @return Collection
     */
    public function getActiveRoles(): Collection;
}
