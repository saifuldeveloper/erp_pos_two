<?php

namespace App\Services;

use App\Enums\ProductType;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\CustomField;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ProductImage;
use App\Models\ProductPurchase;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Purchase;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Variant;
use App\Models\Warehouse;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Traits\CacheForget;
use App\Traits\FileHandleTrait;
use App\Traits\TenantInfo;
use DNS1D;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductService
{
    use CacheForget;
    use FileHandleTrait;
    use TenantInfo;

    protected ProductRepositoryInterface $productRepository;
    protected BrandRepositoryInterface $brandRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected UnitRepositoryInterface $unitRepository;

    /**
     * ProductService constructor.
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        BrandRepositoryInterface $brandRepository,
        CategoryRepositoryInterface $categoryRepository,
        UnitRepositoryInterface $unitRepository
    ) {
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->unitRepository = $unitRepository;
    }

    /**
     * Get all active products.
     *
     * @return Collection
     */
    public function getActiveProducts(): Collection
    {
        return $this->productRepository->getActiveStandardProducts();
    }

    /**
     * Get summary data for product index view.
     *
     * @return array
     */
    public function getIndexSummaryData(): array
    {
        $numberOfProduct = $this->productRepository->countTotalActiveProducts();

        $customFields = CustomField::where([
            ['belongs_to', 'product'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = [];
        foreach ($customFields as $fieldName) {
            $fieldNames[] = str_replace(" ", "_", strtolower($fieldName));
        }

        $total = Product::query()
            ->where('is_active', true)
            ->selectRaw('
                COALESCE(SUM(qty), 0) as total_qty,
                COALESCE(SUM(qty * cost), 0) as total_cost,
                COALESCE(SUM(qty * price), 0) as total_price
            ')
            ->first();

        $countData = [
            'total_qty'   => $total->total_qty ?? 0,
            'total_cost'  => $total->total_cost ?? 0,
            'total_price' => $total->total_price ?? 0,
        ];

        $brands = $this->brandRepository->getActiveBrands();
        $categories = Category::with('parent')->where('is_active', true)->get();
        $units = $this->unitRepository->getActiveUnits();

        return compact('numberOfProduct', 'customFields', 'fieldNames', 'countData', 'brands', 'categories', 'units');
    }

    /**
     * Process DataTables server-side response for product list.
     *
     * @param Request $request
     * @param array $allPermissions
     * @return array
     */
    public function getProductDataTable(Request $request, array $allPermissions): array
    {
        $this->autoHealDoublePublicDirectories();

        $columns = [
            2  => 'name',
            3  => 'code',
            4  => 'brand_id',
            5  => 'category_id',
            6  => 'qty',
            7  => 'unit_id',
            8  => 'price',
            9  => 'cost',
            10 => 'stock_worth'
        ];

        $totalData = $this->productRepository->countTotalActiveProducts();
        $limit = ($request->input('length') != -1) ? (int) $request->input('length') : $totalData;
        $start = (int) $request->input('start');
        $orderColumn = $columns[$request->input('order.0.column')] ?? 'name';
        $order = 'products.' . $orderColumn;
        $dir = $request->input('order.0.dir') ?? 'asc';

        $customFields = CustomField::where([
            ['belongs_to', 'product'],
            ['is_table', true]
        ])->pluck('name');

        $fieldNames = $customFields->map(fn($f) => str_replace(" ", "_", strtolower($f)))->toArray();

        $filters = [
            'name'     => $request->name,
            'code'     => $request->code,
            'brand'    => $request->brand,
            'category' => $request->category,
            'unit'     => $request->unit,
            'qty'      => $request->qty,
            'price'    => $request->price,
            'cost'     => $request->cost,
            'in_stock' => $request->input('in_stock'),
        ];

        $searchValue = $request->input('search.value');

        $products = $this->productRepository->getFilteredProductsForDataTable(
            $start,
            $limit,
            $order,
            $dir,
            $filters,
            $searchValue,
            $fieldNames
        );

        $totalFiltered = $this->productRepository->countFilteredProductsForDataTable(
            $filters,
            $searchValue,
            $fieldNames
        );

        $data = [];
        foreach ($products as $key => $product) {
            $nestedData = [];
            $nestedData['id'] = $product->id;
            $nestedData['key'] = $key;

            $productImages = explode(",", $product->image);
            $productImage = null;
            $imageFolder = 'images/product';

            foreach ($productImages as $img) {
                $img = trim($img);
                if ($img && $img != 'zummXD2dvAtI.png') {
                    if (file_exists(public_path("public/images/product/" . $img)) || file_exists("public/public/images/product/" . $img)) {
                        $productImage = $img;
                        $imageFolder = 'public/images/product';
                        break;
                    } elseif (file_exists(public_path("images/product/" . $img)) || file_exists("public/images/product/" . $img)) {
                        $productImage = $img;
                        $imageFolder = 'images/product';
                        break;
                    } elseif (file_exists(public_path("images/product/small/" . $img))) {
                        $productImage = $img;
                        $imageFolder = 'images/product/small';
                        break;
                    }
                }
            }

            $hasPublicInBase = str_contains(url('/'), '/public');
            $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
            $isDocRootPublic = (str_ends_with(str_replace('\\', '/', $docRoot), '/public') || str_replace('\\', '/', $docRoot) === str_replace('\\', '/', public_path()));

            if ($productImage) {
                $urlFolder = $imageFolder;
                if (!$hasPublicInBase && !$isDocRootPublic) {
                    if (!str_starts_with($urlFolder, 'public/')) {
                        $urlFolder = 'public/' . $urlFolder;
                    }
                } else {
                    if (str_starts_with($urlFolder, 'public/')) {
                        $urlFolder = substr($urlFolder, 7);
                    }
                }
                $nestedData['image'] = '<img src="' . asset("$urlFolder/$productImage") . '" height="80" width="80">';
            } else {
                $fallbackFolder = 'images/product';
                if (!$hasPublicInBase && !$isDocRootPublic) {
                    $fallbackFolder = 'public/' . $fallbackFolder;
                }
                $nestedData['image'] = '<img src="' . asset("$fallbackFolder/zummXD2dvAtI.png") . '" height="80" width="80">';
            }

            $nestedData['name'] = $product->name;
            $nestedData['code'] = $product->code;
            $nestedData['brand'] = $product->brand->title ?? 'N/A';

            if ($product->category) {
                if ($product->category->parent) {
                    $nestedData['category'] = $product->category->parent->name . '-' . $product->category->name;
                } else {
                    $nestedData['category'] = $product->category->name;
                }
            } else {
                $nestedData['category'] = 'N/A';
            }

            $nestedData['qty'] = $product->qty;
            $nestedData['unit'] = $product->unit->unit_name ?? 'N/A';
            $nestedData['price'] = $product->price;
            $nestedData['cost'] = $product->cost;

            if (config('currency_position') == 'prefix') {
                $nestedData['stock_worth'] = config('currency') . ' ' . ($product->qty * $product->price) . ' / ' . config('currency') . ' ' . ($product->qty * $product->cost);
            } else {
                $nestedData['stock_worth'] = ($product->qty * $product->price) . ' ' . config('currency') . ' / ' . ($product->qty * $product->cost) . ' ' . config('currency');
            }

            foreach ($fieldNames as $fieldName) {
                $nestedData[$fieldName] = $product->$fieldName;
            }

            $options = '<div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                . trans("file.action") .
                '<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
            <li><button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> ' . trans('file.View') . '</button></li>';

            if (in_array("products-edit", $allPermissions)) {
                $options .= '<li><a href="' . route('products.edit', $product->id) . '" class="btn btn-link"><i class="fa fa-edit"></i> ' . trans('file.edit') . '</a></li>';
            }

            if (in_array("product_history", $allPermissions)) {
                $options .= \Form::open(["route" => "products.history", "method" => "GET"]) . '
                <li><input type="hidden" name="product_id" value="' . $product->id . '" />
                <button type="submit" class="btn btn-link"><i class="dripicons-checklist"></i> ' . trans("file.Product History") . '</button></li>' . \Form::close();
            }

            if (in_array("print_barcode", $allPermissions)) {
                $product_info = $product->code . ' (' . $product->name . ')';
                $options .= \Form::open(["route" => "product.printBarcode", "method" => "GET"]) . '
                <li><input type="hidden" name="data" value="' . $product_info . '" />
                <button type="submit" class="btn btn-link"><i class="dripicons-print"></i> ' . trans("file.print_barcode") . '</button></li>' . \Form::close();
            }

            if (in_array("products-delete", $allPermissions)) {
                $options .= \Form::open(["route" => ["products.destroy", $product->id], "method" => "DELETE"]) . '
                <li><button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> ' . trans("file.delete") . '</button></li>' . \Form::close();
            }

            $options .= '</ul></div>';
            $nestedData['options'] = $options;

            $tax = $product->tax_id ? Tax::find($product->tax_id)->name : "N/A";
            $taxMethod = $product->tax_method == 1 ? trans('file.Exclusive') : trans('file.Inclusive');

            $nestedData['product'] = [
                '["' . $product->type . '"',
                '"' . $product->name . '"',
                '"' . $product->code . '"',
                '"' . $nestedData['brand'] . '"',
                '"' . $nestedData['category'] . '"',
                '"' . $nestedData['unit'] . '"',
                '"' . $product->cost . '"',
                '"' . $product->price . '"',
                '"' . $tax . '"',
                '"' . $taxMethod . '"',
                '"' . $product->alert_quantity . '"',
                '"' . preg_replace('/\s+/S', " ", $product->product_details) . '"',
                '"' . $product->id . '"',
                '"' . $product->product_list . '"',
                '"' . $product->variant_list . '"',
                '"' . $product->qty_list . '"',
                '"' . $product->price_list . '"',
                '"' . $product->qty . '"',
                '"' . $product->image . '"',
                '"' . $product->is_variant . '"]'
            ];

            $nestedData['colorImages'] = $product->productImages;
            $nestedData['variant_value'] = $product->variant_value;

            $data[] = $nestedData;
        }

        $filteredTotals = $this->productRepository->getFilteredTotals($filters, $searchValue, $fieldNames);

        return [
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
            "total_qty"       => $filteredTotals ? $filteredTotals->total_qty : 0,
            "total_cost"      => $filteredTotals ? round($filteredTotals->total_cost, 2) : 0,
            "total_price"     => $filteredTotals ? $filteredTotals->total_price : 0,
        ];
    }

    /**
     * Get data required for create product view.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $nextProductCode = Product::getNextId();
        $lims_product_list_without_variant = $this->productRepository->getProductsWithoutVariant();
        $lims_product_list_with_variant = $this->productRepository->getProductsWithVariant();
        $lims_brand_list = $this->brandRepository->getActiveBrands();
        $lims_category_list = Category::where('is_active', 1)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
        $lims_unit_list = $this->unitRepository->getActiveUnits();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $numberOfProduct = $this->productRepository->countTotalActiveProducts();
        $custom_fields = CustomField::where('belongs_to', 'product')->get();
        $colors = Color::orderBy('name')->get();

        return compact(
            'nextProductCode',
            'lims_product_list_without_variant',
            'lims_product_list_with_variant',
            'lims_brand_list',
            'lims_category_list',
            'lims_unit_list',
            'lims_tax_list',
            'lims_warehouse_list',
            'numberOfProduct',
            'custom_fields',
            'colors'
        );
    }

    /**
     * Create a new product.
     *
     * @param array $requestData
     * @param array|null $images
     * @param UploadedFile|null $file
     * @param array|null $colorImages
     * @return Product
     */
    public function createProduct(array $requestData, ?array $images = [], ?UploadedFile $file = null, ?array $colorImages = []): Product
    {
        $category = Category::with('parent')->find($requestData['category_id']);
        $newName = $category->parent->name . '-' . $category->name;

        $data = $requestData;
        unset($data['image'], $data['file']);

        if (isset($data['is_variant'])) {
            $data['variant_option'] = json_encode($data['variant_option']);
            $data['variant_value'] = array_map(function ($item) {
                return is_array($item) ? implode(',', $item) : $item;
            }, $data['variant_value']);
            $data['variant_value'] = json_encode($data['variant_value']);
        } else {
            $data['variant_option'] = $data['variant_value'] = null;
        }

        $data['name'] = $newName;
        $data['slug'] = Str::slug($data['name'], '-');
        $data['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '', $data['slug']);
        $data['slug'] = str_replace('\/', '/', $data['slug']);

        if (($data['type'] ?? '') == ProductType::COMBO->value) {
            $data['product_list'] = implode(",", $data['product_id']);
            $data['variant_list'] = implode(",", $data['variant_id']);
            $data['qty_list'] = implode(",", $data['product_qty']);
            $data['price_list'] = implode(",", $data['unit_price']);
            $data['cost'] = $data['unit_id'] = $data['purchase_unit_id'] = $data['sale_unit_id'] = 0;
        } elseif (($data['type'] ?? '') == 'digital' || ($data['type'] ?? '') == 'service') {
            $data['cost'] = $data['unit_id'] = $data['purchase_unit_id'] = $data['sale_unit_id'] = 0;
        }

        if (isset($data['product_details'])) {
            $data['product_details'] = str_replace('"', '@', $data['product_details']);
        }

        if (!empty($data['starting_date'])) {
            $data['starting_date'] = date('Y-m-d', strtotime($data['starting_date']));
        }
        if (!empty($data['last_date'])) {
            $data['last_date'] = date('Y-m-d', strtotime($data['last_date']));
        }

        $data['is_active'] = true;

        if (!empty($images)) {
            $imageNames = [];
            foreach ($images as $key => $image) {
                $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageName = date("Ymdhis") . ($key + 1);
                $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                $image->move(public_path('images/product'), $imageName);
                $imageNames[] = $imageName;
            }
            $data['image'] = implode(",", $imageNames);
        } else {
            $data['image'] = 'zummXD2dvAtI.png';
        }

        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $fileName = strtotime(date('Y-m-d H:i:s')) . '.' . $ext;
            $file->move(public_path('product/files'), $fileName);
            $data['file'] = $fileName;
        }

        if (!isset($data['is_sync_disable']) && Schema::hasColumn('products', 'is_sync_disable')) {
            $data['is_sync_disable'] = null;
        }

        $product = $this->productRepository->create($data);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'product')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($data[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $data[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $data[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('products')->where('id', $product->id)->update($customFieldData);
        }

        // Initial stock and auto purchase
        $initialStock = 0;
        if (isset($data['is_initial_stock']) && !isset($data['is_variant']) && !isset($data['is_batch'])) {
            foreach ($data['stock_warehouse_id'] as $key => $warehouseId) {
                $stock = $data['stock'][$key];
                if ($stock > 0) {
                    $this->autoPurchase($product, $warehouseId, $stock);
                    $initialStock += $stock;
                }
            }
        }

        if ($initialStock > 0) {
            $product->qty += $initialStock;
            $product->save();
        }

        // Variants
        $variantIds = [];
        if (isset($data['is_variant'])) {
            foreach ($data['variant_name'] as $key => $variantName) {
                $variant = Variant::firstOrCreate(['name' => $data['variant_name'][$key]]);
                $variant->name = $data['variant_name'][$key];
                $variant->save();
                $variantIds[] = $variant->id;

                $productVariant = new ProductVariant();
                $productVariant->product_id = $product->id;
                $productVariant->variant_id = $variant->id;
                $productVariant->position = $key + 1;
                $productVariant->item_code = $data['item_code'][$key];
                $productVariant->additional_cost = $data['additional_cost'][$key];
                $productVariant->additional_price = $data['additional_price'][$key];
                $productVariant->qty = 0;
                $productVariant->save();
            }
        }

        // Differential pricing & warehouses
        if (isset($data['is_diffPrice'])) {
            foreach ($data['diff_price'] as $key => $diffPrice) {
                if ($diffPrice) {
                    Product_Warehouse::create([
                        "product_id"   => $product->id,
                        "warehouse_id" => $data["warehouse_id"][$key],
                        "qty"          => 0,
                        "price"        => $diffPrice
                    ]);
                }
            }
        } elseif (!isset($data['is_initial_stock']) && !isset($data['is_batch']) && config('without_stock') == 'yes') {
            $warehouseIds = Warehouse::where('is_active', true)->pluck('id');
            foreach ($warehouseIds as $warehouseId) {
                if (count($variantIds)) {
                    foreach ($variantIds as $variantId) {
                        Product_Warehouse::create([
                            "product_id"   => $product->id,
                            "variant_id"   => $variantId,
                            "warehouse_id" => $warehouseId,
                            "qty"          => 0,
                        ]);
                    }
                } else {
                    Product_Warehouse::create([
                        "product_id"   => $product->id,
                        "warehouse_id" => $warehouseId,
                        "qty"          => 0,
                    ]);
                }
            }
        }

        // Color Images
        if (isset($data['is_variant'])) {
            $colors = $requestData['variant_value'][0] ?? [];
            if (is_array($colors)) {
                foreach ($colors as $color) {
                    $colorData = Color::firstOrCreate(['name' => $color]);
                    $colorData->name = $color;
                    $colorData->save();
                }
            }
            if (!empty($colorImages)) {
                foreach ($colorImages as $key => $colorImage) {
                    $color = Color::where('name', $key)->first();
                    if ($color) {
                        $ext = pathinfo($colorImage->getClientOriginalName(), PATHINFO_EXTENSION);
                        $imageName = date("Ymdhis") . $key . uniqid();
                        $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                        $colorImage->move(public_path('images/product'), $imageName);

                        $productImg = new ProductImage();
                        $productImg->product_id = $product->id;
                        $productImg->color_id = $color->id;
                        $productImg->image = $imageName;
                        $productImg->save();
                    }
                }
            }
        }

        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');

        return $product;
    }

    /**
     * Auto purchase creation for initial stock.
     */
    public function autoPurchase($productData, $warehouseId, $stock): void
    {
        $data = [
            'reference_no'   => 'pr-' . date("Ymd") . '-' . date("his"),
            'user_id'        => Auth::id(),
            'warehouse_id'   => $warehouseId,
            'item'           => 1,
            'total_qty'      => $stock,
            'total_discount' => 0,
            'status'         => 1,
            'payment_status' => 2,
        ];

        if ($productData->tax_id) {
            $taxData = DB::table('taxes')->select('rate')->find($productData->tax_id);
            if ($productData->tax_method == 1) {
                $netUnitCost = number_format($productData->cost, 2, '.', '');
                $tax = number_format($productData->cost * $stock * ($taxData->rate / 100), 2, '.', '');
                $cost = number_format(($productData->cost * $stock) + $tax, 2, '.', '');
            } else {
                $netUnitCost = number_format((100 / (100 + $taxData->rate)) * $productData->cost, 2, '.', '');
                $tax = number_format(($productData->cost - $netUnitCost) * $stock, 2, '.', '');
                $cost = number_format($productData->cost * $stock, 2, '.', '');
            }
            $taxRate = $taxData->rate;
            $data['total_tax'] = $tax;
            $data['total_cost'] = $cost;
        } else {
            $data['total_tax'] = 0.00;
            $data['total_cost'] = number_format($productData->cost * $stock, 2, '.', '');
            $netUnitCost = number_format($productData->cost, 2, '.', '');
            $taxRate = 0.00;
            $tax = 0.00;
            $cost = number_format($productData->cost * $stock, 2, '.', '');
        }

        $productWarehouse = Product_Warehouse::select('id', 'qty')
            ->where([
                ['product_id', $productData->id],
                ['warehouse_id', $warehouseId]
            ])->first();

        if ($productWarehouse) {
            $productWarehouse->qty += $stock;
            $productWarehouse->save();
        } else {
            $lims_product_warehouse = new Product_Warehouse();
            $lims_product_warehouse->product_id = $productData->id;
            $lims_product_warehouse->warehouse_id = $warehouseId;
            $lims_product_warehouse->qty = $stock;
            $lims_product_warehouse->save();
        }

        $data['order_tax'] = 0;
        $data['grand_total'] = $data['total_cost'];
        $data['paid_amount'] = $data['grand_total'];

        $purchase = Purchase::create($data);

        ProductPurchase::create([
            'purchase_id'      => $purchase->id,
            'product_id'       => $productData->id,
            'qty'              => $stock,
            'recieved'         => $stock,
            'purchase_unit_id' => $productData->unit_id,
            'net_unit_cost'    => $netUnitCost,
            'discount'         => 0,
            'tax_rate'         => $taxRate,
            'tax'              => $tax,
            'total'            => $cost,
            'selling_price'    => $productData->price
        ]);

        Payment::create([
            'payment_reference' => 'ppr-' . date("Ymd") . '-' . date("his"),
            'user_id'           => Auth::id(),
            'purchase_id'       => $purchase->id,
            'account_id'        => 0,
            'amount'            => $data['grand_total'],
            'change'            => 0,
            'paying_method'     => 'Cash'
        ]);
    }

    /**
     * Get data required for edit product view.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_product_list_without_variant = $this->productRepository->getProductsWithoutVariant();
        $lims_product_list_with_variant = $this->productRepository->getProductsWithVariant();
        $lims_brand_list = $this->brandRepository->getActiveBrands();
        $lims_category_list = Category::where('is_active', 1)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->get();
        $lims_unit_list = $this->unitRepository->getActiveUnits();
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_product_data = Product::where('id', $id)->first();

        if ($lims_product_data->variant_option) {
            $lims_product_data->variant_option = json_decode($lims_product_data->variant_option);
            $lims_product_data->variant_value = json_decode($lims_product_data->variant_value);
        }

        $lims_product_variant_data = $lims_product_data->variant()->orderBy('position')->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $noOfVariantValue = 0;
        $custom_fields = CustomField::where('belongs_to', 'product')->get();
        $lims_product_data->load('productImages.color');
        $colors = Color::all();
        $lims_product_colors = $lims_product_data->colors()->pluck('name')->toArray();

        return compact(
            'lims_product_list_without_variant',
            'lims_product_list_with_variant',
            'lims_brand_list',
            'lims_category_list',
            'lims_unit_list',
            'lims_tax_list',
            'lims_product_data',
            'lims_product_variant_data',
            'lims_warehouse_list',
            'noOfVariantValue',
            'custom_fields',
            'colors',
            'lims_product_colors'
        );
    }

    /**
     * Update an existing product.
     *
     * @param int|string $id
     * @param array $requestData
     * @param array|null $images
     * @param UploadedFile|null $file
     * @param array|null $prevImages
     * @param array|null $colorImages
     * @return Product
     */
    public function updateProduct(
        $id,
        array $requestData,
        ?array $images = [],
        ?UploadedFile $file = null,
        ?array $prevImages = [],
        ?array $colorImages = []
    ): Product {
        $product = Product::findOrFail($id);

        $category = Category::with('parent')->find($requestData['category_id']);
        $newName = $category->parent->name . '-' . $category->name;

        $data = $requestData;
        unset($data['image'], $data['file'], $data['prev_img']);

        $data['name'] = $newName;
        $data['slug'] = Str::slug($data['name'], '-');
        $data['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '', $data['slug']);
        $data['slug'] = str_replace('\/', '/', $data['slug']);

        if (($data['type'] ?? '') == ProductType::COMBO->value) {
            $data['product_list'] = implode(",", $data['product_id']);
            $data['variant_list'] = implode(",", $data['variant_id']);
            $data['qty_list'] = implode(",", $data['product_qty']);
            $data['price_list'] = implode(",", $data['unit_price']);
            $data['cost'] = $data['unit_id'] = $data['purchase_unit_id'] = $data['sale_unit_id'] = 0;
        } elseif (($data['type'] ?? '') == 'digital' || ($data['type'] ?? '') == 'service') {
            $data['cost'] = $data['unit_id'] = $data['purchase_unit_id'] = $data['sale_unit_id'] = 0;
        }

        $data['featured'] = $data['featured'] ?? 0;
        $data['is_embeded'] = $data['is_embeded'] ?? 0;
        $data['promotion'] = $data['promotion'] ?? null;
        $data['is_batch'] = $data['is_batch'] ?? null;
        $data['is_imei'] = $data['is_imei'] ?? null;

        if (!isset($data['is_sync_disable']) && Schema::hasColumn('products', 'is_sync_disable')) {
            $data['is_sync_disable'] = null;
        }

        if (isset($data['product_details'])) {
            $data['product_details'] = str_replace('"', '@', $data['product_details']);
        }

        if (!empty($data['starting_date'])) {
            $data['starting_date'] = date('Y-m-d', strtotime($data['starting_date']));
        }
        if (!empty($data['last_date'])) {
            $data['last_date'] = date('Y-m-d', strtotime($data['last_date']));
        }

        // Previous images
        $previousImages = [];
        if (!empty($prevImages)) {
            foreach ($prevImages as $prevImg) {
                if (!in_array($prevImg, $previousImages)) {
                    $previousImages[] = $prevImg;
                }
            }
            $product->image = implode(",", $previousImages);
            $product->save();
        } else {
            $product->image = null;
            $product->save();
        }

        // New images
        if (!empty($images)) {
            $imageNames = [];
            $length = count(explode(",", (string) $product->image));
            foreach ($images as $key => $image) {
                $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageName = $this->getTenantId() . '_' . date("Ymdhis") . ($length + $key + 1) . '.' . $ext;
                $image->move(public_path('images/product'), $imageName);
                $imageNames[] = $imageName;
            }
            if ($product->image) {
                $data['image'] = $product->image . ',' . implode(",", $imageNames);
            } else {
                $data['image'] = implode(",", $imageNames);
            }
        } else {
            $data['image'] = $product->image;
        }

        if ($file) {
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $fileName = strtotime(date('Y-m-d H:i:s')) . '.' . $ext;
            $file->move(public_path('product/files'), $fileName);
            $data['file'] = $fileName;
        }

        $oldProductVariantIds = ProductVariant::where('product_id', $id)->pluck('id')->toArray();
        $newProductVariantIds = [];

        if (isset($data['is_variant'])) {
            if (isset($data['variant_option']) && isset($data['variant_value'])) {
                $data['variant_option'] = json_encode($data['variant_option']);
                $data['variant_value'] = array_map(function ($item) {
                    return is_array($item) ? implode(',', $item) : $item;
                }, $data['variant_value']);
                $data['variant_value'] = json_encode($data['variant_value']);
            }
            foreach ($data['variant_name'] as $key => $variantName) {
                $variant = Variant::firstOrCreate(['name' => $data['variant_name'][$key]]);
                $productVariant = ProductVariant::where([
                    ['product_id', $product->id],
                    ['variant_id', $variant->id]
                ])->first();

                if ($productVariant) {
                    $productVariant->update([
                        'position'         => $key + 1,
                        'item_code'        => $data['item_code'][$key],
                        'additional_cost'  => $data['additional_cost'][$key],
                        'additional_price' => $data['additional_price'][$key]
                    ]);
                } else {
                    $productVariant = new ProductVariant();
                    $productVariant->product_id = $product->id;
                    $productVariant->variant_id = $variant->id;
                    $productVariant->position = $key + 1;
                    $productVariant->item_code = $data['item_code'][$key];
                    $productVariant->additional_cost = $data['additional_cost'][$key];
                    $productVariant->additional_price = $data['additional_price'][$key];
                    $productVariant->qty = 0;
                    $productVariant->save();
                }
                $newProductVariantIds[] = $productVariant->id;
            }
        } else {
            $data['is_variant'] = null;
            $data['variant_option'] = null;
            $data['variant_value'] = null;
        }

        foreach ($oldProductVariantIds as $oldVariantId) {
            if (!in_array($oldVariantId, $newProductVariantIds)) {
                $v = ProductVariant::find($oldVariantId);
                if ($v) {
                    $v->delete();
                }
            }
        }

        // Differential pricing
        if (isset($data['is_diffPrice'])) {
            foreach ($data['diff_price'] as $key => $diffPrice) {
                if ($diffPrice) {
                    $productWarehouse = Product_Warehouse::FindProductWithoutVariant($product->id, $data['warehouse_id'][$key])->first();
                    if ($productWarehouse) {
                        $productWarehouse->price = $diffPrice;
                        $productWarehouse->save();
                    } else {
                        Product_Warehouse::create([
                            "product_id"   => $product->id,
                            "warehouse_id" => $data["warehouse_id"][$key],
                            "qty"          => 0,
                            "price"        => $diffPrice
                        ]);
                    }
                }
            }
        } else {
            $data['is_diffPrice'] = false;
            if (isset($data['warehouse_id'])) {
                foreach ($data['warehouse_id'] as $warehouseId) {
                    $productWarehouse = Product_Warehouse::FindProductWithoutVariant($product->id, $warehouseId)->first();
                    if ($productWarehouse) {
                        $productWarehouse->price = null;
                        $productWarehouse->save();
                    }
                }
            }
        }

        $product->update($data);

        // Custom fields
        $customFieldData = [];
        $customFields = CustomField::where('belongs_to', 'product')->select('name', 'type')->get();
        foreach ($customFields as $customField) {
            $fieldName = str_replace(' ', '_', strtolower($customField->name));
            if (isset($data[$fieldName])) {
                if ($customField->type == 'checkbox' || $customField->type == 'multi_select') {
                    $customFieldData[$fieldName] = implode(",", $data[$fieldName]);
                } else {
                    $customFieldData[$fieldName] = $data[$fieldName];
                }
            }
        }
        if (count($customFieldData)) {
            DB::table('products')->where('id', $product->id)->update($customFieldData);
        }

        // Color images
        if (isset($data['is_variant'])) {
            $colors = $requestData['variant_value'][0] ?? [];
            if (is_array($colors)) {
                foreach ($colors as $color) {
                    $colorData = Color::firstOrCreate(['name' => $color]);
                    $colorData->name = $color;
                    $colorData->save();
                }
            }
            if (!empty($colorImages)) {
                foreach ($colorImages as $key => $colorImage) {
                    $color = Color::where('name', $key)->first();
                    if ($color) {
                        $productImage = ProductImage::where('product_id', $product->id)->where('color_id', $color->id)->first();
                        if ($productImage) {
                            $oldImage = $productImage->image;
                            if (file_exists(public_path('images/product/' . $oldImage))) {
                                @unlink(public_path('images/product/' . $oldImage));
                            }
                            if (file_exists(public_path('public/images/product/' . $oldImage))) {
                                @unlink(public_path('public/images/product/' . $oldImage));
                            }

                            $ext = pathinfo($colorImage->getClientOriginalName(), PATHINFO_EXTENSION);
                            $imageName = date("Ymdhis") . $key . uniqid();
                            $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                            $colorImage->move(public_path('images/product'), $imageName);
                            $productImage->image = $imageName;
                            $productImage->save();
                        } else {
                            $ext = pathinfo($colorImage->getClientOriginalName(), PATHINFO_EXTENSION);
                            $imageName = date("Ymdhis") . $key . uniqid();
                            $imageName = $this->getTenantId() . '_' . $imageName . '.' . $ext;
                            $colorImage->move(public_path('images/product'), $imageName);

                            $productImg = new ProductImage();
                            $productImg->product_id = $product->id;
                            $productImg->color_id = $color->id;
                            $productImg->image = $imageName;
                            $productImg->save();
                        }
                    }
                }
            }
        }

        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');

        return $product;
    }

    /**
     * Import products from CSV file.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importProducts(UploadedFile $file): void
    {
        $filePath = $file->getPathname();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        while ($columns = fgetcsv($handle)) {
            if (empty($columns) || (count($columns) === 1 && empty($columns[0]))) {
                continue;
            }
            if (count($columns) < count($escapedHeader)) {
                $columns = array_pad($columns, count($escapedHeader), '');
            } elseif (count($columns) > count($escapedHeader)) {
                $columns = array_slice($columns, 0, count($escapedHeader));
            }

            $data = array_combine($escapedHeader, $columns);
            $data = array_merge([
                'image'           => '',
                'name'            => '',
                'code'            => '',
                'type'            => 'standard',
                'brand'           => '',
                'category'        => '',
                'unitcode'        => '',
                'cost'            => '0',
                'price'           => '0',
                'productdetails'  => '',
                'variantvalue'    => '',
                'variantname'     => '',
                'itemcode'        => '',
                'additionalcost'  => '',
                'additionalprice' => ''
            ], $data);

            if ($data['brand'] != 'N/A' && $data['brand'] != '') {
                $brand = Brand::firstOrCreate(['title' => $data['brand'], 'is_active' => true]);
                $brandId = $brand->id;
            } else {
                $brandId = null;
            }

            $category = Category::firstOrCreate(['name' => $data['category'], 'is_active' => true]);

            $unitVal = trim($data['unitcode']);
            $unit = Unit::where(function ($query) use ($unitVal) {
                $query->where('unit_code', $unitVal)
                    ->orWhere('unit_name', $unitVal);
            })->first();

            if (!$unit) {
                $aliases = [
                    'pc'   => ['pieces', 'piece', 'pc', 'pcs'],
                    'pair' => ['pair', 'pairs', 'pr'],
                    'kg'   => ['kilogram', 'kilograms', 'kg', 'kgs'],
                ];
                $matchedAlias = null;
                foreach ($aliases as $key => $values) {
                    if (in_array(strtolower($unitVal), $values)) {
                        $matchedAlias = $key;
                        break;
                    }
                }
                if ($matchedAlias) {
                    $aliasesToCheck = $aliases[$matchedAlias];
                    $unit = Unit::where(function ($query) use ($aliasesToCheck) {
                        foreach ($aliasesToCheck as $alias) {
                            $query->orWhere('unit_name', 'like', '%' . $alias . '%');
                        }
                    })->first();
                }
            }

            if (!$unit && !empty($unitVal)) {
                $standardNames = [
                    'pc'   => 'Pieces',
                    'pcs'  => 'Pieces',
                    'pair' => 'Pair',
                    'kg'   => 'Kilogram',
                    'g'    => 'Gram',
                    'gm'   => 'Gram',
                    'ltr'  => 'Litre',
                    'l'    => 'Litre',
                    'box'  => 'Box',
                    'pack' => 'Pack'
                ];
                $uName = $standardNames[strtolower($unitVal)] ?? ucfirst($unitVal);

                $unit = Unit::create([
                    'unit_code'       => strtolower($unitVal),
                    'unit_name'       => $uName,
                    'operator'        => '*',
                    'operation_value' => 1.0,
                    'is_active'       => true
                ]);
            }

            if ($unit && empty($unit->unit_code)) {
                $unit->unit_code = strtolower($unitVal);
                $unit->save();
            }

            $product = Product::firstOrNew(['name' => $data['name'], 'is_active' => true]);
            $product->image = !empty($data['image']) ? $data['image'] : 'zummXD2dvAtI.png';
            $product->name = htmlspecialchars(trim($data['name']));
            $product->code = $data['code'];
            $product->type = strtolower($data['type']);
            $product->barcode_symbology = 'C128';
            $product->brand_id = $brandId;
            $product->category_id = $category->id;
            $product->unit_id = $unit ? $unit->id : 1;
            $product->purchase_unit_id = $unit ? $unit->id : 1;
            $product->sale_unit_id = $unit ? $unit->id : 1;
            $product->cost = str_replace(",", "", $data['cost']);
            $product->price = str_replace(",", "", $data['price']);
            $product->tax_method = 1;
            $product->qty = 0;
            $product->product_details = $data['productdetails'];
            $product->is_active = true;
            $product->save();

            $warehouseIds = Warehouse::where('is_active', true)->pluck('id');

            if ($data['variantvalue'] && $data['variantname']) {
                $variantInfo = explode(",", $data['variantvalue']);
                $variantOption = [];
                $variantValue = [];
                foreach ($variantInfo as $info) {
                    $variantOption[] = strtok($info, "[");
                    $variantValue[] = str_replace("/", ",", substr($info, strpos($info, "[") + 1, (strpos($info, "]") - strpos($info, "[") - 1)));
                }
                $product->variant_option = json_encode($variantOption);
                $product->variant_value = json_encode($variantValue);
                $product->is_variant = true;
                $product->save();

                $variantNames = explode(",", $data['variantname']);
                $itemCodes = explode(",", $data['itemcode']);
                $additionalCosts = explode(",", $data['additionalcost']);
                $additionalPrices = explode(",", $data['additionalprice']);

                foreach ($variantNames as $key => $variantName) {
                    $variant = Variant::firstOrCreate(['name' => $variantName]);
                    $itemCode = !empty($data['itemcode']) ? $itemCodes[$key] : $variantName . '-' . $data['code'];
                    $additionalCost = !empty($data['additionalcost']) ? $additionalCosts[$key] : 0;
                    $additionalPrice = !empty($data['additionalprice']) ? $additionalPrices[$key] : 0;

                    ProductVariant::create([
                        'product_id'       => $product->id,
                        'variant_id'       => $variant->id,
                        'position'         => $key + 1,
                        'item_code'        => $itemCode,
                        'additional_cost'  => $additionalCost,
                        'additional_price' => $additionalPrice,
                        'qty'              => 0
                    ]);

                    if (config('without_stock') == 'yes') {
                        foreach ($warehouseIds as $warehouseId) {
                            Product_Warehouse::create([
                                'product_id'   => $product->id,
                                'variant_id'   => $variant->id,
                                'warehouse_id' => $warehouseId,
                                'qty'          => 0
                            ]);
                        }
                    }
                }
            } elseif (config('without_stock') == 'yes') {
                foreach ($warehouseIds as $warehouseIdItem) {
                    Product_Warehouse::create([
                        'product_id'   => $product->id,
                        'warehouse_id' => $warehouseIdItem,
                        'qty'          => 0
                    ]);
                }
            }
        }

        fclose($handle);
        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');
    }

    /**
     * Deactivate a product and delete its images.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteProduct($id): bool
    {
        $product = $this->productRepository->deactivateProduct($id);
        if ($product && $product->image && $product->image != 'zummXD2dvAtI.png') {
            $images = explode(",", $product->image);
            foreach ($images as $image) {
                $this->fileDelete('images/product/', $image);
                $this->fileDelete('images/product/large/', $image);
                $this->fileDelete('images/product/medium/', $image);
                $this->fileDelete('images/product/small/', $image);
            }
        }

        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');

        return true;
    }

    /**
     * Deactivate multiple products and delete their images.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleProducts(array $ids): bool
    {
        $products = $this->productRepository->deactivateMultipleProducts($ids);
        foreach ($products as $product) {
            if ($product->image) {
                $images = explode(",", $product->image);
                foreach ($images as $image) {
                    $this->fileDelete('images/product/', $image);
                }
            }
        }

        $this->cacheForget('product_list');
        $this->cacheForget('product_list_with_variant');

        return true;
    }

    /**
     * Helper to auto-heal double public directories.
     */
    protected function autoHealDoublePublicDirectories(): void
    {
        $doublePublicDir = public_path('public/images/product');
        $targetDir = public_path('images/product');
        if (is_dir($doublePublicDir)) {
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            $files = @scandir($doublePublicDir);
            if ($files) {
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $sourceFile = $doublePublicDir . '/' . $file;
                        $targetFile = $targetDir . '/' . $file;
                        if (!file_exists($targetFile)) {
                            @rename($sourceFile, $targetFile);
                        } else {
                            @unlink($sourceFile);
                        }
                    }
                }
            }
            @rmdir($doublePublicDir);

            $doublePublicFilesDir = public_path('public/product/files');
            $targetFilesDir = public_path('product/files');
            if (is_dir($doublePublicFilesDir)) {
                if (!is_dir($targetFilesDir)) {
                    @mkdir($targetFilesDir, 0755, true);
                }
                $docFiles = @scandir($doublePublicFilesDir);
                if ($docFiles) {
                    foreach ($docFiles as $file) {
                        if ($file !== '.' && $file !== '..') {
                            $sourceFile = $doublePublicFilesDir . '/' . $file;
                            $targetFile = $targetFilesDir . '/' . $file;
                            if (!file_exists($targetFile)) {
                                @rename($sourceFile, $targetFile);
                            } else {
                                @unlink($sourceFile);
                            }
                        }
                    }
                }
                @rmdir($doublePublicFilesDir);
            }
        }
    }
}
