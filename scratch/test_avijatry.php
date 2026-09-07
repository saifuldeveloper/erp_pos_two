<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Http\Controllers\AvijatryController;
use App\Services\AvijatryService;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Product_Warehouse;
use App\Models\ProductPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Login as admin
$user = User::first();
Auth::login($user);

echo "Logged in as: " . $user->name . "\n";

// Let's inspect an existing invoice or mock invoice to test invoiceApprove logic
$mockInvoice = [
    'id' => 99999,
    'commission' => 10,
    'total_pairs' => 5,
    'discount' => 50,
    'transport' => 100,
    'total_amount' => 5000,
    'total_receivable' => 4550,
    'total_commission' => 500,
    'total_payment' => 0,
    'gift_transactions' => [],
    'invoice_entries' => [
        [
            'invoice_id' => 99999,
            'count' => 5,
            'shoe' => [
                'id' => 888,
                'code' => 'TESTSHOE01',
                'retail_price' => 1000,
                'category' => [
                    'name' => 'Test Loafer',
                    'parent' => null
                ],
                'color' => [
                    'name' => 'Black'
                ],
                'shoe_to_size' => [
                    [
                        'reference_id' => 99999,
                        'shoe_id' => 888,
                        'type' => 'sale',
                        'quantity' => 2,
                        'size' => ['name' => '40']
                    ],
                    [
                        'reference_id' => 99999,
                        'shoe_id' => 888,
                        'type' => 'sale',
                        'quantity' => 3,
                        'size' => ['name' => '41']
                    ]
                ]
            ]
        ]
    ]
];

$reqData = [
    'invoice_id' => 99999,
    'sent_quantity' => [
        'TESTSHOE01' => [
            '40' => 2,
            '41' => 3
        ]
    ],
    'received_quantity' => [
        'TESTSHOE01' => [
            '40' => 2,
            '41' => 3
        ]
    ],
    'retail_price' => [
        'TESTSHOE01' => [
            '40' => 1000,
            '41' => 1000
        ]
    ],
    'price' => [
        'TESTSHOE01' => [
            '40' => 2000,
            '41' => 3000
        ]
    ],
    'total_amount' => 5000,
    'grand_total' => 4550,
    'paid_amount' => 4550,
    'note' => 'Test Avijatry Purchase Note'
];

$request = new Request($reqData);

$controller = app(AvijatryController::class);

DB::beginTransaction();
try {
    echo "Testing productStore...\n";
    foreach ($mockInvoice['invoice_entries'] as $entry) {
        $controller->productStore($entry['shoe'], $mockInvoice['commission']);
    }
    echo "productStore successful!\n";

    $product = Product::where('code', 'A-TESTSHOE01')->first();
    echo "Product created: ID=" . $product->id . ", Code=" . $product->code . ", Name=" . $product->name . ", Cost=" . $product->cost . ", Price=" . $product->price . "\n";

    echo "Testing invoiceStore...\n";
    $result = $controller->invoiceStore($mockInvoice, $request);
    echo "invoiceStore returned: " . json_encode($result) . "\n";

    $purchase = Purchase::where('reference_no', 'avijatry-99999')->first();
    echo "Purchase created: ID=" . $purchase->id . ", Ref=" . $purchase->reference_no . ", Total Qty=" . $purchase->total_qty . ", Grand Total=" . $purchase->grand_total . "\n";

    $productPurchases = ProductPurchase::where('purchase_id', $purchase->id)->get();
    echo "ProductPurchases count: " . $productPurchases->count() . "\n";
    foreach ($productPurchases as $pp) {
        echo "  PP: Product=" . $pp->product_id . ", Variant=" . $pp->variant_id . ", Qty=" . $pp->qty . ", Recieved=" . $pp->recieved . ", Cost=" . $pp->net_unit_cost . "\n";
    }

    $productWarehouses = Product_Warehouse::where('product_id', $product->id)->get();
    echo "ProductWarehouse count: " . $productWarehouses->count() . "\n";
    foreach ($productWarehouses as $pw) {
        echo "  PW: Product=" . $pw->product_id . ", Variant=" . $pw->variant_id . ", Qty=" . $pw->qty . "\n";
    }

    $variants = ProductVariant::where('product_id', $product->id)->get();
    echo "ProductVariants count: " . $variants->count() . "\n";
    foreach ($variants as $v) {
        echo "  PV: ID=" . $v->id . ", VariantID=" . $v->variant_id . ", ItemCode=" . $v->item_code . ", Qty=" . $v->qty . "\n";
    }

    // Now test re-approving the SAME invoice (updating received quantity) to check if duplicates or wrong math occur!
    echo "\nTesting re-approval / updating the same invoice (e.g. qty received changed to 1 and 2)...\n";
    $reqData['received_quantity']['TESTSHOE01']['40'] = 1;
    $reqData['received_quantity']['TESTSHOE01']['41'] = 2;
    $request2 = new Request($reqData);

    $result2 = $controller->invoiceStore($mockInvoice, $request2);

    $purchase->refresh();
    echo "After re-approval: Purchase Total Qty=" . $purchase->total_qty . " (Expected: 3)\n";

    $product->refresh();
    echo "After re-approval: Product Qty=" . $product->qty . " (Expected: 3)\n";

    $productWarehouses = Product_Warehouse::where('product_id', $product->id)->get();
    echo "After re-approval ProductWarehouse count: " . $productWarehouses->count() . " (Expected: 2)\n";
    foreach ($productWarehouses as $pw) {
        echo "  PW: Product=" . $pw->product_id . ", Variant=" . $pw->variant_id . ", Qty=" . $pw->qty . "\n";
    }

    $variants = ProductVariant::where('product_id', $product->id)->get();
    echo "After re-approval ProductVariants count: " . $variants->count() . " (Expected: 2)\n";
    foreach ($variants as $v) {
        echo "  PV: ID=" . $v->id . ", VariantID=" . $v->variant_id . ", ItemCode=" . $v->item_code . ", Qty=" . $v->qty . "\n";
    }

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
} finally {
    DB::rollBack();
    echo "\nRolled back transaction successfully!\n";
}
