<?php

namespace App\Repositories\Eloquent;

use App\Models\Delivery;
use App\Repositories\Contracts\DeliveryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DeliveryRepository extends BaseRepository implements DeliveryRepositoryInterface
{
    /**
     * DeliveryRepository constructor.
     *
     * @param Delivery $model
     */
    public function __construct(Delivery $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all deliveries with role scoping.
     *
     * @return Collection
     */
    public function getAllDeliveries(): Collection
    {
        $q = $this->model->orderBy('id', 'desc');
        if (Auth::user() && Auth::user()->role_id > 2 && config('staff_access') == 'own') {
            $q->where('user_id', Auth::id());
        }

        return $q->get();
    }

    /**
     * Get delivery by sale ID.
     *
     * @param int|string $saleId
     * @return Delivery|null
     */
    public function getDeliveryBySaleId($saleId): ?Delivery
    {
        return $this->model->where('sale_id', $saleId)->first();
    }
}
