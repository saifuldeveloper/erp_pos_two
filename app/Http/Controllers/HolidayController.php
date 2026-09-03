<?php

namespace App\Http\Controllers;

use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;
use App\Models\Holiday;
use App\Services\HolidayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class HolidayController extends Controller
{
    protected HolidayService $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }

    public function index()
    {
        $indexData = $this->holidayService->getIndexData();

        return view('backend.holiday.index', $indexData);
    }

    public function store(StoreHolidayRequest $request)
    {
        $this->holidayService->createHoliday($request->all());

        return redirect()->back()->with('message', "Holiday created successfully");
    }

    public function approveHoliday($id)
    {
        return $this->holidayService->approveHoliday($id);
    }

    public function myHoliday($year, $month)
    {
        $holidays = $this->holidayService->getMyHolidayDates((int) $year, (int) $month);

        return view('backend.holiday.my_holiday', compact('holidays', 'year', 'month'));
    }

    public function update(UpdateHolidayRequest $request, $id)
    {
        $this->holidayService->updateHoliday($request->id, $request->all());

        return redirect()->back()->with('message', "Holiday updated successfully");
    }

    public function deleteBySelection(Request $request)
    {
        $holiday_ids = $request['holidayIdArray'] ?? [];
        $this->holidayService->deleteMultipleHolidays($holiday_ids);

        return 'Holiday deleted successfully!';
    }

    public function destroy($id)
    {
        $this->holidayService->deleteHoliday($id);

        return redirect()->back()->with('not_permitted', "Holiday deleted successfully");
    }
}
