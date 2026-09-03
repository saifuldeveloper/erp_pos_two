<?php

namespace App\Services;

use App\Models\MoneyTransfer;
use App\Repositories\Contracts\MoneyTransferRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MoneyTransferService
{
    protected MoneyTransferRepositoryInterface $moneyTransferRepository;

    /**
     * MoneyTransferService constructor.
     *
     * @param MoneyTransferRepositoryInterface $moneyTransferRepository
     */
    public function __construct(MoneyTransferRepositoryInterface $moneyTransferRepository)
    {
        $this->moneyTransferRepository = $moneyTransferRepository;
    }

    /**
     * Get all money transfers.
     *
     * @return Collection
     */
    public function getAllTransfers(): Collection
    {
        return $this->moneyTransferRepository->getAllTransfers();
    }

    /**
     * Get all money transfers (alias).
     *
     * @return Collection
     */
    public function getAllMoneyTransfers(): Collection
    {
        return $this->moneyTransferRepository->getAllTransfers();
    }

    /**
     * Create a new money transfer.
     *
     * @param array $requestData
     * @return MoneyTransfer
     */
    public function createTransfer(array $requestData): MoneyTransfer
    {
        $data = $requestData;
        $data['reference_no'] = 'mtr-' . date("Ymd") . '-' . date("his");

        return $this->moneyTransferRepository->create($data);
    }

    /**
     * Update an existing money transfer.
     *
     * @param int|string $id
     * @param array $requestData
     * @return MoneyTransfer
     */
    public function updateTransfer($id, array $requestData): MoneyTransfer
    {
        $transfer = $this->moneyTransferRepository->findOrFail($id);
        $transfer->update($requestData);

        return $transfer;
    }

    /**
     * Delete a money transfer.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTransfer($id): bool
    {
        return $this->moneyTransferRepository->delete($id);
    }
}
