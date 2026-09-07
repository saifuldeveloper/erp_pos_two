<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Unit;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use App\Models\Product_Warehouse;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use Illuminate\Support\Facades\Schema;

echo "=== BRAND Avijatry ===\n";
$brand = Brand::where('title', 'Avijatry')->first();
print_r($brand ? $brand->toArray() : 'NULL');

echo "\n=== SUPPLIER Avijatry ===\n";
$supplier = Supplier::where('name', 'Avijatry')->first();
print_r($supplier ? $supplier->toArray() : 'NULL');

echo "\n=== WAREHOUSE ===\n";
$warehouse = Warehouse::first();
print_r($warehouse ? $warehouse->toArray() : 'NULL');

echo "\n=== UNIT ===\n";
$unit = Unit::first();
print_r($unit ? $unit->toArray() : 'NULL');

echo "\n=== PRODUCT_WAREHOUSE COLUMNS ===\n";
print_r(Schema::getColumnListing('product_warehouse'));

echo "\n=== PRODUCT_PURCHASES COLUMNS ===\n";
print_r(Schema::getColumnListing('product_purchases'));

echo "\n=== SAMPLE PRODUCT_WAREHOUSE WITH VARIANT ===\n";
$pw = Product_Warehouse::whereNotNull('variant_id')->first();
print_r($pw ? $pw->toArray() : 'NULL');

echo "\n=== SAMPLE PRODUCT_PURCHASE WITH VARIANT ===\n";
$pp = ProductPurchase::whereNotNull('variant_id')->first();
print_r($pp ? $pp->toArray() : 'NULL');

echo "\n=== SAMPLE PRODUCT_VARIANT ===\n";
$pv = ProductVariant::first();
print_r($pv ? $pv->toArray() : 'NULL');

echo "\n=== HOW PurchaseService HANDLES VARIANT IN PURCHASES ===\n";
