<?php

namespace App\Repositories\Eloquent;

use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    /**
     * TableRepository constructor.
     *
     * @param Table $model
     */
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all active restaurant tables.
     *
     * @return Collection
     */
    public function getActiveTables(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
}
