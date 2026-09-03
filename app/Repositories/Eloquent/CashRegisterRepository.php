<?php

namespace App\Repositories\Eloquent;

use App\Models\CashRegister;
use App\Repositories\Contracts\CashRegisterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CashRegisterRepository extends BaseRepository implements CashRegisterRepositoryInterface
{
    /**
     * CashRegisterRepository constructor.
     *
     * @param CashRegister $model
     */
    public function __construct(CashRegister $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all cash registers with user and warehouse relations.
     *
     * @return Collection
     */
    public function getAllRegisters(): Collection
    {
        return $this->model->with('user', 'warehouse')->get();
    }

    /**
     * Get open cash register for user and warehouse.
     *
     * @param int|string $userId
     * @param int|string $warehouseId
     * @return CashRegister|null
     */
    public function getOpenRegister($userId, $warehouseId): ?CashRegister
    {
        return $this->model->where([
            ['user_id', $userId],
            ['warehouse_id', $warehouseId],
            ['status', true]
        ])->first();
    }

    /**
     * Check if open cash register exists for user and warehouse.
     *
     * @param int|string $userId
     * @param int|string $warehouseId
     * @return bool
     */
    public function isOpenRegisterAvailable($userId, $warehouseId): bool
    {
        return (bool) $this->model->where([
            ['user_id', $userId],
            ['warehouse_id', $warehouseId],
            ['status', true]
        ])->count();
    }
}
