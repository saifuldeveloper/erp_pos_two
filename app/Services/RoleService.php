<?php

namespace App\Services;

use App\Models\Roles;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;

    /**
     * RoleService constructor.
     *
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get active roles.
     *
     * @return Collection
     */
    public function getActiveRoles(): Collection
    {
        return $this->roleRepository->getActiveRoles();
    }

    /**
     * Create a role.
     *
     * @param array $requestData
     * @return Roles
     */
    public function createRole(array $requestData): Roles
    {
        $data = $requestData;
        $data['is_active'] = true;

        $role = $this->roleRepository->create($data);
        SpatieRole::firstOrCreate(['name' => $data['name']]);

        return $role;
    }

    /**
     * Get role permissions data.
     *
     * @param int|string $id
     * @return array
     */
    public function getRolePermissionsData($id): array
    {
        $lims_role_data = $this->roleRepository->findOrFail($id);
        $spatieRole = SpatieRole::findByName($lims_role_data->name);
        $permissions = $spatieRole ? $spatieRole->permissions : [];

        $all_permission = [];
        foreach ($permissions as $permission) {
            $all_permission[] = $permission->name;
        }

        return compact('lims_role_data', 'all_permission');
    }

    /**
     * Update role.
     *
     * @param int|string $id
     * @param array $requestData
     * @return Roles
     */
    public function updateRole($id, array $requestData): Roles
    {
        $role = $this->roleRepository->findOrFail($id);
        $oldName = $role->name;
        $role->update($requestData);

        $spatieRole = SpatieRole::where('name', $oldName)->first();
        if ($spatieRole && !empty($requestData['name'])) {
            $spatieRole->name = $requestData['name'];
            $spatieRole->save();
        }

        return $role;
    }

    /**
     * Delete role.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteRole($id): bool
    {
        $role = $this->roleRepository->findOrFail($id);
        $role->is_active = false;

        return (bool) $role->save();
    }
}
