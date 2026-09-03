<?php

namespace App\Repositories\Contracts;

use App\Models\MoneyTransfer;
use Illuminate\Database\Eloquent\Collection;

interface MoneyTransferRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all money transfers.
     *
     * @return Collection
     */
    public function getAllTransfers(): Collection;
}
