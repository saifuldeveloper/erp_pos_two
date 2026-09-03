<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\CustomField;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\ProductService;
use DNS1D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        if (request()->has('debug')) {
            $test_code = 'A-59dc';
            $p = Product::where('code', $test_code)->first();
            $p_img = $p ? explode(',', $p->image) : [];
            $first_img = $p_img[0] ?? null;

            $paths = [];
            if ($first_img) {
                $check_paths = [
                    'public_path/images/product' => public_path("images/product/" . $first_img),
                    'public_path/public/images/product' => public_path("public/images/product/" . $first_img),
                    'project_root/public/images/product' => base_path("images/product/" . $first_img),
                    'project_root/public/public/images/product' => base_path("public/public/images/product/" . $first_img),
                ];
                foreach ($check_paths as $key => $path) {
                    $exists = file_exists($path);
                    $paths[$key] = [
                        'path' => $path,
                        'exists' => $exists,
                        'readable' => $exists ? is_readable($path) : false,
                        'perms' => $exists ? substr(sprintf('%o', fileperms($path)), -4) : null,
                    ];
                }
            }

            $debug_info = [
                'cwd' => getcwd(),
                'public_path' => public_path(),
                'base_path' => base_path(),
                'test_product' => $p ? [
                    'id' => $p->id,
                    'name' => $p->name,
                    'code' => $p->code,
                    'image_db' => $p->image
                ] : null,
                'first_image' => $first_img,
                'paths_check' => $paths
            ];
            return response()->json($debug_info);
        }

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('products-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $role_id = $role->id;

            $summaryData = $this->productService->getIndexSummaryData();
            $numberOfProduct = $summaryData['numberOfProduct'];
            $custom_fields = $summaryData['customFields'];
            $field_name = $summaryData['fieldNames'];
            $count_data = $summaryData['countData'];
            $brands = $summaryData['brands'];
            $categories = $summaryData['categories'];
            $units = $summaryData['units'];

            return view('backend.product.index', compact('all_permission', 'role_id', 'numberOfProduct', 'custom_fields', 'field_name', 'count_data', 'brands', 'categories', 'units'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function productData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->productService->getProductDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create()
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('products-add')) {
            $formData = $this->productService->getCreateFormData();
            return view('backend.product.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct(
            $request->all(),
            $request->file('image'),
            $request->file('file'),
            $request->file('color_images')
        );

        return redirect('products')->with('create_message', 'Product created successfully');
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('products-edit')) {
            $formData = $this->productService->getEditFormData($id);
            return view('backend.product.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function updateProduct(UpdateProductRequest $request)
    {
        $this->productService->updateProduct(
            $request->input('id'),
            $request->all(),
            $request->file('image'),
            $request->file('file'),
            $request->input('prev_img'),
            $request->file('color_images')
        );

        return redirect('products')->with('edit_message', 'Product updated successfully');
    }

    public function history(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('product_history')) {
            $warehouse_id = $request->input('warehouse_id', 0);

            if ($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime('-1 year'));
                $ending_date = date("Y-m-d");
            }
            $product_id = $request->input('product_id');
            $product_data = Product::select('id', 'name', 'code')->find($product_id);
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();

            return view('backend.product.history', compact('starting_date', 'ending_date', 'warehouse_id', 'product_id', 'product_data', 'lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function saleHistoryData(Request $request)
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $product_id = $request->input('product_id');
        $warehouse_id = $request->input('warehouse_id');

        $q = DB::table('sales')
            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')
            ->where('product_sales.product_id', $product_id)
            ->whereDate('sales.created_at', '>=', $request->input('starting_date'))
            ->whereDate('sales.created_at', '<=', $request->input('ending_date'));

        if ($warehouse_id) {
            $q = $q->where('warehouse_id', $warehouse_id);
        }
        if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q = $q->where('sales.user_id', Auth::id());
        }

        $totalData = $q->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length') != -1 ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $order = 'sales.' . ($columns[$request->input('order.0.column')] ?? 'created_at');
        $dir = $request->input('order.0.dir', 'desc');

        $q = $q->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->join('warehouses', 'sales.warehouse_id', '=', 'warehouses.id')
            ->select('sales.id', 'sales.reference_no', 'sales.created_at', 'customers.name as customer_name', 'customers.phone_number as customer_number', 'warehouses.name as warehouse_name', 'product_sales.qty', 'product_sales.sale_unit_id', 'product_sales.total')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

        if (empty($request->input('search.value'))) {
            $sales = $q->get();
        } else {
            $search = $request->input('search.value');
            $q = $q->whereDate('sales.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $search))));
            if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $sales = $q->orwhere([
                    ['sales.reference_no', 'LIKE', "%{$search}%"],
                    ['sales.user_id', Auth::id()]
                ])->get();
                $totalFiltered = $q->orwhere([
                    ['sales.reference_no', 'LIKE', "%{$search}%"],
                    ['sales.user_id', Auth::id()]
                ])->count();
            } else {
                $sales = $q->orwhere('sales.reference_no', 'LIKE', "%{$search}%")->get();
                $totalFiltered = $q->orwhere('sales.reference_no', 'LIKE', "%{$search}%")->count();
            }
        }

        $data = [];
        if (!empty($sales)) {
            foreach ($sales as $key => $sale) {
                $nestedData['id'] = $sale->id;
                $nestedData['key'] = $key;
                $nestedData['date'] = date(config('date_format'), strtotime($sale->created_at));
                $nestedData['reference_no'] = $sale->reference_no;
                $nestedData['warehouse'] = $sale->warehouse_name;
                $nestedData['customer'] = $sale->customer_name . ' [' . ($sale->customer_number) . ']';
                $nestedData['qty'] = number_format($sale->qty, config('decimal'));
                if ($sale->sale_unit_id) {
                    $unit_data = DB::table('units')->select('unit_code')->find($sale->sale_unit_id);
                    $nestedData['qty'] .= ' ' . ($unit_data->unit_code ?? '');
                }
                $nestedData['unit_price'] = number_format(($sale->total / ($sale->qty ?: 1)), config('decimal'));
                $nestedData['sub_total'] = number_format($sale->total, config('decimal'));
                $data[] = $nestedData;
            }
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
    }

    public function purchaseHistoryData(Request $request)
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $product_id = $request->input('product_id');
        $warehouse_id = $request->input('warehouse_id');

        $q = DB::table('purchases')
            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')
            ->where('product_purchases.product_id', $product_id)
            ->whereDate('purchases.created_at', '>=', $request->input('starting_date'))
            ->whereDate('purchases.created_at', '<=', $request->input('ending_date'));

        if ($warehouse_id) {
            $q = $q->where('warehouse_id', $warehouse_id);
        }
        if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q = $q->where('purchases.user_id', Auth::id());
        }

        $totalData = $q->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length') != -1 ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $order = 'purchases.' . ($columns[$request->input('order.0.column')] ?? 'created_at');
        $dir = $request->input('order.0.dir', 'desc');

        $q = $q->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('warehouses', 'purchases.warehouse_id', '=', 'warehouses.id')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

        if (empty($request->input('search.value'))) {
            $purchases = $q->select('purchases.id', 'purchases.reference_no', 'purchases.created_at', 'purchases.supplier_id', 'suppliers.name as supplier_name', 'suppliers.phone_number as supplier_number', 'warehouses.name as warehouse_name', 'product_purchases.qty', 'product_purchases.purchase_unit_id', 'product_purchases.total')->get();
        } else {
            $search = $request->input('search.value');
            $q = $q->whereDate('purchases.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $search))));
            if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $purchases = $q->select('purchases.id', 'purchases.reference_no', 'purchases.created_at', 'purchases.supplier_id', 'suppliers.name as supplier_name', 'suppliers.phone_number as supplier_number', 'warehouses.name as warehouse_name', 'product_purchases.qty', 'product_purchases.purchase_unit_id', 'product_purchases.total')
                    ->orwhere([
                        ['purchases.reference_no', 'LIKE', "%{$search}%"],
                        ['purchases.user_id', Auth::id()]
                    ])->get();
                $totalFiltered = $q->orwhere([
                    ['purchases.reference_no', 'LIKE', "%{$search}%"],
                    ['purchases.user_id', Auth::id()]
                ])->count();
            } else {
                $purchases = $q->select('purchases.id', 'purchases.reference_no', 'purchases.created_at', 'purchases.supplier_id', 'suppliers.name as supplier_name', 'suppliers.phone_number as supplier_number', 'warehouses.name as warehouse_name', 'product_purchases.qty', 'product_purchases.purchase_unit_id', 'product_purchases.total')
                    ->orwhere('purchases.reference_no', 'LIKE', "%{$search}%")
                    ->get();
                $totalFiltered = $q->orwhere('purchases.reference_no', 'LIKE', "%{$search}%")->count();
            }
        }

        $data = [];
        if (!empty($purchases)) {
            foreach ($purchases as $key => $purchase) {
                $nestedData['id'] = $purchase->id;
                $nestedData['key'] = $key;
                $nestedData['date'] = date(config('date_format'), strtotime($purchase->created_at));
                $nestedData['reference_no'] = $purchase->reference_no;
                $nestedData['warehouse'] = $purchase->warehouse_name;
                $nestedData['supplier'] = $purchase->supplier_id ? ($purchase->supplier_name . ' [' . $purchase->supplier_number . ']') : 'N/A';
                $nestedData['qty'] = number_format($purchase->qty, config('decimal'));
                if ($purchase->purchase_unit_id) {
                    $unit_data = DB::table('units')->select('unit_code')->find($purchase->purchase_unit_id);
                    $nestedData['qty'] .= ' ' . ($unit_data->unit_code ?? '');
                }
                $nestedData['unit_cost'] = $purchase->qty > 0 ? number_format(($purchase->total / $purchase->qty), config('decimal')) : '0.00';
                $nestedData['sub_total'] = number_format($purchase->total, config('decimal'));
                $data[] = $nestedData;
            }
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
    }

    public function saleReturnHistoryData(Request $request)
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $product_id = $request->input('product_id');
        $warehouse_id = $request->input('warehouse_id');

        $q = DB::table('returns')
            ->join('product_returns', 'returns.id', '=', 'product_returns.return_id')
            ->where('product_returns.product_id', $product_id)
            ->whereDate('returns.created_at', '>=', $request->input('starting_date'))
            ->whereDate('returns.created_at', '<=', $request->input('ending_date'));

        if ($warehouse_id) {
            $q = $q->where('warehouse_id', $warehouse_id);
        }
        if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q = $q->where('returns.user_id', Auth::id());
        }

        $totalData = $q->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length') != -1 ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $order = 'returns.' . ($columns[$request->input('order.0.column')] ?? 'created_at');
        $dir = $request->input('order.0.dir', 'desc');

        $q = $q->join('customers', 'returns.customer_id', '=', 'customers.id')
            ->join('warehouses', 'returns.warehouse_id', '=', 'warehouses.id')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

        if (empty($request->input('search.value'))) {
            $returnss = $q->select('returns.id', 'returns.reference_no', 'returns.created_at', 'customers.name as customer_name', 'customers.phone_number as customer_number', 'warehouses.name as warehouse_name', 'product_returns.qty', 'product_returns.sale_unit_id', 'product_returns.total')->get();
        } else {
            $search = $request->input('search.value');
            $q = $q->whereDate('returns.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $search))));
            if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $returnss = $q->select('returns.id', 'returns.reference_no', 'returns.created_at', 'customers.name as customer_name', 'customers.phone_number as customer_number', 'warehouses.name as warehouse_name', 'product_returns.qty', 'product_returns.sale_unit_id', 'product_returns.total')
                    ->orwhere([
                        ['returns.reference_no', 'LIKE', "%{$search}%"],
                        ['returns.user_id', Auth::id()]
                    ])->get();
                $totalFiltered = $q->orwhere([
                    ['returns.reference_no', 'LIKE', "%{$search}%"],
                    ['returns.user_id', Auth::id()]
                ])->count();
            } else {
                $returnss = $q->select('returns.id', 'returns.reference_no', 'returns.created_at', 'customers.name as customer_name', 'customers.phone_number as customer_number', 'warehouses.name as warehouse_name', 'product_returns.qty', 'product_returns.sale_unit_id', 'product_returns.total')
                    ->orwhere('returns.reference_no', 'LIKE', "%{$search}%")
                    ->get();
                $totalFiltered = $q->orwhere('returns.reference_no', 'LIKE', "%{$search}%")->count();
            }
        }

        $data = [];
        if (!empty($returnss)) {
            foreach ($returnss as $key => $returns) {
                $nestedData['id'] = $returns->id;
                $nestedData['key'] = $key;
                $nestedData['date'] = date(config('date_format'), strtotime($returns->created_at));
                $nestedData['reference_no'] = $returns->reference_no;
                $nestedData['warehouse'] = $returns->warehouse_name;
                $nestedData['customer'] = $returns->customer_name . ' [' . ($returns->customer_number) . ']';
                $nestedData['qty'] = number_format($returns->qty, config('decimal'));
                if ($returns->sale_unit_id) {
                    $unit_data = DB::table('units')->select('unit_code')->find($returns->sale_unit_id);
                    $nestedData['qty'] .= ' ' . ($unit_data->unit_code ?? '');
                }
                $nestedData['unit_price'] = number_format(($returns->total / ($returns->qty ?: 1)), config('decimal'));
                $nestedData['sub_total'] = number_format($returns->total, config('decimal'));
                $data[] = $nestedData;
            }
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
    }

    public function purchaseReturnHistoryData(Request $request)
    {
        $columns = [
            1 => 'created_at',
            2 => 'reference_no',
        ];

        $product_id = $request->input('product_id');
        $warehouse_id = $request->input('warehouse_id');

        $q = DB::table('return_purchases')
            ->join('purchase_product_return', 'return_purchases.id', '=', 'purchase_product_return.return_id')
            ->where('purchase_product_return.product_id', $product_id)
            ->whereDate('return_purchases.created_at', '>=', $request->input('starting_date'))
            ->whereDate('return_purchases.created_at', '<=', $request->input('ending_date'));

        if ($warehouse_id) {
            $q = $q->where('warehouse_id', $warehouse_id);
        }
        if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q = $q->where('return_purchases.user_id', Auth::id());
        }

        $totalData = $q->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length') != -1 ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $order = 'return_purchases.' . ($columns[$request->input('order.0.column')] ?? 'created_at');
        $dir = $request->input('order.0.dir', 'desc');

        $q = $q->leftJoin('suppliers', 'return_purchases.supplier_id', '=', 'suppliers.id')
            ->join('warehouses', 'return_purchases.warehouse_id', '=', 'warehouses.id')
            ->select('return_purchases.id', 'return_purchases.reference_no', 'return_purchases.created_at', 'return_purchases.supplier_id', 'suppliers.name as supplier_name', 'suppliers.phone_number as supplier_number', 'warehouses.name as warehouse_name', 'purchase_product_return.qty', 'purchase_product_return.purchase_unit_id', 'purchase_product_return.total')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

        if (empty($request->input('search.value'))) {
            $return_purchases = $q->get();
        } else {
            $search = $request->input('search.value');
            $q = $q->whereDate('return_purchases.created_at', '=', date('Y-m-d', strtotime(str_replace('/', '-', $search))));

            if (Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $return_purchases = $q->orwhere([
                    ['return_purchases.reference_no', 'LIKE', "%{$search}%"],
                    ['return_purchases.user_id', Auth::id()]
                ])->get();
                $totalFiltered = $q->orwhere([
                    ['return_purchases.reference_no', 'LIKE', "%{$search}%"],
                    ['return_purchases.user_id', Auth::id()]
                ])->count();
            } else {
                $return_purchases = $q->orwhere('return_purchases.reference_no', 'LIKE', "%{$search}%")->get();
                $totalFiltered = $q->orwhere('return_purchases.reference_no', 'LIKE', "%{$search}%")->count();
            }
        }

        $data = [];
        if (!empty($return_purchases)) {
            foreach ($return_purchases as $key => $return_purchase) {
                $nestedData['id'] = $return_purchase->id;
                $nestedData['key'] = $key;
                $nestedData['date'] = date(config('date_format'), strtotime($return_purchase->created_at));
                $nestedData['reference_no'] = $return_purchase->reference_no;
                $nestedData['warehouse'] = $return_purchase->warehouse_name;
                $nestedData['supplier'] = $return_purchase->supplier_id ? ($return_purchase->supplier_name . ' [' . $return_purchase->supplier_number . ']') : 'N/A';
                $nestedData['qty'] = number_format($return_purchase->qty, config('decimal'));
                if ($return_purchase->purchase_unit_id) {
                    $unit_data = DB::table('units')->select('unit_code')->find($return_purchase->purchase_unit_id);
                    $nestedData['qty'] .= ' ' . ($unit_data->unit_code ?? '');
                }
                $nestedData['unit_cost'] = number_format(($return_purchase->total / ($return_purchase->qty ?: 1)), config('decimal'));
                $nestedData['sub_total'] = number_format($return_purchase->total, config('decimal'));
                $data[] = $nestedData;
            }
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
    }

    public function variantData($id)
    {
        return $this->productRepository->getVariantDataByProductId(
            $id,
            Auth::user()->role_id,
            Auth::user()->warehouse_id
        );
    }

    public function generateCode()
    {
        return Product::getNextId();
    }

    public function search(Request $request)
    {
        $product_code = explode(" ", $request['data']);
        $lims_product_data = Product::where('code', $product_code[0])->first();

        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;
        $product[] = $lims_product_data->qty;
        $product[] = $lims_product_data->price;
        $product[] = $lims_product_data->id;

        return $product;
    }

    public function saleUnit($id)
    {
        $unit = Unit::where("base_unit", $id)->orWhere('id', $id)->pluck('unit_name', 'id');
        return json_encode($unit);
    }

    public function getData($id, $variant_id)
    {
        if ($variant_id) {
            $data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.name', 'product_variants.item_code')
                ->where([
                    ['products.id', $id],
                    ['product_variants.variant_id', $variant_id]
                ])->first();
            $data->code = $data->item_code;
        } else {
            $data = Product::select('name', 'code')->find($id);
        }

        return $data;
    }

    public function productWarehouseData($id)
    {
        $warehouse = [];
        $qty = [];
        $batch = [];
        $expired_date = [];
        $imei_number = [];
        $warehouse_name = [];
        $variant_name = [];
        $variant_qty = [];

        $lims_product_data = Product::select('id', 'is_variant')->find($id);
        if ($lims_product_data->is_variant) {
            $lims_product_variant_warehouse_data = Product_Warehouse::where('product_id', $lims_product_data->id)->orderBy('warehouse_id')->get();
            $lims_product_warehouse_data = Product_Warehouse::select('warehouse_id', DB::raw('sum(qty) as qty'))->where('product_id', $id)->groupBy('warehouse_id')->get();
            foreach ($lims_product_variant_warehouse_data as $key => $product_variant_warehouse_data) {
                $lims_warehouse_data = Warehouse::find($product_variant_warehouse_data->warehouse_id);
                $lims_variant_data = Variant::find($product_variant_warehouse_data->variant_id);
                $warehouse_name[] = $lims_warehouse_data->name ?? '';
                $variant_name[] = $lims_variant_data->name ?? '';
                $variant_qty[] = $product_variant_warehouse_data->qty;
            }
        } else {
            $lims_product_warehouse_data = Product_Warehouse::where('product_id', $id)->orderBy('warehouse_id', 'asc')->get();
        }

        foreach ($lims_product_warehouse_data as $key => $product_warehouse_data) {
            $lims_warehouse_data = Warehouse::find($product_warehouse_data->warehouse_id);
            if ($product_warehouse_data->product_batch_id) {
                $product_batch_data = ProductBatch::select('batch_no', 'expired_date')->find($product_warehouse_data->product_batch_id);
                $batch_no = $product_batch_data->batch_no;
                $expiredDate = date(config('date_format'), strtotime($product_batch_data->expired_date));
            } else {
                $batch_no = 'N/A';
                $expiredDate = 'N/A';
            }
            $warehouse[] = $lims_warehouse_data->name ?? '';
            $batch[] = $batch_no;
            $expired_date[] = $expiredDate;
            $qty[] = $product_warehouse_data->qty;
            $imei_number[] = $product_warehouse_data->imei_number ?: 'N/A';
        }

        $product_warehouse = [$warehouse, $qty, $batch, $expired_date, $imei_number];
        $product_variant_warehouse = [$warehouse_name, $variant_name, $variant_qty];

        return ['product_warehouse' => $product_warehouse, 'product_variant_warehouse' => $product_variant_warehouse];
    }

    public function printBarcode(Request $request)
    {
        if ($request->input('data')) {
            $preLoadedproducts = $this->limsProductSearch($request);
        } else {
            $preLoadedproducts = null;
        }

        $lims_product_list = $this->products();

        return view('backend.product.print_barcode_custom_desing', compact('lims_product_list', 'preLoadedproducts'));
    }

    public function printBarcodePage(Request $request)
    {
        $productCodes = $request->code;
        $products = [];
        $print_qty = $request->qty;

        [$lims_product_data, $lims_variant_data] = $this->productRepository->getProductsAndVariantsByCodes($productCodes);
        $all_products = $lims_product_data->concat($lims_variant_data);

        foreach ($all_products as $key => $product_data) {
            $variant_id = $product_data->variant_id ?? '';
            $additional_price = $product_data->additional_price ?? 0;
            $qty = isset($print_qty[$key]) ? $print_qty[$key] : 1;

            $product = [];
            $product['name'] = $product_data->name;
            $product['code'] = $product_data->is_variant ? $product_data->item_code : $product_data->code;
            $product['price'] = $product_data->price + $additional_price;
            $product['barcode'] = DNS1D::getBarcodePNG($product_data->code, $product_data->barcode_symbology);
            $product['promotion_price'] = $product_data->promotion_price;
            $product['currency'] = config('currency');
            $product['currency_position'] = config('currency_position');
            $product['id'] = $product_data->id;
            $product['varient_id'] = $variant_id;

            $variant_name = Variant::find($variant_id)->name ?? null;
            $variant_parts = explode('/', (string) $variant_name);
            $product['varient_color'] = $variant_parts[0] ?? '';
            $product['variant_size'] = $variant_parts[1] ?? null;
            $product['count'] = $qty;
            $products[] = $product;
        }

        return view('backend.product.print_page', compact('products'));
    }

    public function products()
    {
        return $this->productRepository->getActiveStandardProducts();
    }

    public function productWithoutVariant()
    {
        return $this->productRepository->getProductsWithoutVariant();
    }

    public function productWithVariant()
    {
        return $this->productRepository->getProductsWithVariant();
    }

    public function limsProductSearch(Request $request)
    {
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");

        $lims_product_data = $this->productRepository->searchForPos($product_code[0]);

        $products = [];
        foreach ($lims_product_data as $key => $product_data) {
            $variant_id = $product_data->variant_id ?? '';
            $additional_price = $product_data->additional_price ?? 0;

            $product = [];
            $product[] = $product_data->name;
            $product[] = $product_data->is_variant ? $product_data->item_code : $product_data->code;
            $product[] = $product_data->price + $additional_price;
            $product[] = DNS1D::getBarcodePNG($product_data->code, $product_data->barcode_symbology);
            $product[] = $product_data->promotion_price;
            $product[] = config('currency');
            $product[] = config('currency_position');
            $product[] = $product_data->qty;
            $product[] = $product_data->id;
            $product[] = $variant_id;

            $products[] = $product;
        }

        return $products;
    }

    public function checkBatchAvailability($product_id, $batch_no, $warehouse_id)
    {
        $product_batch_data = ProductBatch::where([
            ['product_id', $product_id],
            ['batch_no', $batch_no]
        ])->first();

        if ($product_batch_data) {
            $product_warehouse_data = Product_Warehouse::select('qty')
                ->where([
                    ['product_batch_id', $product_batch_data->id],
                    ['warehouse_id', $warehouse_id]
                ])->first();

            if ($product_warehouse_data) {
                $data['qty'] = $product_warehouse_data->qty;
                $data['product_batch_id'] = $product_batch_data->id;
                $data['expired_date'] = date(config('date_format'), strtotime($product_batch_data->expired_date));
                $data['message'] = 'ok';
            } else {
                $data['qty'] = 0;
                $data['message'] = 'This Batch does not exist in the selected warehouse!';
            }
        } else {
            $data['message'] = 'Wrong Batch Number!';
        }

        return $data;
    }

    public function importProduct(Request $request)
    {
        $upload = $request->file('file');
        if (!$upload || !$upload->isValid()) {
            return redirect()->back()->with('message', 'Uploaded file is not valid.');
        }

        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv') {
            return redirect()->back()->with('message', 'Please upload a CSV file');
        }

        $this->productService->importProducts($upload);

        return redirect('products')->with('import_message', 'Product imported successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('products-delete')) {
            return 'Sorry! You are not allowed to delete product';
        }

        $product_id = $request['productIdArray'];
        $this->productService->deleteMultipleProducts($product_id);

        return 'Product deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('products-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete product');
        }

        $this->productService->deleteProduct($id);

        return redirect('products')->with('message', 'Product deleted successfully');
    }
}
