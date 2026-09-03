<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockCount\StoreStockCountRequest;
use App\Http\Requests\StockCount\UpdateStockCountRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\StockCount;
use App\Models\StockCountItem;
use App\Models\Warehouse;
use App\Repositories\Contracts\StockCountRepositoryInterface;
use App\Services\StockCountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class StockCountController extends Controller
{
    protected StockCountService $stockCountService;
    protected StockCountRepositoryInterface $stockCountRepository;

    public function __construct(StockCountService $stockCountService, StockCountRepositoryInterface $stockCountRepository)
    {
        $this->stockCountService = $stockCountService;
        $this->stockCountRepository = $stockCountRepository;
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('purchases-add')) {
            $stock_count = $this->stockCountService->getActiveStockCount();
            if ($stock_count) {
                return redirect()->route('stock-count.show', $stock_count->id);
            }
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            return view('backend.stock_count.create', compact('lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function product()
    {
        return $this->stockCountService->getActiveStockCountProducts();
    }

    public function productSearch(Request $request)
    {
        $stock_count_id = $request->input('stock_count_id');
        if ($stock_count_id) {
            $stock_count = StockCount::find($stock_count_id);
        } else {
            $stock_count = $this->stockCountService->getActiveStockCount();
        }

        if (!$stock_count) {
            return [];
        }

        $search = $request->input('data');
        $query = Product::ActiveStandard()
            ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
            ->where(function ($q) use ($search) {
                $q->where('products.name', 'LIKE', "%{$search}%")
                    ->orWhere('products.code', 'LIKE', "%{$search}%");
            });

        if ($stock_count->warehouse_id) {
            $query->where('product_warehouse.warehouse_id', $stock_count->warehouse_id);
        }

        return $query->select('products.id', 'products.name', 'products.code', 'product_warehouse.qty')
            ->groupBy('products.id')
            ->get();
    }

    public function store(StoreStockCountRequest $request)
    {
        $stockCount = $this->stockCountService->createStockCount($request->all());

        return redirect()->route('stock-count.show', $stockCount->id);
    }

    public function show($id)
    {
        $stock_count = StockCount::findOrFail($id);
        $stock_count_items = StockCountItem::where('stock_count_id', $id)
            ->with('product', 'variant')
            ->get();

        return view('backend.stock_count.show', compact('stock_count', 'stock_count_items'));
    }

    public function update(UpdateStockCountRequest $request, $id)
    {
        $this->stockCountService->updateStockCount($id, $request->all());

        return redirect()->back()->with('message', 'Stock count updated successfully');
    }

    public function finalize(Request $request, $id)
    {
        $this->stockCountService->finalizeStockCount($id);

        return redirect('qty_adjustment')->with('message', 'Stock count finalized successfully');
    }

    public function destroy($id)
    {
        $this->stockCountService->deleteStockCount($id);

        return redirect('qty_adjustment')->with('not_permitted', 'Stock count deleted successfully');
    }
}
