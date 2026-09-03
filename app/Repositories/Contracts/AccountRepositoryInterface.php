<?php

namespace App\Repositories\Contracts;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active accounts.
     *
     * @return Collection
     */
    public function getActiveAccounts(): Collection;

    /**
     * Get the default account.
     *
     * @return Account|null
     */
    public function getDefaultAccount(): ?Account;

    /**
     * Set an account as the default account.
     *
     * @param int|string $id
     * @return bool
     */
    public function makeDefault($id): bool;

    /**
     * Deactivate an account.
     *
     * @param int|string $id
     * @return bool
     */
    public function deactivate($id): bool;
}
