<?php

namespace App\Repositories\Contracts;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Collection;

interface DeliveryRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all deliveries with role scoping.
     *
     * @return Collection
     */
    public function getAllDeliveries(): Collection;

    /**
     * Get delivery by sale ID.
     *
     * @param int|string $saleId
     * @return Delivery|null
     */
    public function getDeliveryBySaleId($saleId): ?Delivery;
}
