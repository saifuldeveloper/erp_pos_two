<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;

class ColorController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('color-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $colors = Color::all();
            return view('backend.color.index', compact('colors', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors',
        ]);


        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();

        return redirect()->route('color.index');
    }

    public function edit(string $id)
    {
        $color = Color::find($id);
        return $color;
    }

    public function update(Request $request, string $id)
    {
        $color = Color::find($request->color_id);
        $products = $color->products()->get();

        foreach ($products as $product) {
            $variantValue = $product->variant_value;

            if (is_string($variantValue)) {
                $variantValue = json_decode($variantValue, true);
            }

            if (!empty($variantValue[0])) {
                $colors = explode(',', $variantValue[0]);

                foreach ($colors as &$productColor) {
                    if ($productColor == $color->name) {
                        $productColor = $request->name;
                    }
                }

                $variantValue[0] = implode(',', $colors);
                $product->variant_value = json_encode($variantValue);
                $product->save();
            }
        }

        // Update ProductVariants' item_code
        $productVariants = ProductVariant::where('item_code', 'LIKE', $color->name . '/%')->get();

        foreach ($productVariants as $variant) {
            $itemCodeParts = explode('/', $variant->item_code);

            if ($itemCodeParts[0] === $color->name) {
                $itemCodeParts[0] = $request->name;
                $variant->item_code = implode('/', $itemCodeParts);
                $variant->save();
            }
        }

        $variants = Variant::where('name', 'LIKE', $color->name . '/%')->get();

        foreach ($variants as $variant) {
            $nameParts = explode('/', $variant->name);

            if ($nameParts[0] === $color->name) {
                $nameParts[0] = $request->name;
                $variant->name = implode('/', $nameParts);
                $variant->save();
            }
        }

        // Update the color itself
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();

        return redirect()->route('color.index');
    }



    public function deleteBySelection(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if(!$role->hasPermissionTo('color-delete'))
            return 'Sorry! You are not allowed to delete color';

        $color_id = $request['colorIdArray'];
        foreach ($color_id as $id) {
            $color = Color::find($id);
            if($color)
                $color->delete();
        }
        return 'Color deleted successfully!';
    }

    public function destroy(string $id)
    {
        $role = Role::find(Auth::user()->role_id);
        if(!$role->hasPermissionTo('color-delete'))
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to delete color');

        $color = Color::find($id);
        if($color)
            $color->delete();

        return redirect()->route('color.index');
    }
}
