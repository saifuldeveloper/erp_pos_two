<?php

namespace App\Services;

use App\Models\Table;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;

class TableService
{
    use CacheForget;

    protected TableRepositoryInterface $tableRepository;

    /**
     * TableService constructor.
     *
     * @param TableRepositoryInterface $tableRepository
     */
    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    /**
     * Get active tables.
     *
     * @return Collection
     */
    public function getActiveTables(): Collection
    {
        return $this->tableRepository->getActiveTables();
    }

    /**
     * Create table.
     *
     * @param array $requestData
     * @return Table
     */
    public function createTable(array $requestData): Table
    {
        $data = $requestData;
        $data['is_active'] = true;

        $table = $this->tableRepository->create($data);
        $this->cacheForget('table_list');

        return $table;
    }

    /**
     * Update table.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Table
     */
    public function updateTable($id, array $requestData): Table
    {
        $table = $this->tableRepository->findOrFail($id);
        $table->update($requestData);
        $this->cacheForget('table_list');

        return $table;
    }

    /**
     * Deactivate table.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTable($id): bool
    {
        $table = $this->tableRepository->findOrFail($id);
        $table->is_active = false;
        $table->save();
        $this->cacheForget('table_list');

        return true;
    }
}
