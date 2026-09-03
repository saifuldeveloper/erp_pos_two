<?php

namespace App\Services;

use App\Mail\HolidayApprove;
use App\Models\Holiday;
use App\Models\MailSetting;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use App\Traits\MailInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class HolidayService
{
    use MailInfo;

    protected HolidayRepositoryInterface $holidayRepository;

    /**
     * HolidayService constructor.
     *
     * @param HolidayRepositoryInterface $holidayRepository
     */
    public function __construct(HolidayRepositoryInterface $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    /**
     * Get index holiday data with approval status.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $roleId = Auth::user()?->role_id;
        $role = $roleId ? Role::find($roleId) : null;
        $approve_permission = $role && $role->hasPermissionTo('holiday');
        $lims_holiday_list = $this->holidayRepository->getHolidays($approve_permission, Auth::id());

        return compact('lims_holiday_list', 'approve_permission');
    }

    /**
     * Create a holiday record.
     *
     * @param array $requestData
     * @return Holiday
     */
    public function createHoliday(array $requestData): Holiday
    {
        $roleId = Auth::user()?->role_id;
        $role = $roleId ? Role::find($roleId) : null;
        $data = [
            'from_date'   => date("Y-m-d", strtotime(str_replace("/", "-", $requestData['from_date']))),
            'to_date'     => date("Y-m-d", strtotime(str_replace("/", "-", $requestData['to_date']))),
            'user_id'     => Auth::id(),
            'note'        => $requestData['note'] ?? null,
            'is_approved' => (bool) ($role && $role->hasPermissionTo('holiday')),
        ];

        return $this->holidayRepository->create($data);
    }

    /**
     * Approve a holiday and dispatch email notification.
     *
     * @param int|string $id
     * @return string
     */
    public function approveHoliday($id): string
    {
        $holiday = $this->holidayRepository->findOrFail($id);
        $holiday->is_approved = true;
        $holiday->save();

        if ($holiday->user) {
            $mail_data['name'] = $holiday->user->name;
            $mail_data['email'] = $holiday->user->email;
            $mail_setting = MailSetting::latest()->first();

            if ($mail_setting) {
                $this->setMailInfo($mail_setting);
                try {
                    Mail::to($mail_data['email'])->send(new HolidayApprove($mail_data));
                    return 'Holiday approved successfully!';
                } catch (\Exception $e) {
                    return 'Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                }
            }
        }

        return 'Holiday approved successfully!';
    }

    /**
     * Get user holiday dates for monthly calendar.
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    public function getMyHolidayDates(int $year, int $month): array
    {
        $holidays = [];
        $start = 1;
        $number_of_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        while ($start <= $number_of_day) {
            $date = ($start < 10) ? $year . '-' . $month . '-0' . $start : $year . '-' . $month . '-' . $start;

            $holiday_found = Holiday::whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->where([
                    ['is_approved', true],
                    ['user_id', Auth::id()]
                ])->first();

            if ($holiday_found) {
                $holidays[] = $date;
            }
            $start++;
        }

        return $holidays;
    }

    /**
     * Update holiday.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Holiday
     */
    public function updateHoliday($id, array $requestData): Holiday
    {
        $holiday = $this->holidayRepository->findOrFail($id);
        $data = [
            'from_date' => date("Y-m-d", strtotime(str_replace("/", "-", $requestData['from_date']))),
            'to_date'   => date("Y-m-d", strtotime(str_replace("/", "-", $requestData['to_date']))),
            'note'      => $requestData['note'] ?? null,
        ];

        $holiday->update($data);

        return $holiday;
    }

    /**
     * Delete a holiday.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteHoliday($id): bool
    {
        return $this->holidayRepository->delete($id);
    }

    /**
     * Delete multiple holidays.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleHolidays(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->holidayRepository->delete($id);
        }

        return true;
    }
}
