<?php

namespace App\Http\Controllers;

use App\Http\Requests\Delivery\StoreDeliveryRequest;
use App\Http\Requests\Delivery\UpdateDeliveryRequest;
use App\Mail\DeliveryChallan;
use App\Mail\DeliveryDetails;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\MailSetting;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Services\DeliveryService;
use App\Traits\MailInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class DeliveryController extends Controller
{
    use MailInfo;

    protected DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('delivery')) {
            $indexData = $this->deliveryService->getIndexData();
            return view('backend.delivery.index', $indexData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create($id)
    {
        return $this->deliveryService->getDeliveryDataForSale($id);
    }

    public function store(StoreDeliveryRequest $request)
    {
        $delivery = $this->deliveryService->createDelivery($request->all(), $request->file('file'));

        return redirect('delivery')->with('message', 'Delivery created successfully');
    }

    public function productDeliveryData($id)
    {
        return $this->deliveryService->getProductDeliveryData($id);
    }

    public function sendMail(Request $request)
    {
        $lims_delivery_data = Delivery::find($request->delivery_id);
        $lims_sale_data = Sale::find($lims_delivery_data->sale_id);
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);

        $mail_data['email'] = $lims_customer_data->email;
        $mail_data['customer'] = $lims_customer_data->name;
        $mail_data['sale_reference_no'] = $lims_sale_data->reference_no;
        $mail_data['delivery_reference_no'] = $lims_delivery_data->reference_no;
        $mail_data['status'] = $lims_delivery_data->status;
        $mail_data['delivered_by'] = $lims_delivery_data->delivered_by;
        $mail_data['recieved_by'] = $lims_delivery_data->recieved_by;
        $mail_data['address'] = $lims_delivery_data->address;
        $mail_data['note'] = $lims_delivery_data->note;

        $mail_setting = MailSetting::latest()->first();
        if ($mail_setting) {
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($mail_data['email'])->send(new DeliveryDetails($mail_data));
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
        $lims_delivery_data = Delivery::find($id);
        $customer_sale = Sale::join('customers', 'sales.customer_id', '=', 'customers.id')
            ->where('sales.id', $lims_delivery_data->sale_id)
            ->select('sales.reference_no', 'customers.name')
            ->first();

        $delivery_data[] = $lims_delivery_data->reference_no;
        $delivery_data[] = $customer_sale ? $customer_sale->reference_no : '';
        $delivery_data[] = $lims_delivery_data->status;
        $delivery_data[] = $lims_delivery_data->delivered_by;
        $delivery_data[] = $lims_delivery_data->recieved_by;
        $delivery_data[] = $customer_sale ? $customer_sale->name : '';
        $delivery_data[] = $lims_delivery_data->address;
        $delivery_data[] = $lims_delivery_data->note;
        $delivery_data[] = $lims_delivery_data->courier_id;

        return $delivery_data;
    }

    public function update(UpdateDeliveryRequest $request, $id)
    {
        $this->deliveryService->updateDelivery($request->all(), $request->file('file'));

        return redirect('delivery')->with('message', 'Delivery updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $delivery_ids = $request['deliveryIdArray'] ?? [];
        $this->deliveryService->deleteMultipleDeliveries($delivery_ids);

        return 'Delivery deleted successfully!';
    }

    public function destroy($id)
    {
        $this->deliveryService->deleteDelivery($id);

        return redirect('delivery')->with('not_permitted', 'Delivery deleted successfully');
    }
}
