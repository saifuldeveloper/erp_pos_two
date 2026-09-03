<?php

namespace App\Services;

use App\Models\Biller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\Supplier;
use App\Models\Waste;
use App\Models\WasteItem;
use App\Repositories\Contracts\WasteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WasteService
{
    protected WasteRepositoryInterface $wasteRepository;

    /**
     * WasteService constructor.
     *
     * @param WasteRepositoryInterface $wasteRepository
     */
    public function __construct(WasteRepositoryInterface $wasteRepository)
    {
        $this->wasteRepository = $wasteRepository;
    }

    /**
     * Get wastes filtered by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getWastesByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->wasteRepository->getWastesByDateRange($startDate, $endDate);
    }

    /**
     * Process DataTables server-side response for waste list.
     *
     * @param Request $request
     * @return array
     */
    public function getWasteDataTable(Request $request): array
    {
        $columns = [
            0 => 'wastes.created_at',
            1 => 'wastes.receiver_type',
            2 => 'wastes.receiver_name',
            3 => DB::raw('(SELECT SUM(qty) FROM waste_items WHERE waste_items.waste_id = wastes.id)'),
            5 => 'wastes.total_price'
        ];

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $starting_date = $start_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->format('Y-m-d') : null;
        $ending_date = $end_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->format('Y-m-d') : null;

        $baseQuery = Waste::select(
            'wastes.id',
            'wastes.created_at as date',
            'wastes.receiver_type',
            'wastes.receiver_name',
            'wastes.total_price',
            'wastes.status',
            DB::raw('(SELECT SUM(qty) FROM waste_items WHERE waste_items.waste_id = wastes.id) as total_qty')
        )
            ->leftJoin('waste_items', 'wastes.id', '=', 'waste_items.waste_id')
            ->leftJoin('products', 'waste_items.product_id', '=', 'products.id')
            ->distinct('wastes.id');

        if ($starting_date && $ending_date) {
            $baseQuery->whereDate('wastes.created_at', '>=', $starting_date)
                      ->whereDate('wastes.created_at', '<=', $ending_date);
        }

        $query = clone $baseQuery;
        if ($search = $request->input('search')['value'] ?? null) {
            $query->where(function ($q) use ($search) {
                $q->where('wastes.receiver_type', 'like', "%$search%")
                    ->orWhere('wastes.receiver_name', 'like', "%$search%")
                    ->orWhere('products.name', 'like', "%$search%")
                    ->orWhere('products.code', 'like', "%$search%");
            });
        }

        if ($request->input('order')) {
            $orderColIdx = $request->input('order')[0]['column'];
            $orderColumn = $columns[$orderColIdx] ?? 'wastes.created_at';
            $orderDir = $request->input('order')[0]['dir'] ?? 'asc';
            $query->orderBy($orderColumn, $orderDir);
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);
        $totalRecords = (clone $query)->count(DB::raw('distinct wastes.id'));

        if ($length > 0) {
            $wastes = $query->offset($start)->limit($length)->get();
        } else {
            $wastes = $query->get();
        }

        $waste_ids = $wastes->pluck('id')->toArray();
        $purchaseTotals = DB::table('waste_items as wi')
            ->join('products as p', 'wi.product_id', '=', 'p.id')
            ->whereIn('wi.waste_id', $waste_ids)
            ->selectRaw('wi.waste_id, SUM(wi.qty * COALESCE(p.cost, 0)) as total')
            ->groupBy('wi.waste_id')
            ->pluck('total', 'wi.waste_id');

        foreach ($wastes as $waste) {
            $waste->purchase_price = $purchaseTotals[$waste->id] ?? 0;
        }

        return [
            'draw'            => $request->input('draw'),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $wastes,
        ];
    }

    /**
     * Get products data for create waste view.
     *
     * @return array
     */
    public function getCreateProductsData(): array
    {
        $lims_product_data = Product::where('is_active', true)->get();
        $product_qty = [];
        $product_code = [];
        $product_name = [];
        $product_type = [];
        $product_id = [];
        $product_list = [];
        $qty_list = [];
        $product_price = [];
        $batch_no = [];
        $product_batch_id = [];
        $expired_date = [];
        $is_embeded = [];

        foreach ($lims_product_data as $product) {
            $product_qty[] = $product->qty;
            $product_code[] = $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
            $product_price[] = $product->price;
            $batch_no[] = null;
            $product_batch_id[] = null;
            $expired_date[] = null;
            $is_embeded[] = 0;
        }

        return [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price, $batch_no, $product_batch_id, $expired_date, $is_embeded];
    }

    /**
     * Get receiver list by type.
     *
     * @param string $type
     * @return Collection
     */
    public function getReceiverList(string $type): Collection
    {
        switch ($type) {
            case 'employee':
                return Employee::where('is_active', true)->select('id', 'name')->get();
            case 'customer':
                return Customer::where('is_active', true)->select('id', 'name')->get();
            case 'supplier':
                return Supplier::where('is_active', true)->select('id', 'name')->get();
            case 'biller':
                return Biller::where('is_active', true)->select('id', 'name')->get();
            default:
                return new Collection();
        }
    }

    /**
     * Create a new waste record and deduct stock.
     *
     * @param array $requestData
     * @return Waste
     */
    public function createWaste(array $requestData): Waste
    {
        $filtered_products = [];
        if (!empty($requestData['product'])) {
            foreach ($requestData['product'] as $prod) {
                if (isset($prod['qty']) && (float) $prod['qty'] > 0) {
                    $filtered_products[] = $prod;
                }
            }
        }

        if (empty($filtered_products)) {
            throw new \Exception('Please enter quantity for at least one item.');
        }

        return DB::transaction(function () use ($requestData, $filtered_products) {
            $receiverName = '';
            if (!empty($requestData['receiver_id'])) {
                switch ($requestData['receiver_type'] ?? '') {
                    case 'employee':
                        $r = Employee::find($requestData['receiver_id']);
                        $receiverName = $r ? $r->name : '';
                        break;
                    case 'customer':
                        $r = Customer::find($requestData['receiver_id']);
                        $receiverName = $r ? $r->name : '';
                        break;
                    case 'supplier':
                        $r = Supplier::find($requestData['receiver_id']);
                        $receiverName = $r ? $r->name : '';
                        break;
                    case 'biller':
                        $r = Biller::find($requestData['receiver_id']);
                        $receiverName = $r ? $r->name : '';
                        break;
                }
            }

            $waste = $this->wasteRepository->create([
                'user_id'       => Auth::id(),
                'receiver_type' => $requestData['receiver_type'] ?? null,
                'receiver_id'   => $requestData['receiver_id'] ?? null,
                'receiver_name' => $receiverName,
                'note'          => $requestData['note'] ?? null,
                'status'        => $requestData['status'] ?? 'pending',
                'total_price'   => $requestData['grand_total'] ?? 0,
            ]);

            foreach ($filtered_products as $data) {
                $product = Product::findOrFail($data['product_id']);
                $productVariantId = null;

                if (!empty($data['varient_code'])) {
                    $product_variant = ProductVariant::where([
                        ['product_id', $data['product_id']],
                        ['item_code', $data['varient_code']]
                    ])->first();
                    if ($product_variant) {
                        $product_variant->qty -= $data['qty'];
                        $product_variant->save();
                        $productVariantId = $product_variant->variant_id;
                    }
                }

                $product->qty -= $data['qty'];
                $product->save();

                WasteItem::create([
                    'waste_id'         => $waste->id,
                    'product_id'       => $data['product_id'],
                    'variant_id'       => $productVariantId,
                    'qty'              => $data['qty'],
                    'price'            => $data['unit_price'] ?? 0,
                    'subtotal'         => $data['subtotal'] ?? 0,
                    'varient_code'     => $data['varient_code'] ?? null,
                    'purchase_unit_id' => $data['purchase_unit_id'] ?? null,
                ]);
            }

            return $waste;
        });
    }

    /**
     * Get data required for edit waste view.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $waste = Waste::with(['items.product'])->findOrFail($id);
        $products = $this->getCreateProductsData();

        return compact('waste', 'products');
    }

    /**
     * Delete a waste record and revert stock.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteWaste($id): bool
    {
        $waste = Waste::with('items')->findOrFail($id);

        return DB::transaction(function () use ($waste) {
            foreach ($waste->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->qty += $item->qty;
                    $product->save();
                }

                if ($item->varient_code) {
                    $variant = ProductVariant::where([
                        ['product_id', $item->product_id],
                        ['item_code', $item->varient_code]
                    ])->first();
                    if ($variant) {
                        $variant->qty += $item->qty;
                        $variant->save();
                    }
                }

                $item->delete();
            }

            return (bool) $waste->delete();
        });
    }
}
