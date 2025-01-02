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
                        <th style="width: 10%">Variant</th>
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
                                    $productPurchase = $purchase->productPurchases->where('product_id', $product->id);
                                @endphp
                            @else
                                @php
                                    $productPurchase = null;
                                @endphp
                            @endif
                            <tr id="product-{{ $entry['shoe']['id'] }}">
                                <td><strong>{{ $key + 1 }}</strong></td>
                                <td>{{ $entry['shoe']['id'] }} [{{ $entry['shoe']['id'] }}]</td>
                                <td>{{ $entry['count'] }} Pair</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#variantModal{{ $key }}">
                                        Variant
                                    </button>
                                </td>
                                <td>{{ $entry['shoe']['retail_price'] }}</td>
                                <td>0(0%)</td>
                                <td>0</td>
                                <td>{{ $entry['total_price'] }}</td>
                            </tr>
                            <div class="modal fade" id="variantModal{{ $key }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Variant</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Size</strong>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Qty</strong>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Qty Received</strong>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Price</strong>
                                                </div>
                                            </div>
                                            @foreach ($entry['shoe']['shoe_to_size'] as $shoe_to_size)
                                                @if (
                                                    $shoe_to_size['reference_id'] == $entry['invoice_id'] &&
                                                        $shoe_to_size['type'] == 'sale' &&
                                                        $shoe_to_size['shoe_id'] == $entry['shoe_id']
                                                )
                                                    @php
                                                        $product = App\Models\Product::where(
                                                            'code',
                                                            $entry['shoe']['id'],
                                                        )->first();
                                                        if ($product) {
                                                            $productVariant = App\Models\ProductVariant::where(
                                                                'item_code',
                                                                $shoe_to_size['size']['name'] . '-' . $product->code,
                                                            )->first();
                                                            $proPurchase = $productPurchase
                                                                ->where('variant_id', $productVariant->id)
                                                                ->where('purchase_id', $purchase->id)
                                                                ->first();
                                                        } else {
                                                            $proPurchase = null;
                                                        }
                                                    @endphp
                                                    <div class="row mt-2">
                                                        <div class="col-md-3">
                                                            {{ $shoe_to_size['size']['name'] }}
                                                        </div>
                                                        <div class="col-md-3">
                                                            {{ $shoe_to_size['quantity'] }}
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="hidden"
                                                                name="sent_quantity[{{ $entry['shoe_id'] }}][{{ $shoe_to_size['size']['name'] }}]"
                                                                value="{{ $shoe_to_size['quantity'] }}">
                                                            <input type="number"
                                                                name="received_quantity[{{ $entry['shoe_id'] }}][{{ $shoe_to_size['size']['name'] }}]"
                                                                class="form-control" required min="0"
                                                                max="{{ $shoe_to_size['quantity'] }}"
                                                                value="{{ $proPurchase ? $proPurchase->recieved : $shoe_to_size['quantity'] }}"
                                                                onkeyup="calculateTotal()" onchange="calculateTotal()">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="hidden"
                                                                name="retail_price[{{ $entry['shoe_id'] }}][{{ $shoe_to_size['size']['name'] }}]"
                                                                value="{{ $entry['shoe']['retail_price'] }}">
                                                            <input type="number" readonly
                                                                name="price[{{ $entry['shoe_id'] }}][{{ $shoe_to_size['size']['name'] }}]"
                                                                class="form-control" required min="0"
                                                                value="{{ $proPurchase ? $proPurchase->total : $entry['shoe']['retail_price'] * $shoe_to_size['quantity'] }}">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No Data Found</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="6"><strong>Total:</strong></td>
                            <td>0</td>
                            <td class="total_amount">{{ $invoice['total_amount'] }}</td>
                            <input type="hidden" name="total_amount" value="{{ $invoice['total_amount'] }}">
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Order Tax:</strong></td>
                            <td class="total_tax">(+)0(0%)</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Order Commission:</strong></td>
                            <td class="total_commission">(-){{ $invoice['total_commission'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Order Discount:</strong></td>
                            <td class="total_discount">(-){{ $invoice['discount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Shipping Cost:</strong></td>
                            <td class="total_transport">(+){{ $invoice['transport'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Grand Total:</strong></td>
                            <td class="grand_total">{{ $invoice['total_receivable'] }}</td>
                            <input type="hidden" name="grand_total" value="{{ $invoice['total_receivable'] }}">
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Paid Amount:</strong></td>
                            <td>
                                <input type="number" name="paid_amount" class="form-control" required min="0"
                                    value="{{ $purchase ? $purchase->paid_amount : $invoice['total_receivable'] }}"
                                    onkeyup="dueCalculation()" onchange="dueCalculation()">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7"><strong>Due:</strong></td>
                            <td class="total_due">{{ $invoice['total_receivable'] - $invoice['total_payment'] }}</td>
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
                                        <input type="number"
                                            name="gift_quantity_received[{{ $gift_transaction['id'] }}]"
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
@push('scripts')
    <script>
        $(document).ready(function() {
            subTotalCalculation();
            dueCalculation();
        });

        function calculateTotal() {
            let $input = $(document.activeElement);
            let inputName = $input.attr('name');
            let inputValue = parseFloat($input.val());

            // Prevent negative value and max value
            if (inputValue < 0) {
                $input.val(0);
                inputValue = 0;
            }

            let max = parseFloat($input.attr('max'));
            if (inputValue > max) {
                $input.val(max);
                inputValue = max;
            }

            let shoeId = inputName.match(/\[(\d+)\]/)[1].replace(/\[|\]/g, '');
            let sizeId = inputName.match(/\[(\d+)\]/g)[1].replace(/\[|\]/g, '');


            let $retailPriceInput = $(`input[name="retail_price[${shoeId}][${sizeId}]"]`);
            let retailPriceValue = parseFloat($retailPriceInput.val());
            let totalPrice = inputValue * retailPriceValue;

            let $totalPriceInput = $(`input[name="price[${shoeId}][${sizeId}]"]`);
            $totalPriceInput.val(totalPrice);

            subTotalCalculation();
        }

        function subTotalCalculation() {
            //get all shoe id
            let shoeIds = [];
            $('input[name^="received_quantity"]').each(function() {
                let shoeId = $(this).attr('name').match(/\[(\d+)\]/)[1].replace(/\[|\]/g, '');
                if (!shoeIds.includes(shoeId)) {
                    shoeIds.push(shoeId);
                }
            });

            $.each(shoeIds, function(index, shoeId) {
                let total = 0;
                $(`input[name^="price[${shoeId}]"]`).each(function() {
                    total += parseFloat($(this).val());
                });

                let $totalTd = $(`#product-${shoeId} td:last-child`);
                $totalTd.text(total);
            });

            let subTotal = 0;
            $(`input[name^="price"]`).each(function() {
                subTotal += parseFloat($(this).val());
            });

            $('.total_amount').text(subTotal);
            $('input[name="total_amount"]').val(subTotal);

            let totalCommission = parseFloat($('.total_commission').text().replace('(-)', ''));
            let totalDiscount = parseFloat($('.total_discount').text().replace('(-)', ''));
            let totalTransport = parseFloat($('.total_transport').text().replace('(+)', ''));
            let grandTotal = subTotal + totalTransport - totalCommission - totalDiscount;

            $('.grand_total').text(grandTotal);
            $('input[name="grand_total"]').val(grandTotal);
            var paid_amount = parseFloat("{{ $purchase ? $purchase->paid_amount : 0 }}");
            parseFloat($('input[name="paid_amount"]').val(paid_amount > 0 ? paid_amount : grandTotal));
            $('input[name="paid_amount"]').attr('max', grandTotal);
        }

        function dueCalculation() {
            let grandTotal = parseFloat($('.grand_total').text());
            let paidAmount = parseFloat($('input[name="paid_amount"]').val());
            let due = grandTotal - paidAmount;
            $('.total_due').text(due);
        }
    </script>
@endpush
