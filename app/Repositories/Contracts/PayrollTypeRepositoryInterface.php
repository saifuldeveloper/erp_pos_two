<?php

namespace App\Repositories\Contracts;

use App\Models\PayrollType;
use Illuminate\Database\Eloquent\Collection;

interface PayrollTypeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get active payroll types.
     *
     * @return Collection
     */
    public function getActivePayrollTypes(): Collection;
}
