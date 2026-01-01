<?php

namespace App\Services;

use App\Models\{
    Sale,
    Product,
    Product_Sale,
    Customer,
    Coupon,
    RewardPointSetting,
    Payment,
    CashRegister,
    Account,
    Unit,
    ProductVariant,
    Product_Warehouse,
    Variant
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SaleService
{
    /**
     * Main store function
     */
    public function store(array $data)
    {

      

        return DB::transaction(function () use ($data) {
            

            
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
            $mail_data = $this->processProducts($data, $sale->id);

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


    private function processProducts(array $data, int $sale_id)
    {
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

                    if (isset($variant_list[$key]) && $variant_list[$key]) {
                        $child_variant = ProductVariant::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$key]]
                        ])->first();

                        $child_warehouse = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['variant_id', $variant_list[$key]],
                            ['warehouse_id', $data['warehouse_id']]
                        ])->first();

                        $child_variant->qty -= $data['qty'][$i] * $qty_list[$key];
                        $child_variant->save();
                    } else {
                        $child_warehouse = Product_Warehouse::where([
                            ['product_id', $child_id],
                            ['warehouse_id', $data['warehouse_id']]
                        ])->first();
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

                    $warehouse_product = Product_Warehouse::FindProductWithVariant($id, $variant->variant_id, $data['warehouse_id'])->first();
                } else {
                    $warehouse_product = Product_Warehouse::FindProductWithoutVariant($id, $data['warehouse_id'])->first();
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
        $payment->user_id= Auth::id() ? Auth::id() : 1;
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
}
