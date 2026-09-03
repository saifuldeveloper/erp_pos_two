<?php

namespace App\Repositories\Eloquent;

use App\Models\GiftCard;
use App\Repositories\Contracts\GiftCardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GiftCardRepository extends BaseRepository implements GiftCardRepositoryInterface
{
    /**
     * GiftCardRepository constructor.
     *
     * @param GiftCard $model
     */
    public function __construct(GiftCard $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active gift cards.
     *
     * @return Collection
     */
    public function getActiveGiftCards(): Collection
    {
        return $this->model->where('is_active', true)->orderBy('id', 'desc')->get();
    }
}
