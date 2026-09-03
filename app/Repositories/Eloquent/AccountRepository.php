<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    /**
     * AccountRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active accounts.
     *
     * @return Collection
     */
    public function getActiveAccounts(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    /**
     * Get the default account.
     *
     * @return Account|null
     */
    public function getDefaultAccount(): ?Account
    {
        return $this->model->where([
            ['is_active', true],
            ['is_default', 1]
        ])->first();
    }

    /**
     * Set an account as the default account.
     *
     * @param int|string $id
     * @return bool
     */
    public function makeDefault($id): bool
    {
        $this->model->where('is_default', 1)->update(['is_default' => null]);
        $account = $this->find($id);
        if ($account) {
            $account->is_default = 1;
            return (bool) $account->save();
        }
        return false;
    }

    /**
     * Deactivate an account.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool
    {
        $account = $this->find($id);
        if ($account) {
            $account->is_active = false;
            return (bool) $account->save();
        }
        return false;
    }
}
