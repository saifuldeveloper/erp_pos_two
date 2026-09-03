<?php

namespace App\Repositories\Eloquent;

use App\Models\Color;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Repositories\Contracts\ColorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ColorRepository extends BaseRepository implements ColorRepositoryInterface
{
    /**
     * ColorRepository constructor.
     *
     * @param Color $model
     */
    public function __construct(Color $model)
    {
        parent::__construct($model);
    }

    /**
     * Delete multiple colors by IDs.
     *
     * @param array $ids
     * @return bool
     */
    public function deleteMultiple(array $ids): bool
    {
        foreach ($ids as $id) {
            $color = $this->find($id);
            if ($color) {
                $color->delete();
            }
        }
        return true;
    }

    /**
     * Update product variant values, product variants item code, and variant names when color name changes.
     *
     * @param Model $color
     * @param string $newColorName
     * @return void
     */
    public function updateColorRelations(Model $color, string $newColorName): void
    {
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
                        $productColor = $newColorName;
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
                $itemCodeParts[0] = $newColorName;
                $variant->item_code = implode('/', $itemCodeParts);
                $variant->save();
            }
        }

        $variants = Variant::where('name', 'LIKE', $color->name . '/%')->get();

        foreach ($variants as $variant) {
            $nameParts = explode('/', $variant->name);

            if ($nameParts[0] === $color->name) {
                $nameParts[0] = $newColorName;
                $variant->name = implode('/', $nameParts);
                $variant->save();
            }
        }
    }
}
