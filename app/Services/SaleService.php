<?php

namespace App\Services;

use App\Models\{ Sale, Product, Product_Sale, Customer, Coupon, RewardPointSetting, Payment, CashRegister, Account, Unit, ProductVariant, Product_Warehouse, Variant, Transfer, ProductTransfer };
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class SaleService
{
    /**
     * Main store function
     */
    public function store(array $data)
    {
        $rules = [
            'warehouse_id' => 'required',
        ];

        if (!isset($data['sale_type']) || $data['sale_type'] !== 'website') {
            $rules['biller_id'] = 'required';
            $rules['customer_id'] = 'required';
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return DB::transaction(function () use ($data) {




            if (isset($data['sale_type']) && $data['sale_type'] === 'website') {
                $customer = Customer::where('phone_number', $data['customer_info']['phone_number'])->first();
                if (!$customer) {
                    $customer = $this->createCustomer(
                        $data['customer_info']
                    );
                }
                $data['customer_id'] = $customer->id;

            }

            $data['user_id'] = Auth::id() ? Auth::id() : 1;
            // Cash Register
            $register = CashRegister::where([
                ['user_id', $data['user_id']],
                ['warehouse_id', $data['warehouse_id']],
                ['status', true]
            ])->first();

            if ($register)
                $data['cash_register_id'] = $register->id;

            // Date set
            $data['created_at'] = isset($data['created_at'])
                ? date("Y-m-d H:i:s", strtotime($data['created_at'] . ' ' . date('H:i:s')))
                : now();

            // Reference No
            if (!isset($data['reference_no'])) {
                $data['reference_no'] = $data['pos']
                    ? 'posr-' . date("Ymd") . '-' . date("his")
                    : 'sr-' . date("Ymd") . '-' . date("his");
            } else {

                $data['reference_no'] = $data['reference_no'];
            }



            // if (!isset($data['reference_no'])) {
            //     $timestamp = date("Ymd-His");
            //     if (($data['sale_type'] ?? '') === 'website') {
            //         $data['ecom'] = true;
            //     }
            //     $prefix = match ($data['sale_type'] ?? '') {
            //         'website' => (!empty($data['ecom']) ? 'ecomr-' : 'sr-'),
            //         default => (!empty($data['pos']) ? 'posr-' : 'sr-'),
            //     };

            //     // $data['reference_no'] = $prefix . $timestamp;
            //     $data['reference_no'] = $data['reference_no'];
            // }
            if (isset($data['sale_type']) && $data['sale_type'] === 'website') {
                $data['sale_type'] = 'website';
            }
            // Payment Status
            if ($data['pos']) {
                $balance = $data['grand_total'] - $data['paid_amount'];
                $data['payment_status'] = ($balance == 0 ? 4 : 2);

                if (!empty($data['draft'])) {
                    Sale::where('id', $data['sale_id'])->delete();
                    Product_Sale::where('sale_id', $data['sale_id'])->delete();
                }
            }

            // Upload Document
            if (isset($data['document']))
                $data['document'] = $this->uploadDocument($data['document']);

            // Coupon Update
            if (!empty($data['coupon_active'])) {
                $coupon = Coupon::find($data['coupon_id']);
                $coupon->used += 1;
                $coupon->save();
            }

            // Queue for Restaurant
            if (isset($data['table_id'])) {
                $last = Sale::whereNotNull('table_id')
                    ->whereDate('created_at', date('Y-m-d'))
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->orderBy('id', 'desc')
                    ->value('queue');

                $data['queue'] = $last ? $last + 1 : 1;
            }

            // Create Sale
            $sale = Sale::create($data);

            // Store Custom Fields
            $this->storeCustomFields($sale->id, $data);

            // Customer Reward Points
            $this->updateRewardPoints($data);

            // Process Products & generate mail_data
            $mail_data = $this->processProducts($data, $sale);

            // Handle Payment
            if (
                $data['payment_status'] == 3 ||
                $data['payment_status'] == 4 ||
                ($data['payment_status'] == 2 && $data['pos'] && $data['paid_amount'] > 0)
            ) {
                $this->storePayment($data, $sale->id, $register);
            }

            $message = "Sale created successfully!";

            // Return sale + mail_data + message
            return [
                'sale' => $sale,
                'mail_data' => $mail_data,
                'message' => $message
            ];
        });
    }



    /* =====================================================
     * =============== Helper Methods Below =================
     * ===================================================== */

    public function CreateCustomer(array $data)
    {
        $customer_data = [
            'customer_group_id' => 1,
            'name' => $data['customer_name'] ?? 'Website Customer',
            'phone_number' => $data['phone_number'],
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'is_active' => true,
        ];
        $customer = Customer::create($customer_data);
        if (!empty($data['custom_fields'])) {
            $custom_field_data = [];
            foreach ($data['custom_fields'] as $key => $value) {
                if (is_array($value)) {
                    $custom_field_data[$key] = implode(',', $value);
                } else {
                    $custom_field_data[$key] = $value;
                }
            }
            if (!empty($custom_field_data)) {
                DB::table('customers')->where('id', $customer->id)->update($custom_field_data);
            }
        }
        return $customer;
    }

    private function uploadDocument($file)
    {
        $ext = $file->getClientOriginalExtension();
        $name = date("Ymdhis") . "." . $ext;

        $file->move('public/documents/sale', $name);

        return $name;
    }


    private function storeCustomFields($sale_id, $data)
    {
        $custom_fields = \App\Models\CustomField::where('belongs_to', 'sale')->get();
        $update = [];

        foreach ($custom_fields as $field) {
            $field_name = strtolower(str_replace(' ', '_', $field->name));

            if (isset($data[$field_name])) {
                $update[$field_name] = is_array($data[$field_name])
                    ? implode(",", $data[$field_name])
                    : $data[$field_name];
            }
        }

        if (!empty($update))
            DB::table('sales')->where('id', $sale_id)->update($update);
    }


    private function updateRewardPoints($data)
    {
        $customer = Customer::find($data['customer_id']);
        $setting = RewardPointSetting::latest()->first();

        if ($setting && $setting->is_active && $data['grand_total'] >= $setting->minimum_amount) {
            $point = (int) ($data['grand_total'] / $setting->per_point_amount);
            $customer->points += $point;
            $customer->save();
        }
    }


    private function processProducts(array $data, Sale $sale)
    {
        $sale_id = $sale->id;
        $mail_data = [
            'products' => [],
            'file' => [],
            'unit' => [],
            'qty' => [],
            'total' => [],
        ];

        foreach ($data['product_id'] as $i => $id) {
            $product = Product::find($id);

            $product_sale = [
                'sale_id' => $sale_id,
                'product_id' => $id,
                'variant_id' => null,
                'product_batch_id' => null,
            ];

            // Combo Products
            if ($product->type == 'combo' && $data['sale_status'] == 1) {
                $product_list = explode(',', $product->product_list);
                $variant_list = $product->variant_list ? explode(',', $product->variant_list) : [];
                $qty_list = explode(',', $product->qty_list);

                foreach ($product_list as $key => $child_id) {
                    $child = Product::find($child_id);

                    if (count($variant_list) && $variant_list[$key]) {
                        $child_variant = ProductVariant::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$key]]
                        ])->first();

                        $child_warehouse = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$key]],
                            ['warehouse_id', $data['warehouse_id']]
                        ])->first();
                    } else {
                        $child_variant = null;
                        $child_warehouse = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['warehouse_id', $data['warehouse_id']]
                        ])->first();
                    }

                    if (!$child_warehouse) {
                        $child_warehouse = new Product_Warehouse();
                        $child_warehouse->product_id = $child_id;
                        $child_warehouse->warehouse_id = $data['warehouse_id'];
                        $child_warehouse->variant_id = (isset($variant_list[$key]) && $variant_list[$key]) ? $variant_list[$key] : null;
                        $child_warehouse->qty = 0;
                        $child_warehouse->price = $child->price;
                    }

                    if (config('without_stock') == 'no') {
                        $required_qty = $data['qty'][$i] * $qty_list[$key];
                        if ($child_warehouse->qty < $required_qty) {
                            throw ValidationException::withMessages([
                                'qty' => ["The quantity for combo component '{$child->name}' exceeds available stock in this warehouse (Available: " . max(0, $child_warehouse->qty) . ")."]
                            ]);
                        }
                        if ($child_variant && $child_variant->qty < $required_qty) {
                            throw ValidationException::withMessages([
                                'qty' => ["The quantity for combo component variant '{$child->name}' exceeds available stock (Available: " . max(0, $child_variant->qty) . ")."]
                            ]);
                        }
                    }
                    if ($child_variant) {
                        $child_variant->qty -= $data['qty'][$i] * $qty_list[$key];
                        $child_variant->save();
                    }
                    $child->qty -= $data['qty'][$i] * $qty_list[$key];
                    $child_warehouse->qty -= $data['qty'][$i] * $qty_list[$key];

                    $child->save();
                    $child_warehouse->save();
                }
            }

            // Unit Conversion
            $unitName = $data['sale_unit'][$i];
            $unit = $unitName !== 'n/a' ? Unit::where('unit_name', $unitName)->first() : null;
            $sale_unit_id = $unit ? $unit->id : 0;
            $quantity = $data['qty'][$i];

            if ($unit && $data['sale_status'] == 1) {
                $factor = $unit->operator == '*' ? $unit->operation_value : (1 / $unit->operation_value);
                $stockQty = $quantity * $factor;

                $product->qty -= $stockQty;

                if ($product->is_variant) {
                    $variant = ProductVariant::select('id', 'variant_id', 'qty')
                        ->FindExactProductWithCode($id, $data['product_code'][$i])
                        ->first();

                    $variant->qty -= $stockQty;
                    $variant->save();

                    $this->mergeProductWarehouseDuplicates($id, $variant->variant_id);

                    $warehouse_product = Product_Warehouse::FindProductWithVariant($id, $variant->variant_id, $data['warehouse_id'])->first();
                } else {
                    $this->mergeProductWarehouseDuplicates($id, null);

                    $warehouse_product = Product_Warehouse::FindProductWithoutVariant($id, $data['warehouse_id'])->first();
                }

                // Check if we need to auto-transfer stock from another warehouse
                $currentQty = $warehouse_product ? $warehouse_product->qty : 0;
                $remaining_imeis = !empty($data['imei_number'][$i]) ? explode(',', $data['imei_number'][$i]) : [];

                while ($currentQty < $stockQty) {
                    $missingQty = $stockQty - $currentQty;
                    if ($product->is_variant) {
                        $source_warehouse_product = Product_Warehouse::where('product_id', $id)
                            ->where('variant_id', $variant->variant_id)
                            ->where('warehouse_id', '!=', $data['warehouse_id'])
                            ->where('qty', '>', 0)
                            ->orderBy('qty', 'desc')
                            ->first();
                    } else {
                        $source_warehouse_product = Product_Warehouse::where('product_id', $id)
                            ->whereNull('variant_id')
                            ->whereNull('product_batch_id')
                            ->where('warehouse_id', '!=', $data['warehouse_id'])
                            ->where('qty', '>', 0)
                            ->orderBy('qty', 'desc')
                            ->first();
                    }

                    if (!$source_warehouse_product) {
                        break;
                    }

                    $transferQty = min($missingQty, $source_warehouse_product->qty);

                    // Create Transfer
                    $transfer = Transfer::create([
                        'reference_no' => 'tr-' . date("Ymd") . '-' . date("his") . '-' . uniqid(),
                        'user_id' => Auth::id() ? Auth::id() : 1,
                        'status' => 1, // Completed
                        'from_warehouse_id' => $source_warehouse_product->warehouse_id,
                        'to_warehouse_id' => $data['warehouse_id'],
                        'item' => 1,
                        'total_qty' => $transferQty,
                        'total_tax' => 0,
                        'total_cost' => $transferQty * ($product->cost ?? 0),
                        'shipping_cost' => 0,
                        'grand_total' => $transferQty * ($product->cost ?? 0),
                        'note' => 'Auto-transfer created during POS sale #' . $sale->reference_no
                    ]);

                    // Create ProductTransfer
                    $productTransferData = [
                        'transfer_id' => $transfer->id,
                        'product_id' => $id,
                        'variant_id' => $product->is_variant ? $variant->variant_id : null,
                        'qty' => $transferQty,
                        'purchase_unit_id' => $product->purchase_unit_id ?? $product->unit_id,
                        'net_unit_cost' => $product->cost ?? 0,
                        'tax_rate' => 0,
                        'tax' => 0,
                        'total' => $transferQty * ($product->cost ?? 0),
                    ];

                    // Deduct stock from source warehouse
                    $source_warehouse_product->qty -= $transferQty;

                    // Handle IMEI transfer
                    if (count($remaining_imeis) > 0) {
                        $source_imeis = $source_warehouse_product->imei_number ? explode(',', $source_warehouse_product->imei_number) : [];
                        $transferred_imeis = [];
                        foreach ($remaining_imeis as $key => $imei) {
                            if (($idx = array_search($imei, $source_imeis)) !== false) {
                                unset($source_imeis[$idx]);
                                $transferred_imeis[] = $imei;
                                unset($remaining_imeis[$key]);
                            }
                        }

                        if (count($transferred_imeis) > 0) {
                            $source_warehouse_product->imei_number = implode(',', $source_imeis);
                            $productTransferData['imei_number'] = implode(',', $transferred_imeis);

                            if (!$warehouse_product) {
                                $warehouse_product = new Product_Warehouse();
                                $warehouse_product->product_id = $id;
                                $warehouse_product->warehouse_id = $data['warehouse_id'];
                                $warehouse_product->variant_id = $product->is_variant ? $variant->variant_id : null;
                                $warehouse_product->qty = 0;
                                $warehouse_product->price = $product->price;
                                $warehouse_product->imei_number = implode(',', $transferred_imeis);
                            } else {
                                $target_imeis = $warehouse_product->imei_number ? explode(',', $warehouse_product->imei_number) : [];
                                $target_imeis = array_merge($target_imeis, $transferred_imeis);
                                $warehouse_product->imei_number = implode(',', $target_imeis);
                            }
                        }
                    }

                    $source_warehouse_product->save();
                    ProductTransfer::create($productTransferData);

                    // Add stock to target warehouse
                    if (!$warehouse_product) {
                        $warehouse_product = new Product_Warehouse();
                        $warehouse_product->product_id = $id;
                        $warehouse_product->warehouse_id = $data['warehouse_id'];
                        $warehouse_product->variant_id = $product->is_variant ? $variant->variant_id : null;
                        $warehouse_product->qty = $transferQty;
                        $warehouse_product->price = $product->price;
                    } else {
                        $warehouse_product->qty += $transferQty;
                    }
                    $warehouse_product->save();

                    // Reload/Update currentQty
                    $currentQty += $transferQty;
                }

                if (!$warehouse_product) {
                    $warehouse_product = new Product_Warehouse();
                    $warehouse_product->product_id = $id;
                    $warehouse_product->warehouse_id = $data['warehouse_id'];
                    $warehouse_product->variant_id = $product->is_variant ? $variant->variant_id : null;
                    $warehouse_product->qty = 0;
                    $warehouse_product->price = $product->price;
                }

                if (config('without_stock') == 'no' && ($warehouse_product->qty < $stockQty)) {
                    throw ValidationException::withMessages([
                        'qty' => ["The quantity for product '{$product->name}' exceeds available stock in this warehouse (Available: " . max(0, $warehouse_product->qty) . ")."]
                    ]);
                }

                $warehouse_product->qty -= $stockQty;
                $warehouse_product->save();

                $product_sale['variant_id'] = $product->is_variant ? $variant->variant_id : null;
            }

            $product->save();

            // Deduct IMEI
            if (!empty($data['imei_number'][$i]) && isset($warehouse_product)) {
                $imei_numbers = explode(',', $data['imei_number'][$i]);
                $all_imei = explode(',', $warehouse_product->imei_number);

                foreach ($imei_numbers as $number) {
                    if (($key = array_search($number, $all_imei)) !== false) {
                        unset($all_imei[$key]);
                    }
                }

                $warehouse_product->imei_number = implode(',', $all_imei);
                $warehouse_product->save();
            }

            // Prepare mail_data
            $mail_data['products'][$i] = $product_sale['variant_id']
                ? $product->name . ' [' . Variant::find($product_sale['variant_id'])->name . ']'
                : $product->name;

            $mail_data['file'][$i] = $product->type === 'digital' ? url('/public/product/files') . '/' . $product->file : '';
            $mail_data['unit'][$i] = $sale_unit_id ? $unit->unit_code : '';
            $mail_data['qty'][$i] = $quantity;
            $mail_data['total'][$i] = $data['subtotal'][$i];

            // Save Product_Sale
            $product_sale = array_merge($product_sale, [
                'qty' => $quantity,
                'sale_unit_id' => $sale_unit_id,
                'net_unit_price' => $data['unit_price'][$i] ?? 0,
                'discount' => $data['product_discount'][$i],
                'tax_rate' => $data['tax_rate'][$i],
                'tax' => $data['tax'][$i],
                'total' => $data['subtotal'][$i],
                'imei_number' => $data['imei_number'][$i] ?? null,
            ]);

            Product_Sale::create($product_sale);
        }

        return $mail_data;
    }




    private function storePayment($data, $sale_id, $register)
    {
        $payment = new Payment();
        // $payment->user_id = Auth::id();
        $payment->user_id = Auth::id() ? Auth::id() : 1;
        $payment->sale_id = $sale_id;
        $payment->cash_register_id = $register ? $register->id : null;

        $payment->amount = $data['paid_amount'];
        $payment->change = $data['paying_amount'] - $data['paid_amount'];
        $payment->payment_reference = 'spr-' . date("Ymd") . "-" . date("his");
        $payment->paying_method = $this->getPayMethod($data['paid_by_id']);
        $payment->payment_note = $data['payment_note'];
        $payment->account_id = Account::where('is_default', true)->value('id');

        $payment->save();

        return $payment;
    }


    private function getPayMethod($id)
    {
        return [
            1 => 'Cash',
            2 => 'Gift Card',
            3 => 'Credit Card',
            4 => 'Cheque',
            5 => 'Paypal',
            6 => 'Deposit',
            7 => 'Points'
        ][$id] ?? 'Cash';
    }

    private function mergeProductWarehouseDuplicates(int $product_id, ?int $variant_id)
    {
        $query = DB::table('product_warehouse')
            ->select('warehouse_id', 'product_batch_id', DB::raw('COUNT(*) as count'))
            ->where('product_id', $product_id);

        if ($variant_id !== null) {
            $query = $query->where('variant_id', $variant_id);
        } else {
            $query = $query->whereNull('variant_id');
        }

        $duplicates = $query->groupBy('warehouse_id', 'product_batch_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $rowsQuery = DB::table('product_warehouse')
                ->where('product_id', $product_id)
                ->where('warehouse_id', $dup->warehouse_id)
                ->where('product_batch_id', $dup->product_batch_id);

            if ($variant_id !== null) {
                $rowsQuery = $rowsQuery->where('variant_id', $variant_id);
            } else {
                $rowsQuery = $rowsQuery->whereNull('variant_id');
            }

            $rows = $rowsQuery->orderBy('id', 'asc')->get();

            $firstRow = $rows->first();
            $totalQty = $rows->sum('qty');

            // Update first row
            DB::table('product_warehouse')
                ->where('id', $firstRow->id)
                ->update(['qty' => $totalQty]);

            // Delete duplicates
            $deleteIds = $rows->slice(1)->pluck('id')->toArray();
            DB::table('product_warehouse')
                ->whereIn('id', $deleteIds)
                ->delete();
        }
    }
}
