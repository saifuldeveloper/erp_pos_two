<?php

namespace App\Services;

use App\Models\CashRegister;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Returns;
use App\Models\Sale;
use App\Repositories\Contracts\CashRegisterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CashRegisterService
{
    protected CashRegisterRepositoryInterface $cashRegisterRepository;

    /**
     * CashRegisterService constructor.
     *
     * @param CashRegisterRepositoryInterface $cashRegisterRepository
     */
    public function __construct(CashRegisterRepositoryInterface $cashRegisterRepository)
    {
        $this->cashRegisterRepository = $cashRegisterRepository;
    }

    /**
     * Get all cash registers.
     *
     * @return Collection
     */
    public function getAllRegisters(): Collection
    {
        return $this->cashRegisterRepository->getAllRegisters();
    }

    /**
     * Create a new open cash register session.
     *
     * @param array $requestData
     * @return CashRegister
     */
    public function openRegister(array $requestData): CashRegister
    {
        $data = $requestData;
        $data['status'] = true;
        $data['user_id'] = Auth::id();

        return $this->cashRegisterRepository->create($data);
    }

    /**
     * Calculate financial details of a cash register by ID.
     *
     * @param int|string $id
     * @return array
     */
    public function getRegisterDetails($id): array
    {
        $cashRegister = $this->cashRegisterRepository->findOrFail($id);

        $data['cash_in_hand'] = $cashRegister->cash_in_hand;
        $data['total_sale_amount'] = Sale::where([
            ['cash_register_id', $cashRegister->id],
            ['sale_status', 1]
        ])->sum('grand_total');
        $data['total_payment'] = Payment::where('cash_register_id', $cashRegister->id)->sum('amount');
        $data['cash_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Cash']
        ])->sum('amount');
        $data['credit_card_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Credit Card']
        ])->sum('amount');
        $data['gift_card_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Gift Card']
        ])->sum('amount');
        $data['deposit_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Deposit']
        ])->sum('amount');
        $data['cheque_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Cheque']
        ])->sum('amount');
        $data['paypal_payment'] = Payment::where([
            ['cash_register_id', $cashRegister->id],
            ['paying_method', 'Paypal']
        ])->sum('amount');
        $data['total_sale_return'] = Returns::where('cash_register_id', $cashRegister->id)->sum('grand_total');
        $data['total_expense'] = Expense::where('cash_register_id', $cashRegister->id)->sum('amount');
        $data['total_cash'] = $data['cash_in_hand'] + $data['total_payment'] - ($data['total_sale_return'] + $data['total_expense']);
        $data['status'] = $cashRegister->status;
        $data['id'] = $cashRegister->id;

        return $data;
    }

    /**
     * Calculate financial details of active user register by warehouse.
     *
     * @param int|string $warehouseId
     * @return array
     */
    public function getActiveWarehouseRegisterDetails($warehouseId): array
    {
        $cashRegister = $this->cashRegisterRepository->getOpenRegister(Auth::id(), $warehouseId);
        if (!$cashRegister) {
            return [];
        }

        return $this->getRegisterDetails($cashRegister->id);
    }

    /**
     * Close cash register session.
     *
     * @param int|string $cashRegisterId
     * @return CashRegister
     */
    public function closeRegister($cashRegisterId): CashRegister
    {
        $cashRegister = $this->cashRegisterRepository->findOrFail($cashRegisterId);
        $cashRegister->status = 0;
        $cashRegister->save();

        return $cashRegister;
    }

    /**
     * Check if user has open cash register for warehouse.
     *
     * @param int|string $warehouseId
     * @return bool
     */
    public function checkAvailability($warehouseId): bool
    {
        return $this->cashRegisterRepository->isOpenRegisterAvailable(Auth::id(), $warehouseId);
    }
}
