<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{
    /**
     * AttendanceRepository constructor.
     *
     * @param Attendance $model
     */
    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }

    /**
     * Get grouped attendance records with employee and user names.
     *
     * @return array
     */
    public function getGroupedAttendanceData(): array
    {
        $general_setting = DB::table('general_settings')->latest()->first();

        $query = $this->model
            ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')
            ->leftJoin('users', 'users.id', '=', 'attendances.user_id')
            ->orderBy('attendances.date', 'desc')
            ->select(['attendances.*', 'employees.name as employee_name', 'users.name as user_name']);

        if (Auth::user() && Auth::user()->role_id > 2 && $general_setting && $general_setting->staff_access == 'own') {
            $query->where('attendances.user_id', Auth::id());
        }

        $grouped = $query->get()->groupBy(['date', 'employee_id']);

        $lims_attendance_all = [];
        foreach ($grouped as $attendance_data) {
            foreach ($attendance_data as $data) {
                $checkin_checkout = '';
                $date = null;
                $employee_name = null;
                $status = null;
                $user_name = null;
                $employee_id = null;

                foreach ($data as $dt) {
                    $date = $dt->date;
                    $employee_name = $dt->employee_name;
                    $checkin_checkout .= (($dt->checkin != null) ? $dt->checkin : 'N/A') . ' - ' . (($dt->checkout != null) ? $dt->checkout : 'N/A') . '<br>';
                    $status = $dt->status;
                    $user_name = $dt->user_name;
                    $employee_id = $dt->employee_id;
                }

                $lims_attendance_all[] = [
                    'date'             => $date,
                    'employee_name'    => $employee_name,
                    'checkin_checkout' => $checkin_checkout,
                    'status'           => $status,
                    'user_name'        => $user_name,
                    'employee_id'      => $employee_id
                ];
            }
        }

        return $lims_attendance_all;
    }
}
