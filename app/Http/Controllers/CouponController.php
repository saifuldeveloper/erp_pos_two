<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
        $this->middleware('check_permission:coupon-index|coupon|unit')->only(['index', 'generateCode', 'create', 'store', 'edit', 'update']);
    }

    public function index(Request $request)
    {
        $lims_coupon_all = $this->couponService->getActiveCoupons();
        return view('backend.coupon.index', compact('lims_coupon_all'));
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
        if (Auth::user()->role_id > 2) {
            return 'Sorry! You are not allowed to delete coupon';
        }

        $coupon_id = $request['couponIdArray'] ?? [];
        $this->couponService->deleteMultipleCoupons($coupon_id);

        return 'Coupon deleted successfully!';
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id > 2) {
            return redirect('coupons')->with('not_permitted', 'Sorry! You are not allowed to delete coupon');
        }

        $this->couponService->deleteCoupon($id);

        return redirect('coupons')->with('not_permitted', 'Coupon deleted successfully');
    }
}
