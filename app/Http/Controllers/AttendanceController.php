<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\HrmSetting;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
        $this->middleware('check_permission:attendance');
    }

    public function index()
    {
        $indexData = $this->attendanceService->getIndexData();
        return view('backend.attendance.index', $indexData);
    }

    public function store(StoreAttendanceRequest $request)
    {
        $this->attendanceService->recordAttendance($request->all());

        return redirect()->back()->with('message', 'Attendance created successfully');
    }

    public function importDeviceCsv(Request $request)
    {
        $upload = $request->file('file');
        if ($request->Attendance_Device_date_format == null || $upload == null) {
            return redirect()->back()->with('not_permitted', 'Please select Attendance Device Date Format and upload a CSV file');
        }

        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        }

        $filePath = $upload->getRealPath();
        $file = fopen($filePath, 'r');
        $exclude_header = fgetcsv($file);

        $employee_all = Employee::all();
        $lims_hrm_setting_data = HrmSetting::latest()->first();
        $checkin = $lims_hrm_setting_data ? $lims_hrm_setting_data->checkin : '09:00:00';
        $data = [];

        while ($columns = fgetcsv($file)) {
            if ($columns[0] == "" || $columns[1] == "") {
                continue;
            }

            $staff_id = $columns[0];
            $employee = $employee_all->where('staff_id', $staff_id)->first();
            if (!$employee) {
                fclose($file);
                return redirect()->back()->with('not_permitted', 'Staff id - ' . $staff_id . ' is not available within the POS system');
            }

            $dt_time = explode(' ', $columns[1], 2);
            $attendance_date = Carbon::createFromFormat($request->Attendance_Device_date_format, $dt_time[0])->format('Y-m-d');
            $attendance_time = str_replace(' ', '', $dt_time[1] ?? '09:00:00');
            $i = 0;
            $status = 0;
            foreach ($data as $key => $dt) {
                if ($dt['date'] == $attendance_date && $dt['employee_id'] == $employee->id) {
                    $status = $dt['status'];
                    $i++;
                    if ($dt['checkout'] == null) {
                        $data[$key]['checkout'] = $attendance_time;
                        $i = -1;
                        break;
                    }
                }
            }

            if ($i == -1) {
                continue;
            } elseif ($i == 0) {
                $diff = strtotime($checkin) - strtotime($attendance_time);
                $status = ($diff >= 0) ? 1 : 0;

                $data[] = [
                    'date' => $attendance_date,
                    'employee_id' => $employee->id,
                    'user_id' => Auth::id(),
                    'checkin' => $attendance_time,
                    'checkout' => null,
                    'status' => $status
                ];
            } else {
                $data[] = [
                    'date' => $attendance_date,
                    'employee_id' => $employee->id,
                    'user_id' => Auth::id(),
                    'checkin' => $attendance_time,
                    'checkout' => null,
                    'status' => $status
                ];
            }
        }
        fclose($file);

        if (!empty($data)) {
            Attendance::upsert($data, ['date', 'employee_id', 'checkin'], ['checkout']);
        }

        return redirect()->back()->with('message', 'Attendance created successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $attendance_selected = $request['attendanceSelectedArray'] ?? $request['attendanceIdArray'] ?? [];
        foreach ($attendance_selected as $att) {
            if (is_array($att)) {
                $this->attendanceService->deleteAttendanceRecord($att[0] . '/' . $att[1]);
            } else {
                $this->attendanceService->deleteAttendanceRecord($att);
            }
        }

        return 'Attendance deleted successfully!';
    }

    public function delete($date, $employee_id)
    {
        $this->attendanceService->deleteAttendanceRecord($date . '/' . $employee_id);

        return redirect()->back()->with('not_permitted', 'Attendance deleted successfully');
    }

    public function destroy($id)
    {
        $this->attendanceService->deleteAttendanceRecord($id);

        return redirect()->back()->with('not_permitted', 'Attendance deleted successfully');
    }
}
