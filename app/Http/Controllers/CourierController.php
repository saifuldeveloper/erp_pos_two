<?php

namespace App\Http\Controllers;

use App\Http\Requests\Courier\StoreCourierRequest;
use App\Http\Requests\Courier\UpdateCourierRequest;
use App\Services\CourierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierController extends Controller
{
    protected CourierService $courierService;

    public function __construct(CourierService $courierService)
    {
        $this->courierService = $courierService;
    }

    public function index()
    {
        $lims_courier_all = $this->courierService->getActiveCouriers();
        return view('backend.courier.index', compact('lims_courier_all'));
    }

    public function store(StoreCourierRequest $request)
    {
        $this->courierService->createCourier($request->all());

        return redirect()->back()->with('message', 'Courier created successfully');
    }

    public function update(UpdateCourierRequest $request, $id)
    {
        $this->courierService->updateCourier($request->id, $request->all());

        return redirect()->back()->with('message', 'Courier updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        if (Auth::user()->role_id > 2) {
            return 'Sorry! You are not allowed to delete courier';
        }

        $courier_ids = $request['courierIdArray'] ?? [];
        foreach ($courier_ids as $id) {
            $this->courierService->deleteCourier($id);
        }

        return 'Courier deleted successfully!';
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete courier');
        }

        $this->courierService->deleteCourier($id);

        return redirect()->back()->with('not_permitted', 'Courier deleted successfully');
    }
}
