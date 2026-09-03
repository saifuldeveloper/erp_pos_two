<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Repositories\Contracts\WarehouseRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class WarehouseService
{
    use CacheForget;

    protected WarehouseRepositoryInterface $warehouseRepository;

    /**
     * WarehouseService constructor.
     *
     * @param WarehouseRepositoryInterface $warehouseRepository
     */
    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * Get all active warehouses.
     *
     * @return Collection
     */
    public function getActiveWarehouses(): Collection
    {
        return $this->warehouseRepository->getActiveWarehouses();
    }

    /**
     * Count active warehouses.
     *
     * @return int
     */
    public function countActiveWarehouses(): int
    {
        return $this->warehouseRepository->getActiveWarehouses()->count();
    }

    /**
     * Get warehouse by ID.
     *
     * @param int|string $id
     * @return Warehouse
     */
    public function getWarehouseById($id): Warehouse
    {
        return $this->warehouseRepository->findOrFail($id);
    }

    /**
     * Create a new warehouse.
     *
     * @param array $data
     * @return Warehouse
     */
    public function createWarehouse(array $data): Warehouse
    {
        $data['is_active'] = true;
        $warehouse = $this->warehouseRepository->create($data);
        $this->cacheForget('warehouse_list');

        return $warehouse;
    }

    /**
     * Update an existing warehouse.
     *
     * @param int|string $id
     * @param array $data
     * @return Warehouse
     */
    public function updateWarehouse($id, array $data): Warehouse
    {
        $warehouse = $this->warehouseRepository->findOrFail($id);
        $warehouse->update($data);
        $this->cacheForget('warehouse_list');

        return $warehouse;
    }

    /**
     * Import warehouses from CSV.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importWarehouses(UploadedFile $file): void
    {
        $filePath = $file->getRealPath();
        $handle = fopen($filePath, 'r');
        $header = fgetcsv($handle);
        $escapedHeader = [];

        foreach ($header as $value) {
            $lheader = strtolower($value);
            $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
            $escapedHeader[] = $escapedItem;
        }

        while ($columns = fgetcsv($handle)) {
            if ($columns[0] == '') {
                continue;
            }

            foreach ($columns as $key => $value) {
                $columns[$key] = preg_replace('/\D/', '', $value);
            }

            $data = array_combine($escapedHeader, $columns);
            $warehouse = $this->warehouseRepository->firstOrNew(['name' => $data['name'], 'is_active' => true]);
            $warehouse->name = $data['name'];
            $warehouse->phone = $data['phone'] ?? null;
            $warehouse->email = $data['email'] ?? null;
            $warehouse->address = $data['address'] ?? null;
            $warehouse->is_active = true;
            $warehouse->save();
        }

        fclose($handle);
        $this->cacheForget('warehouse_list');
    }

    /**
     * Deactivate a warehouse.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteWarehouse($id): bool
    {
        $result = $this->warehouseRepository->deactivate($id);
        $this->cacheForget('warehouse_list');

        return $result;
    }

    /**
     * Deactivate multiple warehouses.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleWarehouses(array $ids): bool
    {
        $result = $this->warehouseRepository->deactivateMultiple($ids);
        $this->cacheForget('warehouse_list');

        return $result;
    }

    /**
     * Get HTML options for warehouse select dropdown based on user access.
     *
     * @param int|null $roleId
     * @param int|null $warehouseId
     * @return string
     */
    public function getWarehouseOptionsHtml(?int $roleId = null, ?int $warehouseId = null): string
    {
        $warehouses = $this->warehouseRepository->getWarehousesForUser($roleId, $warehouseId);
        $html = '';
        foreach ($warehouses as $warehouse) {
            $html .= '<option value="' . $warehouse->id . '">' . $warehouse->name . '</option>';
        }

        return $html;
    }
}
