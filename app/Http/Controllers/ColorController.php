<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Variant;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('backend.color.index', compact('colors'));
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



    public function destroy(string $id)
    {
        $color = Color::find($id);
        $color->delete();

        return redirect()->route('color.index');
    }
}
