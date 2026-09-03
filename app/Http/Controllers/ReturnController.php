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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class ReturnController extends Controller
{
    use MailInfo;

    protected ReturnService $returnService;
    protected ReturnRepositoryInterface $returnRepository;

    public function __construct(ReturnService $returnService, ReturnRepositoryInterface $returnRepository)
    {
        $this->returnService = $returnService;
        $this->returnRepository = $returnRepository;
    }

    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

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
            return view('backend.return.index', compact('starting_date', 'ending_date', 'warehouse_id', 'all_permission', 'lims_warehouse_list'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function returnData(Request $request)
    {
        $allPermissions = $request->input('all_permission', []);
        $jsonData = $this->returnService->getReturnDataTable($request, $allPermissions);

        return response()->json($jsonData);
    }

    public function create(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-add')) {
            $formData = $this->returnService->getCreateFormData();
            return view('backend.return.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getCustomerGroup($id)
    {
        $lims_customer_data = Customer::find($id);
        $lims_customer_group_data = CustomerGroup::find($lims_customer_data->customer_group_id);

        return $lims_customer_group_data->percentage;
    }

    public function getBiller($id)
    {
        return Biller::find($id);
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

        if (!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where([
                    ['product_variants.item_code', $product_code[0]],
                    ['products.is_active', true]
                ])->first();
        }

        $product = [];
        $product[] = $lims_product_data->name;
        if ($lims_product_data->is_variant) {
            $product[] = $lims_product_data->item_code;
            $product[] = $lims_product_data->price + $lims_product_data->additional_price;
        } else {
            $product[] = $lims_product_data->code;
            $product[] = $lims_product_data->price;
        }

        if ($lims_product_data->tax_id) {
            $tax = Tax::find($lims_product_data->tax_id);
            $product[] = $tax ? $tax->rate : 0;
            $product[] = $tax ? $tax->name : 'No Tax';
        } else {
            $product[] = 0;
            $product[] = 'No Tax';
        }

        $product[] = $lims_product_data->tax_method;

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
        $product[] = $lims_product_data->id;
        $product[] = $lims_product_data->is_variant ? $lims_product_data->product_variant_id : null;
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
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('returns-edit')) {
            $formData = $this->returnService->getEditFormData($id);
            return view('backend.return.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateReturnSaleRequest $request, $id)
    {
        $this->returnService->updateReturn($id, $request->all(), $request->file('document'));

        return redirect('return-sale')->with('message', 'Return updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('returns-delete')) {
            return 'Sorry! You are not allowed to delete return';
        }

        $return_ids = $request['returnIdArray'] ?? [];
        $this->returnService->deleteMultipleReturns($return_ids);

        return 'Return deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('returns-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete return');
        }

        $this->returnService->deleteReturn($id);

        return redirect('return-sale')->with('not_permitted', 'Data deleted successfully');
    }
}
