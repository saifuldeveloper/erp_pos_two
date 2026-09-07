<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Http\Controllers\AvijatryController;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$user = User::first();
Auth::login($user);

// Two shoes in one invoice: Shoe 1 (total 5 pairs), Shoe 2 (total 10 pairs) -> Total should be 15 pairs!
$mockInvoice = [
    'id' => 99999,
    'commission' => 10,
    'total_pairs' => 15,
    'discount' => 50,
    'transport' => 100,
    'total_amount' => 15000,
    'total_receivable' => 13600,
    'total_commission' => 1500,
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
                'category' => ['name' => 'Test Shoe 1', 'parent' => null],
                'color' => ['name' => 'Black'],
                'shoe_to_size' => [
                    [
                        'reference_id' => 99999,
                        'shoe_id' => 888,
                        'type' => 'sale',
                        'quantity' => 5,
                        'size' => ['name' => '40']
                    ]
                ]
            ]
        ],
        [
            'invoice_id' => 99999,
            'count' => 10,
            'shoe' => [
                'id' => 889,
                'code' => 'TESTSHOE02',
                'retail_price' => 1000,
                'category' => ['name' => 'Test Shoe 2', 'parent' => null],
                'color' => ['name' => 'Brown'],
                'shoe_to_size' => [
                    [
                        'reference_id' => 99999,
                        'shoe_id' => 889,
                        'type' => 'sale',
                        'quantity' => 10,
                        'size' => ['name' => '42']
                    ]
                ]
            ]
        ]
    ]
];

$reqData = [
    'invoice_id' => 99999,
    'sent_quantity' => [
        'TESTSHOE01' => ['40' => 5],
        'TESTSHOE02' => ['42' => 10]
    ],
    'received_quantity' => [
        'TESTSHOE01' => ['40' => 5],
        'TESTSHOE02' => ['42' => 10]
    ],
    'retail_price' => [
        'TESTSHOE01' => ['40' => 1000],
        'TESTSHOE02' => ['42' => 1000]
    ],
    'price' => [
        'TESTSHOE01' => ['40' => 5000],
        'TESTSHOE02' => ['42' => 10000]
    ],
    'total_amount' => 15000,
    'grand_total' => 13600,
    'paid_amount' => 13600,
    'note' => 'Test multi shoe'
];

$request = new Request($reqData);
$controller = app(AvijatryController::class);

DB::beginTransaction();
try {
    foreach ($mockInvoice['invoice_entries'] as $entry) {
        $controller->productStore($entry['shoe'], $mockInvoice['commission']);
    }

    $controller->invoiceStore($mockInvoice, $request);

    $purchase = Purchase::where('reference_no', 'avijatry-99999')->first();
    echo "Total pairs in invoice: 15\n";
    echo "Actual Purchase total_qty saved in DB: " . $purchase->total_qty . "\n";

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
} finally {
    DB::rollBack();
}
