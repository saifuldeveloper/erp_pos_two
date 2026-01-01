<?php

namespace App\Http\Controllers\API\Website;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Customer;
use App\Mail\SaleDetails;
use App\Models\Warehouse;
use App\Models\CustomField;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\RewardPointSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Services\SaleService;
class EcommersController extends Controller
{
    protected $request;
    protected $saleService;

    public function __construct(Request $request, SaleService $saleService)
    {



        $this->request = $request;


        $this->saleService = $saleService;

    }

    public function productInfo()
    {
        $product = Product::with('productVariants')
            ->where('code', $this->request->input('code'))
            ->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $product
        ]);
    }





    public function store(Request $request)
    {
        try {
            $result = $this->saleService->store($request->all());

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'sale_id' => $result['sale']->id,
                'mail_data' => $result['mail_data']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sale could not be created',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    












    // public function Oldstore(Request $request)
    // {
    //     $data = $request->all();
    //     //return $data;
    //     if (isset($request->reference_no)) {
    //         $this->validate($request, [
    //             'reference_no' => [
    //                 'max:191',
    //                 'required',
    //                 'unique:sales'
    //             ],
    //         ]);
    //     }

    //     $data['user_id'] = Auth::id();
    //     $cash_register_data = CashRegister::where([
    //         ['user_id', $data['user_id']],
    //         ['warehouse_id', $data['warehouse_id']],
    //         ['status', true]
    //     ])->first();

    //     if ($cash_register_data)
    //         $data['cash_register_id'] = $cash_register_data->id;

    //     if (isset($data['created_at']))
    //         $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at'] . ' ' . date('H:i:s')));
    //     else
    //         $data['created_at'] = date("Y-m-d H:i:s");

    //     if ($data['pos']) {
    //         if (!isset($data['reference_no']))
    //             $data['reference_no'] = 'posr-' . date("Ymd") . '-' . date("his");

    //         $balance = $data['grand_total'] - $data['paid_amount'];
    //         if ($balance > 0 || $balance < 0)
    //             $data['payment_status'] = 2;
    //         else
    //             $data['payment_status'] = 4;

    //         if ($data['draft']) {
    //             $lims_sale_data = Sale::find($data['sale_id']);
    //             $lims_product_sale_data = Product_Sale::where('sale_id', $data['sale_id'])->get();
    //             foreach ($lims_product_sale_data as $product_sale_data) {
    //                 $product_sale_data->delete();
    //             }
    //             $lims_sale_data->delete();
    //         }
    //     } else {
    //         if (!isset($data['reference_no']))
    //             $data['reference_no'] = 'sr-' . date("Ymd") . '-' . date("his");
    //     }

    //     $document = $request->document;
    //     if ($document) {
    //         $v = Validator::make(
    //             [
    //                 'extension' => strtolower($request->document->getClientOriginalExtension()),
    //             ],
    //             [
    //                 'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
    //             ]
    //         );
    //         if ($v->fails())
    //             return redirect()->back()->withErrors($v->errors());

    //         $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
    //         $documentName = date("Ymdhis");
    //         if (!config('database.connections.saleprosaas_landlord')) {
    //             $documentName = $documentName . '.' . $ext;
    //             $document->move('public/documents/sale', $documentName);
    //         } else {
    //             $documentName = $this->getTenantId() . '_' . $documentName . '.' . $ext;
    //             $document->move('public/documents/sale', $documentName);
    //         }
    //         $data['document'] = $documentName;
    //     }
    //     if ($data['coupon_active']) {
    //         $lims_coupon_data = Coupon::find($data['coupon_id']);
    //         $lims_coupon_data->used += 1;
    //         $lims_coupon_data->save();
    //     }
    //     if (isset($data['table_id'])) {
    //         $latest_sale = Sale::whereNotNull('table_id')->whereDate('created_at', date('Y-m-d'))->where('warehouse_id', $data['warehouse_id'])->select('queue')->orderBy('id', 'desc')->first();
    //         if ($latest_sale)
    //             $data['queue'] = $latest_sale->queue + 1;
    //         else
    //             $data['queue'] = 1;
    //     }
    //     //inserting data to sales table
    //     $lims_sale_data = Sale::create($data);
    //     //inserting data for custom fields
    //     $custom_field_data = [];
    //     $custom_fields = CustomField::where('belongs_to', 'sale')->select('name', 'type')->get();
    //     foreach ($custom_fields as $type => $custom_field) {
    //         $field_name = str_replace(' ', '_', strtolower($custom_field->name));
    //         if (isset($data[$field_name])) {
    //             if ($custom_field->type == 'checkbox' || $custom_field->type == 'multi_select')
    //                 $custom_field_data[$field_name] = implode(",", $data[$field_name]);
    //             else
    //                 $custom_field_data[$field_name] = $data[$field_name];
    //         }
    //     }
    //     if (count($custom_field_data))
    //         DB::table('sales')->where('id', $lims_sale_data->id)->update($custom_field_data);
    //     $lims_customer_data = Customer::find($data['customer_id']);
    //     $lims_reward_point_setting_data = RewardPointSetting::latest()->first();
    //     //checking if customer gets some points or not
    //     if ($lims_reward_point_setting_data && $lims_reward_point_setting_data->is_active && $data['grand_total'] >= $lims_reward_point_setting_data->minimum_amount) {
    //         $point = (int) ($data['grand_total'] / $lims_reward_point_setting_data->per_point_amount);
    //         $lims_customer_data->points += $point;
    //         $lims_customer_data->save();
    //     }

    //     //collecting male data
    //     $mail_data['email'] = $lims_customer_data->email;
    //     $mail_data['reference_no'] = $lims_sale_data->reference_no;
    //     $mail_data['sale_status'] = $lims_sale_data->sale_status;
    //     $mail_data['payment_status'] = $lims_sale_data->payment_status;
    //     $mail_data['total_qty'] = $lims_sale_data->total_qty;
    //     $mail_data['total_price'] = $lims_sale_data->total_price;
    //     $mail_data['order_tax'] = $lims_sale_data->order_tax;
    //     $mail_data['order_tax_rate'] = $lims_sale_data->order_tax_rate;
    //     $mail_data['order_discount'] = $lims_sale_data->order_discount;
    //     $mail_data['shipping_cost'] = $lims_sale_data->shipping_cost;
    //     $mail_data['grand_total'] = $lims_sale_data->grand_total;
    //     $mail_data['paid_amount'] = $lims_sale_data->paid_amount;

    //     $product_id = $data['product_id'];
    //     $product_batch_id = $data['product_batch_id'] ?? null;
    //     $imei_number = $data['imei_number'];
    //     $product_code = $data['product_code'];
    //     $qty = $data['qty'];
    //     $sale_unit = $data['sale_unit'];
    //     $net_unit_price = $data['unit_price'];
    //     $discount = $data['product_discount'];
    //     $tax_rate = $data['tax_rate'];
    //     $tax = $data['tax'];
    //     $total = $data['subtotal'];
    //     $product_sale = [];

    //     foreach ($product_id as $i => $id) {
    //         $lims_product_data = Product::where('id', $id)->first();
    //         $product_sale['variant_id'] = null;
    //         $product_sale['product_batch_id'] = null;
    //         if ($lims_product_data->type == 'combo' && $data['sale_status'] == 1) {
    //             $product_list = explode(",", $lims_product_data->product_list);
    //             $variant_list = explode(",", $lims_product_data->variant_list);
    //             if ($lims_product_data->variant_list)
    //                 $variant_list = explode(",", $lims_product_data->variant_list);
    //             else
    //                 $variant_list = [];
    //             $qty_list = explode(",", $lims_product_data->qty_list);
    //             $price_list = explode(",", $lims_product_data->price_list);

    //             foreach ($product_list as $key => $child_id) {
    //                 $child_data = Product::find($child_id);
    //                 if (count($variant_list) && $variant_list[$key]) {
    //                     $child_product_variant_data = ProductVariant::where([
    //                         ['product_id', $child_id],
    //                         ['variant_id', $variant_list[$key]]
    //                     ])->first();

    //                     $child_warehouse_data = Product_Warehouse::where([
    //                         ['product_id', $child_id],
    //                         ['variant_id', $variant_list[$key]],
    //                         ['warehouse_id', $data['warehouse_id']],
    //                     ])->first();

    //                     $child_product_variant_data->qty -= $qty[$i] * $qty_list[$key];
    //                     $child_product_variant_data->save();
    //                 } else {
    //                     $child_warehouse_data = Product_Warehouse::where([
    //                         ['product_id', $child_id],
    //                         ['warehouse_id', $data['warehouse_id']],
    //                     ])->first();
    //                 }

    //                 $child_data->qty -= $qty[$i] * $qty_list[$key];
    //                 $child_warehouse_data->qty -= $qty[$i] * $qty_list[$key];

    //                 $child_data->save();
    //                 $child_warehouse_data->save();
    //             }
    //         }

    //         if ($sale_unit[$i] != 'n/a') {
    //             $lims_sale_unit_data = Unit::where('unit_name', $sale_unit[$i])->first();
    //             $sale_unit_id = $lims_sale_unit_data->id;
    //             if ($lims_product_data->is_variant) {
    //                 $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($id, $product_code[$i])->first();
    //                 $product_sale['variant_id'] = $lims_product_variant_data->variant_id;
    //             }
    //             // if($lims_product_data->is_batch && $product_batch_id[$i]) {
    //             //     $product_sale['product_batch_id'] = $product_batch_id[$i];
    //             // }

    //             if ($data['sale_status'] == 1) {
    //                 if ($lims_sale_unit_data->operator == '*')
    //                     $quantity = $qty[$i] * $lims_sale_unit_data->operation_value;
    //                 elseif ($lims_sale_unit_data->operator == '/')
    //                     $quantity = $qty[$i] / $lims_sale_unit_data->operation_value;
    //                 //deduct quantity
    //                 $lims_product_data->qty = $lims_product_data->qty - $quantity;
    //                 $lims_product_data->save();
    //                 //deduct product variant quantity if exist
    //                 if ($lims_product_data->is_variant) {
    //                     $lims_product_variant_data->qty -= $quantity;
    //                     $lims_product_variant_data->save();
    //                     $lims_product_warehouse_data = Product_Warehouse::FindProductWithVariant($id, $lims_product_variant_data->variant_id, $data['warehouse_id'])->first();
    //                 }
    //                 // elseif($product_batch_id[$i]) {
    //                 //     $lims_product_warehouse_data = Product_Warehouse::where([
    //                 //         ['product_batch_id', $product_batch_id[$i] ],
    //                 //         ['warehouse_id', $data['warehouse_id'] ]
    //                 //     ])->first();
    //                 //     $lims_product_batch_data = ProductBatch::find($product_batch_id[$i]);
    //                 //     //deduct product batch quantity
    //                 //     $lims_product_batch_data->qty -= $quantity;
    //                 //     $lims_product_batch_data->save();
    //                 // }
    //                 else {
    //                     $lims_product_warehouse_data = Product_Warehouse::FindProductWithoutVariant($id, $data['warehouse_id'])->first();
    //                 }
    //                 //deduct quantity from warehouse
    //                 $lims_product_warehouse_data->qty -= $quantity;
    //                 $lims_product_warehouse_data->save();
    //             }
    //         } else
    //             $sale_unit_id = 0;

    //         if ($product_sale['variant_id']) {
    //             $variant_data = Variant::select('name')->find($product_sale['variant_id']);
    //             $mail_data['products'][$i] = $lims_product_data->name . ' [' . $variant_data->name . ']';
    //         } else
    //             $mail_data['products'][$i] = $lims_product_data->name;
    //         //deduct imei number if available
    //         if ($imei_number[$i]) {
    //             $imei_numbers = explode(",", $imei_number[$i]);
    //             $all_imei_numbers = explode(",", $lims_product_warehouse_data->imei_number);
    //             foreach ($imei_numbers as $number) {
    //                 if (($j = array_search($number, $all_imei_numbers)) !== false) {
    //                     unset($all_imei_numbers[$j]);
    //                 }
    //             }
    //             $lims_product_warehouse_data->imei_number = implode(",", $all_imei_numbers);
    //             $lims_product_warehouse_data->save();
    //         }
    //         if ($lims_product_data->type == 'digital')
    //             $mail_data['file'][$i] = url('/public/product/files') . '/' . $lims_product_data->file;
    //         else
    //             $mail_data['file'][$i] = '';
    //         if ($sale_unit_id)
    //             $mail_data['unit'][$i] = $lims_sale_unit_data->unit_code;
    //         else
    //             $mail_data['unit'][$i] = '';

    //         $product_sale['sale_id'] = $lims_sale_data->id;
    //         $product_sale['product_id'] = $id;
    //         $product_sale['imei_number'] = $imei_number[$i];
    //         $product_sale['qty'] = $mail_data['qty'][$i] = $qty[$i];
    //         $product_sale['sale_unit_id'] = $sale_unit_id;
    //         $product_sale['net_unit_price'] = $net_unit_price[$i];
    //         $product_sale['discount'] = $discount[$i];
    //         $product_sale['tax_rate'] = $tax_rate[$i];
    //         $product_sale['tax'] = $tax[$i];
    //         $product_sale['total'] = $mail_data['total'][$i] = $total[$i];
    //         Product_Sale::create($product_sale);
    //     }
    //     if ($data['sale_status'] == 3)
    //         $message = 'Sale successfully added to draft';
    //     else
    //         $message = ' Sale created successfully';
    //     $mail_setting = MailSetting::latest()->first();
    //     if ($mail_data['email'] && $data['sale_status'] == 1 && $mail_setting) {
    //         $this->setMailInfo($mail_setting);
    //         try {
    //             Mail::to($mail_data['email'])->send(new SaleDetails($mail_data));
    //         } catch (\Exception $e) {
    //             $message = ' Sale created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
    //         }
    //     }

    //     if ($data['payment_status'] == 3 || $data['payment_status'] == 4 || ($data['payment_status'] == 2 && $data['pos'] && $data['paid_amount'] > 0)) {

    //         $lims_payment_data = new Payment();
    //         $lims_payment_data->user_id = Auth::id();

    //         if ($data['paid_by_id'] == 1)
    //             $paying_method = 'Cash';
    //         elseif ($data['paid_by_id'] == 2) {
    //             $paying_method = 'Gift Card';
    //         } elseif ($data['paid_by_id'] == 3)
    //             $paying_method = 'Credit Card';
    //         elseif ($data['paid_by_id'] == 4)
    //             $paying_method = 'Cheque';
    //         elseif ($data['paid_by_id'] == 5)
    //             $paying_method = 'Paypal';
    //         elseif ($data['paid_by_id'] == 6)
    //             $paying_method = 'Deposit';
    //         elseif ($data['paid_by_id'] == 7) {
    //             $paying_method = 'Points';
    //             $lims_payment_data->used_points = $data['used_points'];
    //         }

    //         if ($cash_register_data)
    //             $lims_payment_data->cash_register_id = $cash_register_data->id;
    //         $lims_account_data = Account::where('is_default', true)->first();
    //         $lims_payment_data->account_id = $lims_account_data->id;
    //         $lims_payment_data->sale_id = $lims_sale_data->id;
    //         $data['payment_reference'] = 'spr-' . date("Ymd") . '-' . date("his");
    //         $lims_payment_data->payment_reference = $data['payment_reference'];
    //         $lims_payment_data->amount = $data['paid_amount'];
    //         $lims_payment_data->change = $data['paying_amount'] - $data['paid_amount'];
    //         $lims_payment_data->paying_method = $paying_method;
    //         $lims_payment_data->payment_note = $data['payment_note'];
    //         $lims_payment_data->save();

    //         $lims_payment_data = Payment::latest()->first();
    //         $data['payment_id'] = $lims_payment_data->id;
    //         $lims_pos_setting_data = PosSetting::latest()->first();
    //         if ($paying_method == 'Credit Card' && (strlen($lims_pos_setting_data->stripe_public_key) > 0) && (strlen($lims_pos_setting_data->stripe_secret_key) > 0)) {

    //             Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
    //             $token = $data['stripeToken'];
    //             $grand_total = $data['grand_total'];

    //             $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('customer_id', $data['customer_id'])->first();

    //             if (!$lims_payment_with_credit_card_data) {
    //                 // Create a Customer:
    //                 $customer = \Stripe\Customer::create([
    //                     'source' => $token
    //                 ]);

    //                 // Charge the Customer instead of the card:
    //                 $charge = \Stripe\Charge::create([
    //                     'amount' => $grand_total * 100,
    //                     'currency' => 'usd',
    //                     'customer' => $customer->id
    //                 ]);
    //                 $data['customer_stripe_id'] = $customer->id;
    //             } else {
    //                 $customer_id =
    //                     $lims_payment_with_credit_card_data->customer_stripe_id;

    //                 $charge = \Stripe\Charge::create([
    //                     'amount' => $grand_total * 100,
    //                     'currency' => 'usd',
    //                     'customer' => $customer_id, // Previously stored, then retrieved
    //                 ]);
    //                 $data['customer_stripe_id'] = $customer_id;
    //             }
    //             $data['charge_id'] = $charge->id;
    //             PaymentWithCreditCard::create($data);
    //         } elseif ($paying_method == 'Gift Card') {
    //             $lims_gift_card_data = GiftCard::find($data['gift_card_id']);
    //             $lims_gift_card_data->expense += $data['paid_amount'];
    //             $lims_gift_card_data->save();
    //             PaymentWithGiftCard::create($data);
    //         } elseif ($paying_method == 'Cheque') {
    //             PaymentWithCheque::create($data);
    //         } elseif ($paying_method == 'Paypal') {
    //             $provider = new ExpressCheckout;
    //             $paypal_data = [];
    //             $paypal_data['items'] = [];
    //             foreach ($data['product_id'] as $key => $product_id) {
    //                 $lims_product_data = Product::find($product_id);
    //                 $paypal_data['items'][] = [
    //                     'name' => $lims_product_data->name,
    //                     'price' => ($data['subtotal'][$key] / $data['qty'][$key]),
    //                     'qty' => $data['qty'][$key]
    //                 ];
    //             }
    //             $paypal_data['items'][] = [
    //                 'name' => 'Order Tax',
    //                 'price' => $data['order_tax'],
    //                 'qty' => 1
    //             ];
    //             $paypal_data['items'][] = [
    //                 'name' => 'Order Discount',
    //                 'price' => $data['order_discount'] * (-1),
    //                 'qty' => 1
    //             ];
    //             $paypal_data['items'][] = [
    //                 'name' => 'Shipping Cost',
    //                 'price' => $data['shipping_cost'],
    //                 'qty' => 1
    //             ];
    //             if ($data['grand_total'] != $data['paid_amount']) {
    //                 $paypal_data['items'][] = [
    //                     'name' => 'Due',
    //                     'price' => ($data['grand_total'] - $data['paid_amount']) * (-1),
    //                     'qty' => 1
    //                 ];
    //             }
    //             //return $paypal_data;
    //             $paypal_data['invoice_id'] = $lims_sale_data->reference_no;
    //             $paypal_data['invoice_description'] = "Reference # {$paypal_data['invoice_id']} Invoice";
    //             $paypal_data['return_url'] = url('/sale/paypalSuccess');
    //             $paypal_data['cancel_url'] = url('/sale/create');

    //             $total = 0;
    //             foreach ($paypal_data['items'] as $item) {
    //                 $total += $item['price'] * $item['qty'];
    //             }

    //             $paypal_data['total'] = $total;
    //             $response = $provider->setExpressCheckout($paypal_data);
    //             // This will redirect user to PayPal
    //             return redirect($response['paypal_link']);
    //         } elseif ($paying_method == 'Deposit') {
    //             $lims_customer_data->expense += $data['paid_amount'];
    //             $lims_customer_data->save();
    //         } elseif ($paying_method == 'Points') {
    //             $lims_customer_data->points -= $data['used_points'];
    //             $lims_customer_data->save();
    //         }
    //     }



    //     if (isset($result['error'])) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $result['error']
    //         ], 422);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => $result['message'],
    //         'sale' => $result['sale']
    //     ], 201);
    // }


}
