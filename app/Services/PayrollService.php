<?php

namespace App\Services;

use App\Mail\PayrollDetails;
use App\Models\Account;
use App\Models\Employee;
use App\Models\MailSetting;
use App\Models\Payroll;
use App\Models\PayrollType;
use App\Repositories\Contracts\PayrollRepositoryInterface;
use App\Traits\MailInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PayrollService
{
    use MailInfo;

    protected PayrollRepositoryInterface $payrollRepository;

    /**
     * PayrollService constructor.
     *
     * @param PayrollRepositoryInterface $payrollRepository
     */
    public function __construct(PayrollRepositoryInterface $payrollRepository)
    {
        $this->payrollRepository = $payrollRepository;
    }

    /**
     * Get index data for payroll view.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexData(Request $request): array
    {
        if ($request->input('starting_date')) {
            $starting_date = $request->input('starting_date');
            $ending_date = $request->input('ending_date');
        } else {
            $payroll = Payroll::orderBy('created_at', 'asc')->get();
            $starting_date = $payroll->isEmpty() ? date('Y-m-d') : $payroll->first()->created_at->format('Y-m-d');
            $ending_date = $payroll->isEmpty() ? date('Y-m-d') : $payroll->last()->created_at->format('Y-m-d');
        }

        $employee_id = $request->input('employee_id', '');

        $lims_account_list = Account::where('is_active', true)->get();
        $lims_employee_list = Employee::where('is_active', true)->get();
        $lims_payroll_types = PayrollType::where('status', 'Active')->get();
        $lims_payroll_all = $this->payrollRepository->getFilteredPayrolls($starting_date, $ending_date, $employee_id);

        return compact(
            'lims_account_list',
            'lims_employee_list',
            'lims_payroll_all',
            'starting_date',
            'ending_date',
            'employee_id',
            'lims_payroll_types'
        );
    }

    /**
     * Create a payroll payment and optional mail notification.
     *
     * @param array $requestData
     * @return array
     */
    public function createPayroll(array $requestData): array
    {
        $data = $requestData;

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        } else {
            $data['created_at'] = date("Y-m-d H:i:s");
        }

        $data['reference_no'] = 'payroll-' . date("Ymd") . '-' . date("his");
        $data['user_id'] = Auth::id();

        $payroll = $this->payrollRepository->create($data);
        $message = 'Payroll created successfully';

        $lims_employee_data = Employee::find($data['employee_id']);
        if ($lims_employee_data) {
            $mail_data['reference_no'] = $data['reference_no'];
            $mail_data['amount'] = $data['amount'];
            $mail_data['name'] = $lims_employee_data->name;
            $mail_data['email'] = $lims_employee_data->email;
            $mail_data['currency'] = config('currency');

            $mail_setting = MailSetting::latest()->first();
            if ($mail_setting && $mail_data['email']) {
                $this->setMailInfo($mail_setting);
                try {
                    Mail::to($mail_data['email'])->send(new PayrollDetails($mail_data));
                } catch (\Exception $e) {
                    $message = 'Payroll created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                }
            }
        }

        return ['payroll' => $payroll, 'message' => $message];
    }

    /**
     * Update an existing payroll payment.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Payroll
     */
    public function updatePayroll($id, array $requestData): Payroll
    {
        $data = $requestData;
        $payroll = $this->payrollRepository->findOrFail($id);

        if (isset($data['created_at'])) {
            $data['created_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
        }

        $payroll->update($data);

        return $payroll;
    }

    /**
     * Delete a payroll record.
     *
     * @param int|string $id
     * @return bool
     */
    public function deletePayroll($id): bool
    {
        return $this->payrollRepository->delete($id);
    }

    /**
     * Delete multiple payroll records.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultiplePayrolls(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->payrollRepository->delete($id);
        }
        return true;
    }
}
