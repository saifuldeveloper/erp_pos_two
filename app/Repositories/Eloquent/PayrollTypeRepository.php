<?php

namespace App\Repositories\Eloquent;

use App\Models\PayrollType;
use App\Repositories\Contracts\PayrollTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PayrollTypeRepository extends BaseRepository implements PayrollTypeRepositoryInterface
{
    /**
     * PayrollTypeRepository constructor.
     *
     * @param PayrollType $model
     */
    public function __construct(PayrollType $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active payroll types.
     *
     * @return Collection
     */
    public function getActivePayrollTypes(): Collection
    {
        return $this->model->where('status', 'Active')->get();
    }
}
