<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Biller;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Roles;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('users-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }

            $indexData = $this->userService->getIndexData();
            $lims_user_list = $indexData['lims_user_list'];
            $numberOfUserAccount = $indexData['numberOfUserAccount'];

            return view('backend.user.index', compact('lims_user_list', 'all_permission', 'numberOfUserAccount'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('users-add')) {
            $formData = $this->userService->getCreateFormData();
            return view('backend.user.create', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function generatePassword()
    {
        return $this->userService->generatePassword();
    }

    public function store(StoreUserRequest $request)
    {
        $result = $this->userService->createUser($request->all());

        return redirect('user')->with('message1', $result['message']);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('users-edit')) {
            $formData = $this->userService->getEditFormData($id);
            return view('backend.user.edit', $formData);
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updateUser($id, $request->all());

        return redirect('user')->with('message2', 'Data updated successfullly');
    }

    public function profile($id)
    {
        $lims_user_data = User::find($id);
        return view('backend.user.profile', compact('lims_user_data'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
            'email' => [
                'email',
                'max:255',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    return $query->where('is_deleted', false);
                }),
            ],
        ]);

        $this->userService->updateUser($id, $request->all());

        return redirect()->back()->with('message3', 'Data updated successfullly');
    }

    public function changePassword(Request $request, $id)
    {
        $success = $this->userService->changePassword($id, $request->all());
        if ($success) {
            return redirect('user')->with('message2', 'Password changed successfully');
        }

        return redirect('user')->with('message4', "Current Password doesn't match");
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('users-delete')) {
            return 'Sorry! You are not allowed to delete user';
        }

        $user_ids = $request['userIdArray'] ?? [];
        $this->userService->deleteMultipleUsers($user_ids);

        return 'User deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('users-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete user');
        }

        $this->userService->deleteUser($id);

        return redirect('user')->with('message3', 'Data deleted successfullly');
    }

    public function allUsers()
    {
        $lims_user_list = User::where('is_deleted', false)->get();
        return response()->json($lims_user_list);
    }

    public function notificationUsers()
    {
        $lims_user_list = User::where([
            ['is_deleted', false],
            ['id', '!=', Auth::id()]
        ])->get();

        return response()->json($lims_user_list);
    }
}
