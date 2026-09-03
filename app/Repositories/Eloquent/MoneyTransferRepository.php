<?php

namespace App\Repositories\Eloquent;

use App\Models\MoneyTransfer;
use App\Repositories\Contracts\MoneyTransferRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MoneyTransferRepository extends BaseRepository implements MoneyTransferRepositoryInterface
{
    /**
     * MoneyTransferRepository constructor.
     *
     * @param MoneyTransfer $model
     */
    public function __construct(MoneyTransfer $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all money transfers.
     *
     * @return Collection
     */
    public function getAllTransfers(): Collection
    {
        return $this->model->all();
    }
}
