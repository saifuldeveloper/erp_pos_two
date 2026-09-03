<?php

namespace App\Repositories\Contracts;

use App\Models\Payroll;
use Illuminate\Database\Eloquent\Collection;

interface PayrollRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get filtered payrolls with role, date, and employee scoping.
     *
     * @param string $startDate
     * @param string $endDate
     * @param string|int|null $employeeId
     * @return Collection
     */
    public function getFilteredPayrolls(string $startDate, string $endDate, $employeeId = null): Collection;
}
