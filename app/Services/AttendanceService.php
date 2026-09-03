<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\HrmSetting;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    protected AttendanceRepositoryInterface $attendanceRepository;

    /**
     * AttendanceService constructor.
     *
     * @param AttendanceRepositoryInterface $attendanceRepository
     */
    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * Get index data for attendance view.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $lims_employee_list = Employee::where('is_active', true)->get();
        $lims_hrm_setting_data = HrmSetting::latest()->first();
        $lims_attendance_all = $this->attendanceRepository->getGroupedAttendanceData();

        return compact('lims_employee_list', 'lims_hrm_setting_data', 'lims_attendance_all');
    }

    /**
     * Record attendance for multiple employees.
     *
     * @param array $requestData
     * @return bool
     */
    public function recordAttendance(array $requestData): bool
    {
        $data = $requestData;
        $employeeIds = $data['employee_id'] ?? [];
        $lims_hrm_setting_data = HrmSetting::latest()->first();
        $checkin = $lims_hrm_setting_data ? $lims_hrm_setting_data->checkin : '09:00:00';

        foreach ($employeeIds as $id) {
            $data['date'] = date('Y-m-d', strtotime(str_replace('/', '-', $data['date'])));
            $data['user_id'] = Auth::id();
            $data['employee_id'] = $id;

            $existing = Attendance::whereDate('date', $data['date'])->where('employee_id', $id)->first();
            if (!$existing) {
                $diff = strtotime($checkin) - strtotime($data['checkin'] ?? '09:00:00');
                $data['status'] = ($diff >= 0) ? 1 : 0;
            } else {
                $data['status'] = $existing->status;
            }

            $this->attendanceRepository->create($data);
        }

        return true;
    }

    /**
     * Delete attendance by date and employee ID.
     *
     * @param string $id "date/employee_id"
     * @return bool
     */
    public function deleteAttendanceRecord(string $id): bool
    {
        $params = explode('/', $id);
        $date = $params[0] ?? null;
        $employeeId = $params[1] ?? null;

        if ($date && $employeeId) {
            Attendance::whereDate('date', $date)->where('employee_id', $employeeId)->delete();
        }

        return true;
    }

    /**
     * Delete multiple attendance records.
     *
     * @param array $attendanceIds
     * @return bool
     */
    public function deleteMultipleAttendance(array $attendanceIds): bool
    {
        foreach ($attendanceIds as $id) {
            $this->deleteAttendanceRecord($id);
        }

        return true;
    }
}
