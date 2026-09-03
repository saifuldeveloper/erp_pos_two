<?php

namespace App\Repositories\Contracts;

use App\Models\GiftCard;
use Illuminate\Database\Eloquent\Collection;

interface GiftCardRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all active gift cards.
     *
     * @return Collection
     */
    public function getActiveGiftCards(): Collection;
}
