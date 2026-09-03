<?php

namespace App\Repositories\Contracts;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active currencies.
     *
     * @return Collection
     */
    public function getActiveCurrencies(): Collection;
}
