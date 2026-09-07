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

echo "Testing Ecommerce API with alternate parameter names (unit_price, product_discount)...\n";

$payload = [
    'sale_type' => 'website',
    'warehouse_id' => $warehouse->id,
    'customer_info' => [
        'name' => 'API Customer Existing',
        'phone_number' => '01799999999',
        'address' => 'Dhaka',
        'city' => 'Dhaka',
    ],
    'product_id' => [$product->id],
    'product_code' => [$product->code],
    'qty' => [2],
    'sale_unit' => ['n/a'],
    'unit_price' => [$product->price ?: 100],
    'product_discount' => [10],
    'subtotal' => [($product->price ?: 100) * 2 - 20],
    'item' => 1,
    'total_qty' => 2,
    'total_discount' => 20,
    'total_tax' => 0,
    'grand_total' => ($product->price ?: 100) * 2 - 20,
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
} finally {
    DB::rollBack();
    echo "Transaction rolled back.\n";
}
