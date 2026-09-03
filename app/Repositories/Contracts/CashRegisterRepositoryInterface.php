<?php

namespace App\Repositories\Contracts;

use App\Models\CashRegister;
use Illuminate\Database\Eloquent\Collection;

interface CashRegisterRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all cash registers with user and warehouse relations.
     *
     * @return Collection
     */
    public function getAllRegisters(): Collection;

    /**
     * Get open cash register for user and warehouse.
     *
     * @param int|string $userId
     * @param int|string $warehouseId
     * @return CashRegister|null
     */
    public function getOpenRegister($userId, $warehouseId): ?CashRegister;

    /**
     * Check if open cash register exists for user and warehouse.
     *
     * @param int|string $userId
     * @param int|string $warehouseId
     * @return bool
     */
    public function isOpenRegisterAvailable($userId, $warehouseId): bool;
}
