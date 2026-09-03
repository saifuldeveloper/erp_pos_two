<?php

namespace App\Repositories\Contracts;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;

interface HolidayRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all holidays or user-scoped holidays.
     *
     * @param bool $canApprove
     * @param int|string $userId
     * @return Collection
     */
    public function getHolidays(bool $canApprove, $userId): Collection;
}
