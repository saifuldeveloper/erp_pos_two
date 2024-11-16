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
                        <th>Unit Cost</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($invoice['invoice_entries'] as $key => $entry)
                        <tr>
                            <td><strong>{{ $key + 1 }}</strong></td>
                            <td>{{ $entry['shoe']['id'] }} [{{ $entry['shoe']['id'] }}]</td>
                            <td>{{ $entry['count'] }} Pair</td>
                            <td>{{ $entry['shoe']['retail_price'] }}</td>
                            <td>0(0%)</td>
                            <td>0</td>
                            <td>{{ $entry['total_price'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Data Found</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="5"><strong>Total:</strong></td>
                        <td>0</td>
                        <td>{{ $invoice['total_amount'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Order Tax:</strong></td>
                        <td>0(0%)</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Order Discount:</strong></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Shipping Cost:</strong></td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Grand Total:</strong></td>
                        <td>{{ $invoice['total_receivable'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Paid Amount:</strong></td>
                        <td>{{ $invoice['total_receivable'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="6"><strong>Due:</strong></td>
                        <td>{{ $invoice['total_receivable'] - $invoice['total_payment'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
@endsection
