<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('department-index') || $role->hasPermissionTo('department')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_department_all = Department::where('is_active', true)->get();
            return view('backend.department.index', compact('lims_department_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('departments')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $data = $request->all();
        $data['is_active'] = true;
        Department::create($data);
        return redirect('departments')->with('message', 'Department created successfully');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => [
                'max:255',
                Rule::unique('departments')->ignore($request->department_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $data = $request->all();
        $lims_department_data = Department::find($data['department_id']);
        $lims_department_data->update($data);
        return redirect('departments')->with('message', 'Department updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if(!$role->hasPermissionTo('department-delete'))
            return 'Sorry! You are not allowed to delete department';

        $department_id = $request['departmentIdArray'];
        foreach ($department_id as $id) {
            $lims_department_data = Department::find($id);
            $lims_department_data->is_active = false;
            $lims_department_data->save();
        }
        return 'Department deleted successfully!';
    }

    public function destroy($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if(!$role->hasPermissionTo('department-delete'))
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete department');

        $lims_department_data = Department::find($id);
        $lims_department_data->is_active = false;
        $lims_department_data->save();
        return redirect('departments')->with('message', 'Department deleted successfully');
    }
}
