<?php

namespace App\Services;

use App\Models\CustomerGroup;
use App\Repositories\Contracts\CustomerGroupRepositoryInterface;
use App\Traits\CacheForget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class CustomerGroupService
{
    use CacheForget;

    protected CustomerGroupRepositoryInterface $customerGroupRepository;

    /**
     * CustomerGroupService constructor.
     *
     * @param CustomerGroupRepositoryInterface $customerGroupRepository
     */
    public function __construct(CustomerGroupRepositoryInterface $customerGroupRepository)
    {
        $this->customerGroupRepository = $customerGroupRepository;
    }

    /**
     * Get all active customer groups.
     *
     * @return Collection
     */
    public function getActiveCustomerGroups(): Collection
    {
        return $this->customerGroupRepository->getActiveCustomerGroups();
    }

    /**
     * Get customer group by ID.
     *
     * @param int|string $id
     * @return CustomerGroup
     */
    public function getCustomerGroupById($id): CustomerGroup
    {
        return $this->customerGroupRepository->findOrFail($id);
    }

    /**
     * Create a new customer group.
     *
     * @param array $data
     * @return CustomerGroup
     */
    public function createCustomerGroup(array $data): CustomerGroup
    {
        $data['is_active'] = true;
        $customerGroup = $this->customerGroupRepository->create($data);
        $this->cacheForget('customer_group_list');

        return $customerGroup;
    }

    /**
     * Update an existing customer group.
     *
     * @param int|string $id
     * @param array $data
     * @return CustomerGroup
     */
    public function updateCustomerGroup($id, array $data): CustomerGroup
    {
        $customerGroup = $this->customerGroupRepository->findOrFail($id);
        $customerGroup->update($data);
        $this->cacheForget('customer_group_list');

        return $customerGroup;
    }

    /**
     * Import customer groups from CSV.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function importCustomerGroups(UploadedFile $file): void
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
            $customerGroup = $this->customerGroupRepository->firstOrNew(['name' => $data['name'], 'is_active' => true]);
            $customerGroup->name = $data['name'];
            $customerGroup->percentage = $data['percentage'] ?? 0;
            $customerGroup->is_active = true;
            $customerGroup->save();
        }

        fclose($handle);
        $this->cacheForget('customer_group_list');
    }

    /**
     * Export selected customer groups to CSV.
     *
     * @param array $customerGroupIds
     * @return string Download URL
     */
    public function exportCustomerGroups(array $customerGroupIds): string
    {
        $csvData = ['name, percentage'];
        foreach ($customerGroupIds as $id) {
            if ($id > 0) {
                $data = $this->customerGroupRepository->find($id);
                if ($data) {
                    $csvData[] = $data->name . ',' . $data->percentage;
                }
            }
        }

        $filename = "customer_group-" . date('d-m-Y') . ".csv";
        $filePath = public_path() . '/downloads/' . $filename;
        $fileUrl = url('/') . '/downloads/' . $filename;

        if (!file_exists(public_path('downloads'))) {
            @mkdir(public_path('downloads'), 0755, true);
        }

        $file = fopen($filePath, "w+");
        foreach ($csvData as $exp_data) {
            fputcsv($file, explode(',', $exp_data));
        }
        fclose($file);

        return $fileUrl;
    }

    /**
     * Deactivate a customer group.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCustomerGroup($id): bool
    {
        $result = $this->customerGroupRepository->deactivate($id);
        $this->cacheForget('customer_group_list');

        return $result;
    }

    /**
     * Deactivate multiple customer groups.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleCustomerGroups(array $ids): bool
    {
        $result = $this->customerGroupRepository->deactivateMultiple($ids);
        $this->cacheForget('customer_group_list');

        return $result;
    }

    /**
     * Get HTML options for customer group select dropdown.
     *
     * @return string
     */
    public function getCustomerGroupOptionsHtml(): string
    {
        $groups = $this->customerGroupRepository->getActiveCustomerGroups();
        $html = '';
        foreach ($groups as $group) {
            $html .= '<option value="' . $group->id . '">' . $group->name . '</option>';
        }

        return $html;
    }
}
