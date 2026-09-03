<?php

namespace App\Repositories\Eloquent;

use App\Models\Discount;
use App\Repositories\Contracts\DiscountRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    /**
     * DiscountRepository constructor.
     *
     * @param Discount $model
     */
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all discounts with discount plans.
     *
     * @return Collection
     */
    public function getAllWithPlans(): Collection
    {
        return $this->model->with('discountPlans')->orderBy('id', 'desc')->get();
    }
}
