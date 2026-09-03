<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Expense;
use App\Models\MoneyTransfer;
use App\Models\Payment;
use App\Models\Payroll;
use App\Models\ReturnPurchase;
use App\Models\Returns;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AccountService
{
    protected AccountRepositoryInterface $accountRepository;

    /**
     * AccountService constructor.
     *
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Get all active accounts.
     *
     * @return Collection
     */
    public function getActiveAccounts(): Collection
    {
        return $this->accountRepository->getActiveAccounts();
    }

    /**
     * Get account by ID.
     *
     * @param int|string $id
     * @return Account
     */
    public function getAccountById($id): Account
    {
        return $this->accountRepository->findOrFail($id);
    }

    /**
     * Create a new account.
     *
     * @param array $requestData
     * @return Account
     */
    public function createAccount(array $requestData): Account
    {
        $existingActive = $this->accountRepository->getActiveAccounts()->first();
        $data = $requestData;
        $data['total_balance'] = $data['initial_balance'] ?? 0;
        if (!$existingActive) {
            $data['is_default'] = 1;
        }
        $data['is_active'] = true;

        return $this->accountRepository->create($data);
    }

    /**
     * Update an existing account.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Account
     */
    public function updateAccount($id, array $requestData): Account
    {
        $account = $this->accountRepository->findOrFail($id);
        $data = $requestData;
        $data['total_balance'] = $data['initial_balance'] ?? 0;

        $account->update($data);

        return $account;
    }

    /**
     * Make an account default.
     *
     * @param int|string $id
     * @return bool
     */
    public function makeDefault($id): bool
    {
        return $this->accountRepository->makeDefault($id);
    }

    /**
     * Delete an account (if not default).
     *
     * @param int|string $id
     * @return array [success => bool, message => string]
     */
    public function deleteAccount($id): array
    {
        $account = $this->accountRepository->findOrFail($id);
        if ($account->is_default) {
            return [
                'success' => false,
                'message' => 'Please make another account default first!'
            ];
        }

        $this->accountRepository->deactivate($id);

        return [
            'success' => true,
            'message' => 'Account deleted successfully!'
        ];
    }

    /**
     * Calculate balance sheet data.
     *
     * @return array
     */
    public function getBalanceSheetData(): array
    {
        $accounts = $this->accountRepository->getActiveAccounts();
        $debit = [];
        $credit = [];

        foreach ($accounts as $account) {
            $paymentRecieved = Payment::whereNotNull('sale_id')->where('account_id', $account->id)->sum('amount');
            $paymentSent = Payment::whereNotNull('purchase_id')->where('account_id', $account->id)->sum('amount');
            $returns = DB::table('returns')->where('account_id', $account->id)->sum('grand_total');
            $returnPurchase = DB::table('return_purchases')->where('account_id', $account->id)->sum('grand_total');
            $expenses = DB::table('expenses')->where('account_id', $account->id)->sum('amount');
            $payrolls = DB::table('payrolls')->where('account_id', $account->id)->sum('amount');
            $sentMoneyViaTransfer = MoneyTransfer::where('from_account_id', $account->id)->sum('amount');
            $recievedMoneyViaTransfer = MoneyTransfer::where('to_account_id', $account->id)->sum('amount');

            $credit[] = $paymentRecieved + $returnPurchase + $recievedMoneyViaTransfer + $account->initial_balance;
            $debit[] = $paymentSent + $returns + $expenses + $payrolls + $sentMoneyViaTransfer;
        }

        return [
            'lims_account_list' => $accounts,
            'debit'             => $debit,
            'credit'            => $credit,
        ];
    }

    /**
     * Get account statement data.
     *
     * @param int|string $accountId
     * @param string $type
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getAccountStatementData($accountId, string $type, string $startDate, string $endDate): array
    {
        $account = $this->accountRepository->findOrFail($accountId);
        $creditList = new Collection();
        $debitList = new Collection();
        $expenseList = new Collection();
        $returnList = new Collection();
        $purchaseReturnList = new Collection();
        $payrollList = new Collection();
        $recievedMoneyTransferList = new Collection();
        $sentMoneyTransferList = new Collection();

        if ($type == '0' || $type == '2') {
            $creditList = Payment::whereNotNull('sale_id')
                ->where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('payment_reference as reference_no', 'sale_id', 'amount', 'created_at')
                ->get();

            $recievedMoneyTransferList = MoneyTransfer::where('to_account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'to_account_id', 'amount', 'created_at')
                ->get();

            $purchaseReturnList = ReturnPurchase::where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'grand_total as amount', 'created_at')
                ->get();
        }

        if ($type == '0' || $type == '1') {
            $debitList = Payment::whereNotNull('purchase_id')
                ->where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('payment_reference as reference_no', 'purchase_id', 'amount', 'created_at')
                ->get();

            $expenseList = Expense::where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'amount', 'created_at')
                ->get();

            $returnList = Returns::where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'grand_total as amount', 'created_at')
                ->get();

            $payrollList = Payroll::where('account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'amount', 'created_at')
                ->get();

            $sentMoneyTransferList = MoneyTransfer::where('from_account_id', $accountId)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->select('reference_no', 'to_account_id', 'amount', 'created_at')
                ->get();
        }

        $allTransactionList = $creditList->concat($recievedMoneyTransferList)
            ->concat($debitList)
            ->concat($expenseList)
            ->concat($returnList)
            ->concat($purchaseReturnList)
            ->concat($payrollList)
            ->concat($sentMoneyTransferList)
            ->sortByDesc('created_at');

        return [
            'lims_account_data'    => $account,
            'all_transaction_list' => $allTransactionList,
            'balance'              => 0
        ];
    }

    /**
     * Get HTML options for account select dropdown.
     *
     * @return string
     */
    public function getAccountOptionsHtml(): string
    {
        $accounts = $this->accountRepository->getActiveAccounts();
        $html = '';
        foreach ($accounts as $account) {
            $selected = ($account->is_default == 1) ? 'selected ' : '';
            $html .= '<option ' . $selected . 'value="' . $account->id . '">' . $account->name . ' (' . $account->account_no . ')' . '</option>';
        }

        return $html;
    }
}
