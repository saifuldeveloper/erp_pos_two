<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountPlan\StoreDiscountPlanRequest;
use App\Http\Requests\DiscountPlan\UpdateDiscountPlanRequest;
use App\Models\Customer;
use App\Models\DiscountPlan;
use App\Models\DiscountPlanCustomer;
use App\Services\DiscountPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DiscountPlanController extends Controller
{
    protected DiscountPlanService $discountPlanService;

    public function __construct(DiscountPlanService $discountPlanService)
    {
        $this->discountPlanService = $discountPlanService;
        $this->middleware('check_permission:discount_plan')->only('index');
    }

    public function index()
    {
        $lims_discount_plan_all = $this->discountPlanService->getAllDiscountPlans();
        return view('backend.discount_plan.index', compact('lims_discount_plan_all'));
    }

    public function create()
    {
        $lims_customer_list = $this->discountPlanService->getActiveCustomers();
        return view('backend.discount_plan.create', compact('lims_customer_list'));
    }

    public function store(StoreDiscountPlanRequest $request)
    {
        $this->discountPlanService->createDiscountPlan($request->all());

        return redirect()->route('discount-plans.index')->with('message', 'DiscountPlan created successfully');
    }

    public function edit($id)
    {
        $formData = $this->discountPlanService->getEditFormData($id);

        return view('backend.discount_plan.edit', $formData);
    }

    public function update(UpdateDiscountPlanRequest $request, $id)
    {
        $this->discountPlanService->updateDiscountPlan($id, $request->all());

        return redirect()->route('discount-plans.index')->with('message', 'DiscountPlan updated successfully');
    }
}
