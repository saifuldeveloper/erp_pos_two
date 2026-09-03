<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('unit') || $role->hasPermissionTo('coupon-index')) {
            $lims_coupon_all = $this->couponService->getActiveCoupons();
            return view('backend.coupon.index', compact('lims_coupon_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generateCode()
    {
        return $this->couponService->generateCode();
    }

    public function store(StoreCouponRequest $request)
    {
        $this->couponService->createCoupon($request->all());

        return redirect('coupons')->with('message', 'Coupon created successfully');
    }

    public function update(UpdateCouponRequest $request, $id)
    {
        $this->couponService->updateCoupon($request->coupon_id, $request->all());

        return redirect('coupons')->with('message', 'Coupon updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $coupon_id = $request['couponIdArray'] ?? [];
        $this->couponService->deleteMultipleCoupons($coupon_id);

        return 'Coupon deleted successfully!';
    }
}
