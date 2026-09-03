<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all non-deleted users.
     *
     * @return Collection
     */
    public function getNonDeletedUsers(): Collection;

    /**
     * Count active users.
     *
     * @return int
     */
    public function countActiveUsers(): int;
}
