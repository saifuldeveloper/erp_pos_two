<?php

namespace App\Repositories\Contracts;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get grouped attendance records with employee and user names.
     *
     * @return array
     */
    public function getGroupedAttendanceData(): array;
}
