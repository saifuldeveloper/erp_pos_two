<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use App\Repositories\Contracts\AdjustmentRepositoryInterface;
use App\Services\AdjustmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdjustmentController extends Controller
{
    protected AdjustmentService $adjustmentService;
    protected AdjustmentRepositoryInterface $adjustmentRepository;

    public function __construct(AdjustmentService $adjustmentService, AdjustmentRepositoryInterface $adjustmentRepository)
    {
        $this->adjustmentService = $adjustmentService;
        $this->adjustmentRepository = $adjustmentRepository;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('adjustment')) {
            $lims_adjustment_all = $this->adjustmentService->getAllAdjustments();
            return view('backend.adjustment.index', compact('lims_adjustment_all'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getProduct($id)
    {
        return $this->adjustmentService->getWarehouseProductData($id);
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.id', 'products.name', 'products.is_variant', 'product_variants.id as product_variant_id', 'product_variants.item_code')
                ->where([
                    ['product_variants.item_code', $product_code[0]],
                    ['products.is_active', true]
                ])->first();
        }

        $product = [];
        $product[] = $lims_product_data->name;
        $product_variant_id = null;
        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->item_code;
            $product_variant_id = $lims_product_data->product_variant_id;
        } else {
            $product[] = $lims_product_data->code;
        }

        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->unit ? $lims_product_data->unit->unit_code : '';

        return $product;
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('adjustment')) {
            $formData = $this->adjustmentService->getCreateFormData();
            return view('backend.adjustment.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->adjustmentService->createAdjustment($request->all(), $request->file('document'));

        return redirect('qty_adjustment')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('adjustment')) {
            $formData = $this->adjustmentService->getEditFormData($id);
            return view('backend.adjustment.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->adjustmentService->updateAdjustment($id, $request->all(), $request->file('document'));

        return redirect('qty_adjustment')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('adjustment')) {
            return 'Sorry! You are not allowed to delete adjustment';
        }

        $adjustment_ids = $request['adjustmentIdArray'] ?? [];
        $this->adjustmentService->deleteMultipleAdjustments($adjustment_ids);

        return 'Adjustment deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('adjustment')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete adjustment');
        }

        $this->adjustmentService->deleteAdjustment($id);

        return redirect('qty_adjustment')->with('not_permitted', 'Data deleted successfully');
    }
}
