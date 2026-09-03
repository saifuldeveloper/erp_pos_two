<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Models\Discount;
use App\Models\DiscountPlan;
use App\Models\DiscountPlanDiscount;
use App\Models\Product;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DiscountController extends Controller
{
    protected DiscountService $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('discount_plan')) {
            $lims_discount_all = $this->discountService->getAllDiscounts();
            return view('backend.discount.index', compact('lims_discount_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $lims_discount_plan_list = $this->discountService->getActiveDiscountPlans();
        return view('backend.discount.create', compact('lims_discount_plan_list'));
    }

    public function productSearch($code)
    {
        return $this->discountService->searchProductByCode($code);
    }

    public function store(StoreDiscountRequest $request)
    {
        $this->discountService->createDiscount($request->all());

        return redirect()->route('discounts.index')->with('message', 'Discount created successfully');
    }

    public function edit($id)
    {
        $formData = $this->discountService->getEditFormData($id);

        return view('backend.discount.edit', $formData);
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        $this->discountService->updateDiscount($id, $request->all());

        return redirect()->route('discounts.index')->with('message', 'Discount updated successfully');
    }
}
