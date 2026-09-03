<?php

namespace App\Services;

use App\Mail\UserDetails;
use App\Models\Biller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\MailSetting;
use App\Models\Roles;
use App\Models\User;
use App\Models\Warehouse;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Traits\MailInfo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Keygen\Keygen;

class UserService
{
    use MailInfo;

    protected UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get index data for user view.
     *
     * @return array
     */
    public function getIndexData(): array
    {
        $lims_user_list = $this->userRepository->getNonDeletedUsers();
        $numberOfUserAccount = $this->userRepository->countActiveUsers();

        return compact('lims_user_list', 'numberOfUserAccount');
    }

    /**
     * Get data required for create user form.
     *
     * @return array
     */
    public function getCreateFormData(): array
    {
        $lims_role_list = Roles::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $numberOfUserAccount = $this->userRepository->countActiveUsers();

        return compact('lims_role_list', 'lims_biller_list', 'lims_warehouse_list', 'numberOfUserAccount');
    }

    /**
     * Generate 6-digit random password.
     *
     * @return string
     */
    public function generatePassword(): string
    {
        return Keygen::numeric(6)->generate();
    }

    /**
     * Create a user with optional mail notification.
     *
     * @param array $requestData
     * @return array
     */
    public function createUser(array $requestData): array
    {
        $data = $requestData;
        $message = 'User created successfully';

        $mail_setting = MailSetting::latest()->first();
        if ($mail_setting) {
            $this->setMailInfo($mail_setting);
            try {
                Mail::to($data['email'])->send(new UserDetails($data));
            } catch (\Exception $e) {
                $message = 'User created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }

        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $data['is_deleted'] = false;
        $data['password'] = bcrypt($data['password']);
        $data['phone'] = $data['phone_number'] ?? ($data['phone'] ?? null);

        $user = $this->userRepository->create($data);

        return ['user' => $user, 'message' => $message];
    }

    /**
     * Get data for edit user view.
     *
     * @param int|string $id
     * @return array
     */
    public function getEditFormData($id): array
    {
        $lims_user_data = $this->userRepository->findOrFail($id);
        $lims_role_list = Roles::where('is_active', true)->get();
        $lims_biller_list = Biller::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_customer_group_list = CustomerGroup::where('is_active', true)->get();
        $lims_customer_list = Customer::where('is_active', true)->get();

        return compact(
            'lims_user_data',
            'lims_role_list',
            'lims_biller_list',
            'lims_warehouse_list',
            'lims_customer_group_list',
            'lims_customer_list'
        );
    }

    /**
     * Update user details.
     *
     * @param int|string $id
     * @param array $requestData
     * @return User
     */
    public function updateUser($id, array $requestData): User
    {
        $data = $requestData;
        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }
        $data['phone'] = $data['phone_number'] ?? ($data['phone'] ?? null);

        $user = $this->userRepository->findOrFail($id);
        $user->update($data);

        return $user;
    }

    /**
     * Change user password.
     *
     * @param int|string $id
     * @param array $requestData
     * @return bool
     */
    public function changePassword($id, array $requestData): bool
    {
        $user = $this->userRepository->findOrFail($id);
        if (Hash::check($requestData['current_pass'], $user->password)) {
            $user->password = bcrypt($requestData['new_pass']);
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * Soft-delete user.
     *
     * @param int|string $id
     * @return bool
     */
    public function deleteUser($id): bool
    {
        $user = $this->userRepository->findOrFail($id);
        $user->is_deleted = true;
        $user->is_active = false;

        return (bool) $user->save();
    }

    /**
     * Soft-delete multiple users.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultipleUsers(array $ids): bool
    {
        foreach ($ids as $id) {
            $this->deleteUser($id);
        }
        return true;
    }
}
