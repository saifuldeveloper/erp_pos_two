<?php

namespace App\Http\Controllers;

use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Requests\Color\UpdateColorRequest;
use App\Services\ColorService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;

class ColorController extends Controller
{
    protected ColorService $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('color-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            $all_permission = [];
            foreach ($permissions as $permission) {
                $all_permission[] = $permission->name;
            }
            if (empty($all_permission)) {
                $all_permission[] = 'dummy text';
            }
            $colors = $this->colorService->getAllColors();
            return view('backend.color.index', compact('colors', 'all_permission'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(StoreColorRequest $request)
    {
        $this->colorService->createColor($request->only('name', 'code'));

        return redirect()->route('color.index');
    }

    public function edit(string $id)
    {
        return $this->colorService->getColorById($id);
    }

    public function update(UpdateColorRequest $request, string $id)
    {
        $this->colorService->updateColor($request->color_id, $request->only('name', 'code'));

        return redirect()->route('color.index');
    }

    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('color-delete')) {
            return 'Sorry! You are not allowed to delete color';
        }

        $color_id = $request['colorIdArray'];
        $this->colorService->deleteMultipleColors($color_id);

        return 'Color deleted successfully!';
    }

    public function destroy(string $id)
    {
        $role = Role::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('color-delete')) {
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete color');
        }

        $this->colorService->deleteColor($id);

        return redirect()->route('color.index');
    }
}
