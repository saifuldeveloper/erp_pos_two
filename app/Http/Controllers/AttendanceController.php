<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

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
