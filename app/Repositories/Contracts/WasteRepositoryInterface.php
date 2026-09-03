<?php

namespace App\Repositories\Contracts;

use App\Models\Waste;
use Illuminate\Database\Eloquent\Collection;

interface WasteRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get wastes filtered by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getWastesByDateRange(string $startDate, string $endDate): Collection;
}
