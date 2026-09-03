<?php

namespace App\Http\Controllers;

use App\Services\CourierService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $this->courierService->createCourier($request->all());

        return redirect()->back()->with('message', 'Courier created successfully');
    }

    public function update(Request $request, $id)
    {
        $this->courierService->updateCourier($request->id, $request->all());

        return redirect()->back()->with('message', 'Courier updated successfully');
    }

    public function destroy($id)
    {
        $this->courierService->deleteCourier($id);

        return redirect()->back()->with('not_permitted', 'Courier deleted successfully');
    }
}
