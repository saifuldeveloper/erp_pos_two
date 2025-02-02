<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Purchase;
use App\Models\CashRegister;
use App\Models\Account;
use App\Models\Payment;
use App\Models\MailSetting;
use Illuminate\Validation\Rule;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\SupplierCreate;
use App\Mail\CustomerCreate;
use App\Models\SupplierDue;
use Mail;

class SupplierController extends Controller
{
    use \App\Traits\MailInfo;

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('suppliers-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_supplier_all = Supplier::where('is_active', true)->get();
            $lims_accounts = Account::where('is_active', true)->get();
            return view('backend.supplier.index', compact('lims_supplier_all', 'all_permission', 'lims_accounts'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function clearDue(Request $request)
    {
        $supplier_due = new SupplierDue();
        $supplier_due->supplier_id = $request->supplier_id;
        $supplier_due->account_id = $request->account_id;
        $supplier_due->amount = $request->amount;
        $supplier_due->note = $request->note;
        $supplier_due->save();
        $payment_ids = [];
        $account = Account::find($request->account_id);
        $account->total_balance -= $request->amount;
        $account->save();

        $lims_due_purchase_data = Purchase::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', 1],
                ['supplier_id', $request->supplier_id]
            ])->get();
        $total_paid_amount = $request->amount;


        foreach ($lims_due_purchase_data as $key => $purchase_data) {
            if ($total_paid_amount == 0)
                break;
            $due_amount = $purchase_data->grand_total - $purchase_data->paid_amount;
            $lims_cash_register_data =  CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $purchase_data->warehouse_id],
                    ['status', 1]
                ])->first();
            if ($lims_cash_register_data)
                $cash_register_id = $lims_cash_register_data->id;
            else
                $cash_register_id = null;

            if ($total_paid_amount >= $due_amount) {
                $paid_amount = $due_amount;
                $payment_status = 2;
            } else {
                $paid_amount = $total_paid_amount;
                $payment_status = 1;
            }

            $payment = new Payment();
            $payment->payment_reference = 'ppr-' . date("Ymd") . '-' . date("his");
            $payment->purchase_id = $purchase_data->id;
            $payment->user_id = Auth::id();
            $payment->cash_register_id = $cash_register_id;
            $payment->account_id = $request->account_id;
            $payment->amount = $paid_amount;
            $payment->change = 0;
            $payment->paying_method = $request->account_id == 1 ? 'cash' : 'bank';
            $payment->payment_note = $request->note;
            $payment->save();

            $payment_ids[] = $payment->id;

