<?php

namespace App\Services;

use App\Models\CustomField;
use App\Repositories\Contracts\CustomFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomFieldService
{
    protected CustomFieldRepositoryInterface $customFieldRepository;

    /**
     * CustomFieldService constructor.
     *
     * @param CustomFieldRepositoryInterface $customFieldRepository
     */
    public function __construct(CustomFieldRepositoryInterface $customFieldRepository)
    {
        $this->customFieldRepository = $customFieldRepository;
    }

    /**
     * Get all custom fields.
     *
     * @return Collection
     */
    public function getAllCustomFields(): Collection
    {
        return $this->customFieldRepository->getAllOrdered();
    }

    /**
     * Create a custom field and alter database table.
     *
     * @param array $requestData
     * @return CustomField
     */
    public function createCustomField(array $requestData): CustomField
    {
        $data = $requestData;
        $tableName = match ($data['belongs_to']) {
            'sale'     => 'sales',
            'purchase' => 'purchases',
            'product'  => 'products',
            'customer' => 'customers',
            default    => 'sales',
        };

        $columnName = str_replace(" ", "_", strtolower($data['name']));
        $dataType = match ($data['type']) {
            'number'   => 'double',
            'textarea' => 'text',
            default    => 'varchar(255)',
        };

        if (!Schema::hasColumn($tableName, $columnName)) {
            $sqlStatement = "ALTER TABLE " . $tableName . " ADD " . $columnName . " " . $dataType;
            if (!empty($data['default_value_1'])) {
                $sqlStatement .= " DEFAULT '" . $data['default_value_1'] . "'";
                $data['default_value'] = $data['default_value_1'];
            } elseif (!empty($data['default_value_2'])) {
                $sqlStatement .= " DEFAULT '" . $data['default_value_2'] . "'";
                $data['default_value'] = $data['default_value_2'];
            }
            DB::statement($sqlStatement);
        }

        $data['is_table'] = isset($data['is_table']);
        $data['is_invoice'] = isset($data['is_invoice']);
        $data['is_required'] = isset($data['is_required']);
        $data['is_admin'] = isset($data['is_admin']);
        $data['is_disable'] = isset($data['is_disable']);

        return $this->customFieldRepository->create($data);
    }

    /**
     * Update custom field.
     *
     * @param int|string $id
     * @param array $requestData
     * @return CustomField
     */
    public function updateCustomField($id, array $requestData): CustomField
    {
        $customField = $this->customFieldRepository->findOrFail($id);
        $data = $requestData;

        $data['is_table'] = isset($data['is_table']);
        $data['is_invoice'] = isset($data['is_invoice']);
        $data['is_required'] = isset($data['is_required']);
        $data['is_admin'] = isset($data['is_admin']);
        $data['is_disable'] = isset($data['is_disable']);

        $customField->update($data);

        return $customField;
    }

    /**
     * Drop column from table and delete custom field.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteCustomField($id): bool
    {
        $customField = $this->customFieldRepository->findOrFail($id);
        $tableName = match ($customField->belongs_to) {
            'sale'     => 'sales',
            'purchase' => 'purchases',
            'product'  => 'products',
            'customer' => 'customers',
            default    => 'sales',
        };

        $columnName = str_replace(" ", "_", strtolower($customField->name));
        if (Schema::hasColumn($tableName, $columnName)) {
            DB::statement("ALTER TABLE " . $tableName . " DROP COLUMN " . $columnName);
        }

        return $this->customFieldRepository->delete($id);
    }
}
