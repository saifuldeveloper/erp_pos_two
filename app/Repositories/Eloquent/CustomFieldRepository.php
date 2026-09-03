<?php

namespace App\Repositories\Eloquent;

use App\Models\CustomField;
use App\Repositories\Contracts\CustomFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomFieldRepository extends BaseRepository implements CustomFieldRepositoryInterface
{
    /**
     * CustomFieldRepository constructor.
     *
     * @param CustomField $model
     */
    public function __construct(CustomField $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all custom fields ordered by ID descending.
     *
     * @return Collection
     */
    public function getAllOrdered(): Collection
    {
        return $this->model->orderBy('id', 'desc')->get();
    }
}
