<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Http\Controllers\API\Website\EcommersController;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$user = User::first();
Auth::login($user);

$product = Product::first();
$warehouse = Warehouse::first();

echo "Testing Ecommerce API order store with Product ID: {$product->id}, Warehouse ID: {$warehouse->id}\n";

$payload = [
    'sale_type' => 'website',
    'warehouse_id' => $warehouse->id,
    'customer_info' => [
        'name' => 'API Customer Test',
        'phone_number' => '01799999999',
        'address' => 'Dhaka',
        'city' => 'Dhaka',
    ],
    'product_id' => [$product->id],
    'product_code' => [$product->code],
    'qty' => [1],
    'sale_unit' => ['piece'],
    'net_unit_price' => [$product->price ?: 100],
    'discount' => [0],
    'tax_rate' => [0],
    'tax' => [0],
    'subtotal' => [$product->price ?: 100],
    'item' => 1,
    'total_qty' => 1,
    'total_discount' => 0,
    'total_tax' => 0,
    'total_price' => $product->price ?: 100,
    'grand_total' => $product->price ?: 100,
    'order_tax_rate' => 0,
    'order_tax' => 0,
    'order_discount' => 0,
    'shipping_cost' => 50,
    'sale_status' => 1,
    'payment_status' => 1,
    'paid_amount' => 0,
    'pos' => 0,
];

DB::beginTransaction();
try {
    $controller = app(EcommersController::class);
    $request = new Request($payload);
    $response = $controller->store($request);
    
    echo "API Response Status: " . $response->getStatusCode() . "\n";
    echo "API Response Body: " . $response->getContent() . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
} finally {
    DB::rollBack();
    echo "Transaction rolled back.\n";
}
