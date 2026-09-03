<?php

namespace App\Repositories\Eloquent;

use App\Models\Currency;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    /**
     * CurrencyRepository constructor.
     *
     * @param Currency $model
     */
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active currencies.
     *
     * @return Collection
     */
    public function getActiveCurrencies(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
