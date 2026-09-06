<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnSale\StoreReturnSaleRequest;
use App\Http\Requests\ReturnSale\UpdateReturnSaleRequest;
use App\Mail\ReturnDetails;
use App\Models\Biller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\MailSetting;
use App\Models\Product;
use App\Models\Product_Warehouse;
use App\Models\ProductVariant;
use App\Models\Returns;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use App\Services\ReturnService;
use App\Traits\MailInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReturnController extends Controller
{
    use MailInfo;

    protected ReturnService $returnService;
    protected ReturnRepositoryInterface $returnRepository;

    public function __construct(ReturnService $returnService, ReturnRepositoryInterface $returnRepository)
    {
        $this->returnService = $returnService;
        $this->returnRepository = $returnRepository;
        $this->middleware('check_permission:returns-index')->only(['index', 'returnData', 'productReturnData']);
        $this->middleware('check_permission:returns-add')->only(['create', 'store']);
        $this->middleware('check_permission:returns-edit')->only(['edit', 'update']);
        $this->middleware('check_permission:returns-delete')->only(['destroy', 'deleteBySelection']);
    }

    public function index(Request $request)
    {
        if ($request->input('warehouse_id')) {
            $warehouse_id = $request->input('warehouse_id');
        } else {
            $warehouse_id = 0;
        }

        if ($request->input('starting_date')) {
            $starting_date = $request->input('starting_date');
            $ending_date = $request->input('ending_date');
        } else {
            $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d'))))));
            $ending_date = date("Y-m-d");
        }

        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        return view('backend.return.index', compact('starting_date', 'ending_date', 'warehouse_id', 'lims_warehouse_list'));
    }

    public function returnData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->returnService->getReturnDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $formData = $this->returnService->getCreateFormData();
        return view('backend.return.create', $formData);
    }

    public function getCustomerGroup($id)
    {
        $lims_customer_data = Customer::find($id);
        $lims_customer_group_data = CustomerGroup::find($lims_customer_data->customer_group_id);

        return $lims_customer_group_data->percentage;
    }

    public function getProduct($id)
    {
        $lims_product_warehouse_data = Product_Warehouse::where('warehouse_id', $id)->get();
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_data = [];
        foreach ($lims_product_warehouse_data as $product_warehouse) {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] = $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
        }

        $product_data[] = $product_code;
        $product_data[] = $product_name;
        $product_data[] = $product_qty;
        return $product_data;
    }

    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_info = explode("?", $request['data']);
        $customer_id = $product_info[1];

        $lims_product_data = Product::where([
            ['code', $product_code[0]],
            ['is_active', true]
        ])->first();

        $product_variant_id = null;
        if (!$lims_product_data) {
            $product_variant_data = ProductVariant::select('id', 'product_id', 'item_code')->where('item_code', $product_code[0])->first();
            $lims_product_data = Product::find($product_variant_data->product_id);
            $product_variant_id = $product_variant_data->id;
        }

        $product[] = $lims_product_data->name;
        if ($product_variant_id) {
            $product[] = $product_variant_data->item_code;
        } else {
            $product[] = $lims_product_data->code;
        }

        if ($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date && $todayDate >= $lims_product_data->starting_date) {
            $product[] = $lims_product_data->promotion_price;
        } else {
            $product[] = $lims_product_data->price;
        }

        if ($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }

        $product[] = $lims_product_data->tax_method;

        if ($lims_product_data->type == 'standard') {
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                ->orWhere('id', $lims_product_data->unit_id)
                ->get();

            $unit_name = [];
            $unit_operator = [];
            $unit_operation_value = [];
            foreach ($units as $unit) {
                if ($lims_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                } else {
                    $unit_name[] = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }

            $product[] = implode(",", $unit_name) . ',';
            $product[] = implode(",", $unit_operator) . ',';
            $product[] = implode(",", $unit_operation_value) . ',';
        } else {
            $product[] = 'n/a,';
            $product[] = 'n/a,';
            $product[] = 'n/a,';
        }

        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        $product[] = $lims_product_data->is_imei;

        return $product;
    }

    public function productReturnData($id)
    {
        return $this->returnRepository->getProductReturnDataByReturnId($id);
    }

    public function store(StoreReturnSaleRequest $request)
    {
        $this->returnService->createReturn($request->all(), $request->file('document'));

        return redirect('return-sale')->with('message', 'Return created successfully');
    }

    public function sendMail(Request $request)
    {
        $lims_return_data = Returns::find($request->return_id);
        $lims_customer_data = Customer::find($lims_return_data->customer_id);

        $mail_data['email'] = $lims_customer_data->email;
        $mail_data['reference_no'] = $lims_return_data->reference_no;
        $mail_data['total_qty'] = $lims_return_data->total_qty;
        $mail_data['total_price'] = $lims_return_data->total_price;
        $mail_data['order_tax'] = $lims_return_data->order_tax;
        $mail_data['order_tax_rate'] = $lims_return_data->order_tax_rate;
        $mail_data['order_discount'] = $lims_return_data->order_discount;
        $mail_data['shipping_cost'] = $lims_return_data->shipping_cost;
        $mail_data['grand_total'] = $lims_return_data->grand_total;

        $mail_setting = MailSetting::latest()->first();
        if ($mail_setting) {
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new ReturnDetails($mail_data));
                $message = 'Mail sent successfully';
            } catch (\Exception $e) {
                $message = 'Mail could not be sent: ' . $e->getMessage();
            }
        } else {
            $message = 'Please setup your mail settings first!';
        }

        return redirect()->back()->with('message', $message);
    }

    public function edit($id)
    {
        $formData = $this->returnService->getEditFormData($id);
        return view('backend.return.edit', $formData);
    }

    public function update(UpdateReturnSaleRequest $request, $id)
    {
        $this->returnService->updateReturn($id, $request->all(), $request->file('document'));

        return redirect('return-sale')->with('message', 'Return updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $return_ids = $request['returnIdArray'] ?? [];
        $this->returnService->deleteMultipleReturns($return_ids);

        return 'Return deleted successfully!';
    }

    public function destroy($id)
    {
        $this->returnService->deleteReturn($id);

        return redirect('return-sale')->with('not_permitted', 'Data deleted successfully');
    }
}
