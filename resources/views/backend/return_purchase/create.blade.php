@extends('backend.layout.main') 
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    {{ session()->get('not_permitted') }}
  </div>
@endif

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Add Return')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                        {!! Form::open(['route' => 'return-purchase.store', 'method' => 'post', 'files' => true, 'class' => 'payment-form']) !!}
                        <input type="hidden" name="purchase_id" value="{{$lims_purchase_data->id}}">

                        <div class="table-responsive mt-3">
                            <table id="myTable" class="table table-hover order-list">
                                <thead>
                                    <tr>
                                        <th>{{trans('file.name')}}</th>
                                        <th>{{trans('file.Code')}}</th>
                                        <th>{{trans('file.Batch No')}}</th>
                                        <th>{{trans('file.Quantity')}}</th>
                                        <th>{{trans('file.Net Unit Cost')}}</th>
                                        <th>{{trans('file.Discount')}}</th>
                                        <th>{{trans('file.Tax')}}</th>
                                        <th>{{trans('file.Subtotal')}}</th>
                                        <th>Choose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lims_product_purchase_data as $key=> $product_purchase)
                                    @php
                                        $product_data = DB::table('products')->find($product_purchase->product_id);

                                        if($product_purchase->variant_id) {
                                            $product_variant_data = \App\Models\ProductVariant::select('id', 'item_code','qty')->FindExactProduct($product_data->id, $product_purchase->variant_id)->first();
                                            $product_variant_id = $product_variant_data->id;
                                            $product_data->code = $product_variant_data->item_code;
                                        } else {
                                            $product_variant_id = null;
                                        }

                                        $product_cost = 0;
                                        if($product_purchase->qty != 0) {
                                            if($product_data->tax_method == 1){
                                                $product_cost = $product_purchase->net_unit_cost + ($product_purchase->discount / $product_purchase->qty);
                                            } elseif ($product_data->tax_method == 2) {
                                                $product_cost = ($product_purchase->total / $product_purchase->qty) + ($product_purchase->discount / $product_purchase->qty);
                                            }
                                        }

                                        $tax = DB::table('taxes')->where('rate',$product_purchase->tax_rate)->first();

                                        if($product_data->type == 'standard'){
                                            $unit = DB::table('units')->select('unit_name')->find($product_data->unit_id);
                                            $unit_name = $unit ? $unit->unit_name : 'n/a';
                                        } else {
                                            $unit_name = 'n/a';
                                        }

                                        $product_batch_data = \App\Models\ProductBatch::select('batch_no')->find($product_purchase->product_batch_id);
                                    @endphp
                                    <tr>
                                        <td>{{$product_data->name}}</td>
                                        <td>{{$product_data->code}}</td>
                                        <td>
                                            <input type="hidden" class="product-batch-id" name="product_batch_id[]" value="{{$product_purchase->product_batch_id ?? ''}}">
                                            {{ $product_batch_data ? $product_batch_data->batch_no : 'N/A' }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="actual_qty[]" class="actual-qty" value="{{ $product_variant_data->qty ?? 0 }}">
                                            <input type="number" class="form-control qty" name="qty[]" value="{{ $product_variant_data->qty ?? 0 }}" required step="any" max="{{ $product_variant_data->qty ?? 0 }}" min="0" />
                                        </td>
                                        <td class="net_unit_cost">{{ number_format((float)$product_purchase->net_unit_cost, $general_setting->decimal, '.', '')}}</td>
                                        <td class="discount">{{ number_format((float)$product_purchase->discount, $general_setting->decimal, '.', '')}}</td>
                                        <td class="tax">{{ number_format((float)$product_purchase->tax, $general_setting->decimal, '.', '')}}</td>
                                        <td class="sub-total">{{ number_format((float)$product_purchase->total, $general_setting->decimal, '.', '')}}</td>
                                        <td><input type="checkbox" class="is-return" name="is_return[{{$key}}]" value="{{$product_data->id}}"></td>

                                        <!-- Hidden inputs -->
                                        <input type="hidden" class="product-code" name="product_code[]" value="{{$product_data->code}}"/>
                                        <input type="hidden" name="product_id[]" class="product-id" value="{{$product_data->id}}"/>
                                        <input type="hidden" class="unit-cost" value="{{ $product_purchase->qty != 0 ? $product_purchase->total/$product_purchase->qty : 0 }}">
                                        <input type="hidden" name="product_variant_id[]" value="{{$product_variant_id}}"/>
                                        <input type="hidden" class="product-cost" name="product_cost[]" value="{{$product_cost}}"/>
                                        <input type="hidden" class="purchase-unit" name="purchase_unit[]" value="{{$unit_name}}"/>
                                        <input type="hidden" class="net_unit_cost" name="net_unit_cost[]" value="{{$product_purchase->net_unit_cost}}" />
                                        <input type="hidden" class="discount-value" name="discount[]" value="{{$product_purchase->discount}}" />
                                        <input type="hidden" class="tax-rate" name="tax_rate[]" value="{{$product_purchase->tax_rate}}"/>
                                        <input type="hidden" class="tax-name" value="{{ $tax ? $tax->name : 'No Tax' }}" />
                                        <input type="hidden" class="tax-method" value="{{$product_data->tax_method}}"/>
                                        <input type="hidden" class="unit-tax-value" value="{{ $product_purchase->qty != 0 ? $product_purchase->tax / $product_purchase->qty : 0 }}" />
                                        <input type="hidden" class="tax-value" name="tax[]" value="{{$product_purchase->tax}}" />
                                        <input type="hidden" class="subtotal-value" name="subtotal[]" value="{{$product_purchase->total}}" />
                                        <input type="hidden" class="imei-number" name="imei_number[]" value="{{$product_purchase->imei_number}}" />
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals and Order Info -->
                        <div class="row">
                            <div class="col-md-2"><input type="hidden" name="total_qty" class="total_qty" value="0" /></div>
                            <div class="col-md-2"><input type="hidden" name="total_discount" class="total_discount" value="0" /></div>
                            <div class="col-md-2"><input type="hidden" name="total_tax" class="total_tax" value="0" /></div>
                            <div class="col-md-2"><input type="hidden" name="total_cost" class="total_cost" value="0" /></div>
                            <div class="col-md-2">
                                <input type="hidden" name="item" class="item" value="0" />
                                <input type="hidden" name="order_tax" class="order_tax" value="0" />
                            </div>
                            <div class="col-md-2"><input type="hidden" name="grand_total" class="grand_total" value="0" /></div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Account')}}</label>
                                    <select class="form-control" name="account_id">
                                        @foreach($lims_account_list as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Order Tax')}}</label>
                                    <select class="form-control" name="order_tax_rate">
                                        <option value="0">No Tax</option>
                                        @foreach($lims_tax_list as $tax)
                                        <option value="{{$tax->rate}}">{{$tax->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('file.Attach Document')}}</label>
                                    <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                    <input type="file" name="document" class="form-control" />
                                    @if($errors->has('extension'))
                                        <span><strong>{{ $errors->first('extension') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Return Note')}}</label>
                                    <textarea rows="5" class="form-control" name="return_note"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('file.Staff Note')}}</label>
                                    <textarea rows="5" class="form-control" name="staff_note"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

    $("ul#return").siblings('a').attr('aria-expanded','true');
    $("ul#return").addClass("show");
    $("ul#return #purchase-return-menu").addClass("active");

    $('[data-toggle="tooltip"]').tooltip();

    function calculateTotal() {
        var total_qty = 0, total_discount = 0, total_tax = 0, total = 0, item = 0;

        $("#myTable tbody tr").each(function(i){
            var row = $(this);
            if(row.find('.is-return').is(":checked")){
                var qty = parseFloat(row.find('.qty').val()) || 0;
                var actual_qty = parseFloat(row.find('.actual-qty').val()) || 0;
                if(qty > actual_qty){ qty = actual_qty; row.find('.qty').val(actual_qty); }

                var unit_cost = parseFloat(row.find('.unit-cost').val()) || 0;
                var discount = parseFloat(row.find('.discount').text()) || 0;
                var tax = parseFloat(row.find('.unit-tax-value').val()) * qty || 0;

                total_qty += qty;
                total_discount += discount;
                total_tax += tax;
                total += unit_cost * qty;

                row.find('.subtotal-value').val(unit_cost * qty);
                row.find('.sub-total').text((unit_cost * qty).toFixed({{$general_setting->decimal}}));
                row.find('.tax-value').val(tax.toFixed({{$general_setting->decimal}}));
                row.find('.tax').text(tax.toFixed({{$general_setting->decimal}}));
                item++;
            }
        });

        $('.total_qty').val(total_qty);
        $('.total_discount').val(total_discount.toFixed({{$general_setting->decimal}}));
        $('.total_tax').val(total_tax.toFixed({{$general_setting->decimal}}));
        $('.total_cost').val(total.toFixed({{$general_setting->decimal}}));
        $('.item').val(item);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var subtotal = parseFloat($('.total_cost').val()) || 0;
        var order_tax_rate = parseFloat($('select[name="order_tax_rate"]').val()) || 0;
        var order_tax = subtotal * (order_tax_rate / 100);
        var grand_total = subtotal + order_tax;

        $('.order_tax').val(order_tax.toFixed({{$general_setting->decimal}}));
        $('.grand_total').val(grand_total.toFixed({{$general_setting->decimal}}));
    }

    $("#myTable").on("change", ".is-return", calculateTotal);
    $("#myTable").on("input", ".qty", calculateTotal);
    $('select[name="order_tax_rate"]').on("change", calculateGrandTotal);

    $('.payment-form').on('submit', function(e){
        var rowCount = $('#myTable tbody tr').length;
        if(rowCount < 1){
            alert("Please insert product to order table!");
            e.preventDefault();
        } else {
            $("#submit-button").prop('disabled', true);
        }
    });

    // Limit qty inputs
    $(document).on('input', '.qty', function(){
        var max = parseFloat($(this).attr('max')) || 0;
        var val = parseFloat($(this).val()) || 0;
        if(val > max){ $(this).val(max); alert("You cannot enter more than " + max); }
        if(val < 0){ $(this).val(0); }
    });

});
</script>
@endpush
