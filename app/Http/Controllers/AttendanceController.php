<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Models\Employee;
use App\Models\HrmSetting;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('attendance')) {
            $indexData = $this->attendanceService->getIndexData();
            return view('backend.attendance.index', $indexData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreAttendanceRequest $request)
    {
        $this->attendanceService->recordAttendance($request->all());

        return redirect()->back()->with('message', 'Attendance created successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $attendance_ids = $request['attendanceIdArray'] ?? [];
        $this->attendanceService->deleteMultipleAttendance($attendance_ids);

        return 'Attendance deleted successfully!';
    }

    public function destroy($id)
    {
        $this->attendanceService->deleteAttendanceRecord($id);

        return redirect()->back()->with('not_permitted', 'Attendance deleted successfully');
    }
}
