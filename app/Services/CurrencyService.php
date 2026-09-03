<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\GeneralSetting;
use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    protected CurrencyRepositoryInterface $currencyRepository;

    /**
     * CurrencyService constructor.
     *
     * @param CurrencyRepositoryInterface $currencyRepository
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Get active currencies.
     *
     * @return Collection
     */
    public function getActiveCurrencies(): Collection
    {
        return $this->currencyRepository->getActiveCurrencies();
    }

    /**
     * Create currency.
     *
     * @param array $requestData
     * @return Currency
     */
    public function createCurrency(array $requestData): Currency
    {
        $data = $requestData;
        $currency = $this->currencyRepository->create($data);
        cache()->forget('currency');

        return $currency;
    }

    /**
     * Update currency and base currency setting.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Currency
     */
    public function updateCurrency($id, array $requestData): Currency
    {
        $data = $requestData;
        if (($data['exchange_rate'] ?? 0) == 1) {
            $generalSetting = GeneralSetting::latest()->first();
            if ($generalSetting) {
                $generalSetting->update(['currency' => $id]);
            }
        }

        $currency = $this->currencyRepository->findOrFail($id);
        $currency->update($data);
        cache()->forget('currency');

        return $currency;
    }

    /**
     * Deactivate currency.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCurrency($id): bool
    {
        $currency = $this->currencyRepository->findOrFail($id);
        $currency->is_active = false;
        $currency->save();
        cache()->forget('currency');

        return true;
    }
}
