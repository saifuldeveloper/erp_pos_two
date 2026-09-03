<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all non-deleted users.
     *
     * @return Collection
     */
    public function getNonDeletedUsers(): Collection
    {
        return $this->model->where('is_deleted', false)->get();
    }

    /**
     * Count active users.
     *
     * @return int
     */
    public function countActiveUsers(): int
    {
        return $this->model->where('is_active', true)->count();
    }
}