            $purchase_data->paid_amount += $paid_amount;
            $purchase_data->payment_status = $payment_status;
            $purchase_data->save();
            $total_paid_amount -= $paid_amount;
        }
        $supplier_due->payment_ids = $payment_ids;
        $supplier_due->save();

        return redirect()->back()->with('message', 'Due cleared successfully');
    }

    public function dueClearList($supplier_id)
    {
        $lims_supplier_due_list = SupplierDue::where('supplier_id', $supplier_id)->get();
        $lims_accounts = Account::where('is_active', true)->get();
        $lims_supplier = Supplier::where('id', $supplier_id)->first();
        return view('backend.supplier.due_clear_list', compact('lims_supplier_due_list', 'lims_accounts', 'lims_supplier'));
    }

    public function clearDueUpdate(Request $request, $id)
    {
        $lims_supplier_due = SupplierDue::findOrFail($id);
        $lims_account = Account::find($lims_supplier_due->account_id);
        $lims_account->total_balance += $lims_supplier_due->amount;
        $lims_account->save();

        $lims_supplier_due->account_id = $request->account_id;
        $lims_supplier_due->amount = $request->amount;
        $lims_supplier_due->note = $request->note;
        $lims_supplier_due->save();

        $lims_account = Account::find($request->account_id);
        $lims_account->total_balance -= $request->amount;
        $lims_account->save();

        $payment_ids = json_decode($lims_supplier_due->payment_ids);

        foreach ($payment_ids as $payment_id) {
            $old_payment = Payment::find($payment_id);
            $purchase = Purchase::find($old_payment->purchase_id);
            $purchase->paid_amount -= $old_payment->amount;
            $purchase->payment_status = 1;
            $purchase->save();
            $old_payment->delete();
        }

        $lims_supplier_due->payment_ids = NULL;
        $lims_supplier_due->save();
        $payment_ids = [];
        $lims_total_paid_amount = $lims_supplier_due->amount;

        $lims_due_purchase_data = Purchase::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', 1],
                ['supplier_id', $lims_supplier_due->supplier_id]
            ])->get();

        foreach ($lims_due_purchase_data as $key => $purchase_data) {
            if ($lims_total_paid_amount == 0)
                break;
            $due_amount = $purchase_data->grand_total - $purchase_data->paid_amount;
            $lims_cash_register_data =  CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $purchase_data->warehouse_id],
                    ['status', 1]
                ])->first();
            if ($lims_cash_register_data)
                $cash_register_id = $lims_cash_register_data->id;
            else
                $cash_register_id = null;

            if ($lims_total_paid_amount >= $due_amount) {
                $paid_amount = $due_amount;
                $payment_status = 2;
            } else {
                $paid_amount = $lims_total_paid_amount;
                $payment_status = 1;
            }

            $payment = new Payment();
            $payment->payment_reference = 'ppr-' . date("Ymd") . '-' . date("his");
            $payment->purchase_id = $purchase_data->id;
            $payment->user_id = Auth::id();
            $payment->cash_register_id = $cash_register_id;
            $payment->account_id = $lims_supplier_due->account_id;
            $payment->amount = $paid_amount;
            $payment->change = 0;
            $payment->paying_method = $lims_supplier_due->account_id == 1 ? 'cash' : 'bank';
            $payment->payment_note = $request->note;
            $payment->save();

            $payment_ids[] = $payment->id;

            $purchase_data->paid_amount += $paid_amount;
            $purchase_data->payment_status = $payment_status;
            $purchase_data->save();
            $lims_total_paid_amount -= $paid_amount;
        }

        $lims_supplier_due->payment_ids = $payment_ids;
        $lims_supplier_due->save();

        return redirect('suppliers/dueClear-list/' . $lims_supplier_due->supplier_id)->with('message', 'Due cleared updated successfully');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('suppliers-add')) {
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            return view('backend.supplier.create', compact('lims_customer_group_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                Rule::unique('suppliers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'email' => [
                'max:255',
                Rule::unique('suppliers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        //validation for customer if create both user and supplier
        if (isset($request->both)) {
            $this->validate($request, [
                'phone_number' => [
                    'max:255',
                    Rule::unique('customers')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
            ]);
        }

        $lims_supplier_data = $request->except('image');
        $lims_supplier_data['is_active'] = true;
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['company_name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/supplier', $imageName);
            $lims_supplier_data['image'] = $imageName;
        }
        Supplier::create($lims_supplier_data);
        $message = 'Supplier';
        if (isset($request->both)) {
            Customer::create($lims_supplier_data);
            $message .= ' and Customer';
        }
        $mail_setting = MailSetting::latest()->first();
        if ($lims_supplier_data['email'] && $mail_setting) {
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($lims_supplier_data['email'])->send(new SupplierCreate($lims_supplier_data));
                if (isset($request->both))
                    Mail::to($lims_supplier_data['email'])->send(new CustomerCreate($lims_supplier_data));
                $message .= ' created successfully!';
            } catch (\Exception $e) {
                $message .= ' created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        return redirect('supplier')->with('message', $message);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('suppliers-edit')) {
            $lims_supplier_data = Supplier::where('id', $id)->first();
            return view('backend.supplier.edit', compact('lims_supplier_data'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => [
                'max:255',
                Rule::unique('suppliers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],

            'email' => [
                'max:255',
                Rule::unique('suppliers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:100000',
        ]);

        $lims_supplier_data = Supplier::findOrFail($id);

        $input = $request->except('image');
        $image = $request->image;
        if ($image) {
            $this->fileDelete('images/supplier/', $lims_supplier_data->image);

            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['company_name']);
            $imageName = $imageName . '.' . $ext;
            $image->move('public/images/supplier', $imageName);
            $input['image'] = $imageName;
        }

        $lims_supplier_data->update($input);
        return redirect('supplier')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $supplier_id = $request['supplierIdArray'];
        foreach ($supplier_id as $id) {
            $lims_supplier_data = Supplier::findOrFail($id);
            $lims_supplier_data->is_active = false;
            $lims_supplier_data->save();
            $this->fileDelete('images/supplier/', $lims_supplier_data->image);
        }
        return 'Supplier deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_supplier_data = Supplier::findOrFail($id);
        $lims_supplier_data->is_active = false;
        $lims_supplier_data->save();
        $this->fileDelete('images/supplier/', $lims_supplier_data->image);

        return redirect('supplier')->with('not_permitted', 'Data deleted successfully');
    }

    public function importSupplier(Request $request)
    {
        $upload = $request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($ext != 'csv')
            return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
        $filename =  $upload->getClientOriginalName();
        $filePath = $upload->getRealPath();
        //open and read
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);
        $escapedHeader = [];
        //validate
        foreach ($header as $key => $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through othe columns
        while ($columns = fgetcsv($file)) {
            if ($columns[0] == "")
                continue;
            foreach ($columns as $key => $value) {
                $value = preg_replace('/\D/', '', $value);
            }
            $data = array_combine($escapedHeader, $columns);

            $supplier = Supplier::firstOrNew(['company_name' => $data['companyname']]);
            $supplier->name = $data['name'];
            $supplier->image = $data['image'];
            $supplier->vat_number = $data['vatnumber'];
            $supplier->email = $data['email'];
            $supplier->phone_number = $data['phonenumber'];
            $supplier->address = $data['address'];
            $supplier->city = $data['city'];
            $supplier->state = $data['state'];
            $supplier->postal_code = $data['postalcode'];
            $supplier->country = $data['country'];
            $supplier->is_active = true;
            $supplier->save();
            $message = 'Supplier Imported Successfully';

            $mail_setting = MailSetting::latest()->first();


            if ($data['email'] && $mail_setting) {
                try {
                    Mail::to($data['email'])->send(new SupplierCreate($data));
                } catch (\Excetion $e) {
                    $message = 'Supplier imported successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                }
            }
        }
        return redirect('supplier')->with('message', $message);
    }

    public function suppliersAll()
    {
        $lims_supplier_list = DB::table('suppliers')->where('is_active', true)->get();

        $html = '';
        foreach ($lims_supplier_list as $supplier) {
            $html .= '<option value="' . $supplier->id . '">' . $supplier->name . ' (' . $supplier->phone_number . ')' . '</option>';
        }

        return response()->json($html);
    }
}
