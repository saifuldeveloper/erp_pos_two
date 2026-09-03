<?php

namespace App\Services;

use App\Models\Unit;
use App\Repositories\Contracts\UnitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitService
{
    protected UnitRepositoryInterface $unitRepository;

    /**
     * UnitService constructor.
     *
     * @param UnitRepositoryInterface $unitRepository
     */
    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    /**
     * Get active units.
     *
     * @return Collection
     */
    public function getActiveUnits(): Collection
    {
        return $this->unitRepository->getActiveUnits();
    }

    /**
     * Get all units.
     *
     * @return Collection
     */
    public function getAllUnits(): Collection
    {
        return $this->unitRepository->all();
    }

    /**
     * Get unit by ID.
     *
     * @param int|string $id
     * @return Unit
     */
    public function getUnitById($id): Unit
    {
        return $this->unitRepository->findOrFail($id);
    }

    /**
     * Create a new unit.
     *
     * @param array $data
     * @return Unit
     */
    public function createUnit(array $data): Unit
    {
        $data['is_active'] = true;
        return $this->unitRepository->create($data);
    }

    /**
     * Update an existing unit.
     *
     * @param int|string $id
     * @param array $data
     * @return Unit
     */
    public function updateUnit($id, array $data): Unit
    {
        return $this->unitRepository->update($id, $data);
    }

    /**
     * Search units by name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchUnitsByName(string $name, int $perPage = 5): LengthAwarePaginator
    {
        return $this->unitRepository->searchByNamePaginated($name, $perPage);
    }

    /**
     * Import units from CSV file.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importUnits(UploadedFile $file): void
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
            $unit = $this->unitRepository->firstOrNew(['unit_code' => $data['code'], 'is_active' => true]);
            $unit->unit_code = $data['code'];
            $unit->unit_name = $data['name'];

            if ($data['baseunit'] == null) {
                $unit->base_unit = null;
            } else {
                $baseUnit = $this->unitRepository->findByUnitCode($data['baseunit']);
                $unit->base_unit = $baseUnit ? $baseUnit->id : null;
            }

            $unit->operator = $data['operator'] ?? '*';
            $unit->operation_value = $data['operationvalue'] ?? 1;
            $unit->is_active = true;
            $unit->save();
        }

        fclose($handle);
    }

    /**
     * Deactivate a unit.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteUnit($id): bool
    {
        return $this->unitRepository->deactivate($id);
    }

    /**
     * Deactivate multiple units.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleUnits(array $ids): bool
    {
        return $this->unitRepository->deactivateMultiple($ids);
    }
}
