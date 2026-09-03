<?php

namespace App\Services;

use App\Models\Tax;
use App\Repositories\Contracts\TaxRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxService
{
    use CacheForget;

    protected TaxRepositoryInterface $taxRepository;

    /**
     * TaxService constructor.
     *
     * @param TaxRepositoryInterface $taxRepository
     */
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * Get all active taxes.
     *
     * @return Collection
     */
    public function getActiveTaxes(): Collection
    {
        return cache()->remember('tax_list', 60 * 60 * 24 * 365, function () {
            return $this->taxRepository->getActiveTaxes();
        });
    }

    /**
     * Get all taxes.
     *
     * @return Collection
     */
    public function getAllTaxes(): Collection
    {
        return $this->taxRepository->all();
    }

    /**
     * Get tax by ID.
     *
     * @param int|string $id
     * @return Tax
     */
    public function getTaxById($id): Tax
    {
        return $this->taxRepository->findOrFail($id);
    }

    /**
     * Create a new tax.
     *
     * @param array $data
     * @return Tax
     */
    public function createTax(array $data): Tax
    {
        $data['is_active'] = true;
        $tax = $this->taxRepository->create($data);
        $this->cacheForget('tax_list');

        return $tax;
    }

    /**
     * Update an existing tax.
     *
     * @param int|string $id
     * @param array $data
     * @return Tax
     */
    public function updateTax($id, array $data): Tax
    {
        $tax = $this->taxRepository->findOrFail($id);
        $tax->update($data);
        $this->cacheForget('tax_list');

        return $tax;
    }

    /**
     * Search taxes by name with pagination.
     *
     * @param string $name
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchTaxesByName(string $name, int $perPage = 5): LengthAwarePaginator
    {
        return $this->taxRepository->searchByNamePaginated($name, $perPage);
    }

    /**
     * Import taxes from CSV file.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importTaxes(UploadedFile $file): void
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
            $tax = $this->taxRepository->firstOrNew(['name' => $data['name'], 'is_active' => true]);
            $tax->name = $data['name'];
            $tax->rate = $data['rate'] ?? 0;
            $tax->is_active = true;
            $tax->save();
        }

        fclose($handle);
        $this->cacheForget('tax_list');
    }

    /**
     * Deactivate a tax.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteTax($id): bool
    {
        $result = $this->taxRepository->deactivate($id);
        $this->cacheForget('tax_list');

        return $result;
    }

    /**
     * Deactivate multiple taxes.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleTaxes(array $ids): bool
    {
        $result = $this->taxRepository->deactivateMultiple($ids);
        $this->cacheForget('tax_list');

        return $result;
    }
}
