@extends('backend.layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="mt-3 pb-2 border-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="exampleModalLabel" class="modal-title text-center container-fluid">Pos</h3>
                    </div>
                    <div class="col-md-12 text-center">
                        <i style="font-size: 15px;">Purchase Details</i>
                    </div>
                </div>
            </div>
            <div id="purchase-content" class="modal-body">
                <strong>Date: </strong>
                {{ Carbon\Carbon::parse($invoice['created_at'])->format('d-m-Y') }}<br>
                <strong>Reference:</strong>
                {{ 'avijatry-' . $invoice['id'] }}<br>
                <strong>Purchase Status: </strong>
                {{ $invoice['retail_store_status'] }}<br><br>
                <div class="row">
                    <div class="col-md-6">
                        <strong>From:</strong>
                        @php
                            $warehouse = \App\Models\Warehouse::first();
                        @endphp
                        <br>{{ $warehouse->name }}<br>{{ $warehouse->phone }}<br>{{ $warehouse->address }}
                    </div>
                </div>
            </div>
            <br>
            <table class="table table-bordered product-purchase-list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th style="width: 10%">Qty Received</th>
                        <th>Unit Cost</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <form action={{ route('invoice.approve', $invoice['id']) }} method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice['id'] }}">
                    <tbody>
                        @forelse ($invoice['invoice_entries'] as $key => $entry)
                            @if ($purchase)
                                @php
                                    $product = App\Models\Product::where('code', $entry['shoe']['id'])->first();
                                    $productPurchase = $purchase->productPurchases
                                        ->where('product_id', $product->id)
                                        ->first();
                                @endphp
                            @else
                                @php
                                    $productPurchase = null;
                                @endphp
                            @endif
                            <tr>
                                <td><strong>{{ $key + 1 }}</strong></td>
                                <td>{{ $entry['shoe']['id'] }} [{{ $entry['shoe']['id'] }}]</td>
                                <td>{{ $entry['count'] }} Pair</td>
                                <td>
                                    <input type="number" name="received_quantity[{{ $entry['shoe']['id'] }}]"
                                        class="form-control"
                                        value="{{ $productPurchase ? $productPurchase->recieved : $entry['count'] }}"
                                        required min="0" max="{{ $entry['count'] }}">
                                </td>
                                <td>{{ $entry['shoe']['retail_price'] }}</td>
                                <td>0(0%)</td>
                                <td>0</td>
                                <td>{{ $entry['total_price'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="6"><strong>Total:</strong></td>
                            <td>0</td>
                            <td>{{ $invoice['total_amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Order Tax:</strong></td>
                            <td>0(0%)</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Order Discount:</strong></td>
                            <td>{{ $invoice['discount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Shipping Cost:</strong></td>
                            <td>{{ $invoice['transport'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Grand Total:</strong></td>
                            <td>{{ $invoice['total_receivable'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Paid Amount:</strong></td>
                            <td>{{ $invoice['total_receivable'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Due:</strong></td>
                            <td>{{ $invoice['total_receivable'] - $invoice['total_payment'] }}</td>
                        </tr>
                        @if ($invoice['gift_transactions'])
                            <tr class="text-center">
                                <th colspan="8">Gift Details</th>
                            </tr>
                            <tr>
                                <th colspan="6">Gift</th>
                                <th>Qty</th>
                                <th>Qty Received</th>
                            </tr>
                            @foreach ($invoice['gift_transactions'] as $gift_transaction)
                                @php
                                    if ($purchase) {
                                        $gift = \App\Models\GiftReceive::where('purchase_id', $purchase->id)
                                            ->where('gift_transaction_id', $gift_transaction['id'])
                                            ->first();
                                    } else {
                                        $gift = null;
                                    }
                                @endphp
                                <tr>
                                    <td colspan="6">{{ $gift_transaction['gift']['name'] }}</td>
                                    <td>{{ $gift_transaction['count'] }}</td>
                                    <td>
                                        <input type="number" name="gift_quantity_received[{{ $gift_transaction['id'] }}]"
                                            class="form-control" required min="0"
                                            max="{{ $gift_transaction['count'] }}"
                                            value="{{ $gift ? $gift->quantity_received : $gift_transaction['count'] }}">
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <label for="note">Note:</label>
                                <textarea name="note" id="note" class="form-control" rows="2" placeholder="Write note here...">{{ $purchase->note ?? '' }}</textarea>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td colspan="8">
                                @if ($invoice['retail_store_status'] == 'Pending')
                                    <button type="submit" class="btn btn-success">Approve</button>
                                @else
                                    <button type="submit" class="btn btn-success">Update</button>
                                @endif
                                <a href="{{ route('invoices.index') }}" class="btn btn-danger">Back</a>
                            </td>
                        </tr>
                    </tfoot>
                </form>
            </table>
        </div>
    </section>
@endsection
