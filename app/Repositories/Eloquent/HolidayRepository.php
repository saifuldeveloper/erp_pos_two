<?php

namespace App\Repositories\Eloquent;

use App\Models\Holiday;
use App\Repositories\Contracts\HolidayRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HolidayRepository extends BaseRepository implements HolidayRepositoryInterface
{
    /**
     * HolidayRepository constructor.
     *
     * @param Holiday $model
     */
    public function __construct(Holiday $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all holidays or user-scoped holidays.
     *
     * @param bool $canApprove
     * @param int|string $userId
     * @return Collection
     */
    public function getHolidays(bool $canApprove, $userId): Collection
    {
        $q = $this->model->orderBy('id', 'desc');
        if (!$canApprove) {
            $q->where('user_id', $userId);
        }

        return $q->get();
    }
}
