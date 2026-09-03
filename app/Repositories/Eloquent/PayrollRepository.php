<?php

namespace App\Repositories\Eloquent;

use App\Models\Payroll;
use App\Repositories\Contracts\PayrollRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayrollRepository extends BaseRepository implements PayrollRepositoryInterface
{
    /**
     * PayrollRepository constructor.
     *
     * @param Payroll $model
     */
    public function __construct(Payroll $model)
    {
        parent::__construct($model);
    }

    /**
     * Get filtered payrolls with role, date, and employee scoping.
     *
     * @param string $startDate
     * @param string $endDate
     * @param string|int|null $employeeId
     * @return Collection
     */
    public function getFilteredPayrolls(string $startDate, string $endDate, $employeeId = null): Collection
    {
        $general_setting = DB::table('general_settings')->latest()->first();

        $query = $this->model->orderBy('id', 'desc');

        if (Auth::user() && Auth::user()->role_id > 2 && $general_setting && $general_setting->staff_access == 'own') {
            $query->where('user_id', Auth::id())
                ->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $query->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->when($employeeId, function ($q) use ($employeeId) {
                    return $q->where('employee_id', $employeeId);
                });
        }

        return $query->get();
    }
}
