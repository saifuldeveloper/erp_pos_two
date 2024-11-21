@extends('backend.layout.main')
@section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Edit Waste') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::model($waste, ['route' => ['waste.update', $waste->id], 'method' => 'PUT', 'id' => 'waste-form']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('file.Receiver Type') }} *</label>
                                                <select name="receiver_type" id="receiver_type"
                                                    class="selectpicker form-control">
                                                    <option selected disabled value="">{{ trans('file.Select One') }}
                                                    </option>
                                                    <option value="supplier"
                                                        {{ $waste->receiver_type == 'supplier' ? 'selected' : '' }}>
                                                        {{ trans('file.Supplier') }}</option>
                                                    <option value="customer"
                                                        {{ $waste->receiver_type == 'customer' ? 'selected' : '' }}>
                                                        {{ trans('file.customer') }}</option>
                                                    <option value="biller"
                                                        {{ $waste->receiver_type == 'biller' ? 'selected' : '' }}>
                                                        {{ trans('file.Biller') }}</option>
                                                    <option value="employee"
                                                        {{ $waste->receiver_type == 'employee' ? 'selected' : '' }}>
                                                        {{ trans('file.Employee') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" id="receiverList">
                                                <label>{{ trans('file.Receiver') }} *</label>
                                                <select name="receiver_id" id="receiver_id"
                                                    class="selectpicker form-control" data-live-search="true"
                                                    data-live-search-style="begins" title="Select receiver...">
                                                    @foreach ($receivers as $receiver)
                                                        <option value="{{ $receiver->id }}-{{ $receiver->name }}"
                                                            {{ $waste->receiver_id == $receiver->id ? 'selected' : '' }}>
                                                            {{ $receiver->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('file.Note') }}</label>
                                                <input type="text" name="note" class="form-control"
                                                    value="{{ $waste->note }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label>{{ trans('file.Select Product') }}</label>
                                            <div class="search-box input-group">
                                                <button type="button" class="btn btn-secondary btn-lg"><i
                                                        class="fa fa-barcode"></i></button>
                                                <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                                    placeholder="Please type product code and select..."
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <h5>{{ trans('file.Order Table') }} *</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            <th>{{ trans('file.Quantity') }}</th>
                                                            <th>{{ trans('file.Net Unit Price') }}</th>
                                                            <th>{{ trans('file.Subtotal') }}</th>
                                                            <th><i class="dripicons-trash"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($waste->items as $item)
                                                            <tr>
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ $item->product->code }}</td>
                                                                <td><input type="number" class="form-control qty"
                                                                        name="product[{{ $loop->index }}][qty]"
                                                                        min="1" value="{{ $item->qty }}"
                                                                        required /></td>
                                                                <td class="unit_price">{{ $item->product->price }}</td>
                                                                <td class="sub-total">
                                                                    {{ $item->qty * $item->product->price }}</td>
                                                                <td><button type="button"
                                                                        class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button>
                                                                </td>
                                                                <input type="hidden" class="product-code"
                                                                    name="product[{{ $loop->index }}][code]"
                                                                    value="{{ $item->product->code }}" />
                                                                <input type="hidden" class="product-id"
                                                                    name="product[{{ $loop->index }}][product_id]"
                                                                    value="{{ $item->product->id }}" />
                                                                <input type="hidden" class="unit_price"
                                                                    name="product[{{ $loop->index }}][unit_price]"
                                                                    value="{{ $item->product->price }}" />
                                                                <input type="hidden" class="subtotal-value"
                                                                    name="product[{{ $loop->index }}][subtotal]"
                                                                    value="{{ $item->qty * $item->product->price }}" />
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="tfoot active">
                                                        <th colspan="2">{{ trans('file.Total') }}</th>
                                                        <th id="total-qty">{{ $waste->items->sum('qty') }}</th>
                                                        <th></th>
                                                        <input type="hidden" name="total"
                                                            value="{{ $waste->total_price }}">
                                                        <th id="total">
                                                            {{ number_format($waste->total_price, $general_setting->decimal, '.', '') }}
                                                        </th>
                                                        <th><i class="dripicons-trash"></i></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                                            id="submit-button">
                                    </div>
                                </div>
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
    <script type="text/javascript">
        $("ul#waste").siblings('a').attr('aria-expanded', 'true');
        $("ul#waste").addClass("show");
        $("ul#waste #waste-list-menu").addClass("active");
        $('#receiver_type').on('change', function() {
            var type = $(this).val();
            $.get('{{ route('waste.getReceiverList', ':type') }}'.replace(':type', type), function(data) {
                $('#receiverList').empty().html(data);
                $('.selectpicker').selectpicker('refresh');
            });
        });

        $('#lims_productcodeSearch').on('input', function() {
            var receiver_type = $('#receiver_type').val();
            var receiver_id = $('#receiver_id').val();
            temp_data = $('#lims_productcodeSearch').val();
            if (!receiver_type) {
                $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                alert('Please select Receiver Type!');
            } else if (!receiver_id) {
                $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                alert('Please select Receiver!');
            }

        });

        var data = @json($products);
        var lims_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        product_type = data[3];
        product_id = data[4];
        product_list = data[5];
        qty_list = data[6];
        product_warehouse_price = data[7];
        batch_no = data[8];
        product_batch_id = data[9];
        expired_date = data[10];
        is_embeded = data[11];
        $.each(product_code, function(index) {
            if (is_embeded[index])
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')|' + is_embeded[
                    index]);
            else
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });

        var lims_productcodeSearch = $('#lims_productcodeSearch');
        var index = {{ $waste->items->count() }};

        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_array, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                } else if (ui.content.length == 0 && $('#lims_productcodeSearch').val().length == 13) {
                    productSearch($('#lims_productcodeSearch').val() + '|' + 1);
                }
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });

        function productSearch(data) {
            var product_info = data.split(" ");
            var code = product_info[0];
            var pre_qty = 0;
            $(".product-code").each(function(i) {
                if ($(this).val() == code) {
                    rowindex = i;
                    pre_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val();
                }
            });
            data += '?' + $('#customer_id').val() + '?' + (parseFloat(pre_qty) + 1);
            $.ajax({
                type: 'GET',
                url: '{{ route('product_sale.search') }}',
                data: {
                    data: data
                },
                success: function(data) {
                    var flag = 1;
                    if (pre_qty > 0) {
                        var qty = data[15];
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                        var unit_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) +
                                ') .unit_price')
                            .text();
                        var sub_total = qty * unit_price;
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .sub-total').text(
                            sub_total.toFixed(2));
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .subtotal-value').val(
                            sub_total.toFixed(2));
                        var total_qty = 0;
                        var total = 0;
                        $(".qty").each(function() {
                            total_qty += parseFloat($(this).val());
                        });
                        $("#total-qty").text(total_qty);
                        $(".subtotal-value").each(function() {
                            total += parseFloat($(this).val());
                        });
                        $("#total").text(total.toFixed(2));
                        $('input[name="total"]').val(total.toFixed(2));
                        pos = product_code.indexOf(data[1]);
                        flag = 0;
                    }
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        var newRow = $("<tr>");
                        var cols = '';
                        pos = product_code.indexOf(data[1]);
                        temp_unit_name = (data[6]).split(',');
                        cols += '<td>' + data[0] + '</td>';
                        cols += '<td>' + data[1] + '</td>';
                        cols +=
                            '<td><input type="number" class="form-control qty" name="product[' + index +
                            '][qty]" min="1" value="' +
                            data[
                                15] + '" required/></td>';

                        cols += '<td class="unit_price">' + data[2] + '</td>';
                        cols += '<td class="sub-total">' + data[2] + '</td>';
                        cols +=
                            '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                        cols +=
                            '<input type="hidden" class="product-code" name="product[' + index +
                            '][code]" value="' +
                            data[1] + '"/>';
                        cols +=
                            '<input type="hidden" class="product-id" name="product[' + index +
                            '][product_id]" value="' +
                            data[
                                9] + '"/>';
                        cols +=
                            '<input type="hidden" class="unit_price" name="product[' + index +
                            '][unit_price]" value="' +
                            data[2] + '"/>';
                        cols +=
                            '<input type="hidden" class="subtotal-value" name="product[' + index +
                            '][subtotal]" value="' +
                            data[2] + '"/>';

                        newRow.append(cols);
                        $("table.order-list tbody").prepend(newRow);
                        rowindex = newRow.index();
                        if (data[13]) {
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                                '.edit-product').click();
                        }

                        var total_qty = 0;
                        var total = 0;
                        $(".qty").each(function() {
                            total_qty += parseFloat($(this).val());
                        });
                        $("#total-qty").text(total_qty);
                        $(".subtotal-value").each(function() {
                            total += parseFloat($(this).val());
                        });
                        $("#total").text(total.toFixed(2));
                        $('input[name="total"]').val(total.toFixed(2));
                        index++;

                    }
                }
            });
        }

        //quantity change
        $(document).on('change keyup', '.qty', function() {
            var qty = $(this).val();
            var unit_price = $(this).closest('tr').find('.unit_price').text();
            var sub_total = qty * unit_price;
            $(this).closest('tr').find('.sub-total').text(sub_total.toFixed(2));
            $(this).closest('tr').find('.subtotal-value').val(sub_total.toFixed(2));
            var total_qty = 0;
            var total = 0;
            $(".qty").each(function() {
                total_qty += parseFloat($(this).val());
            });
            $("#total-qty").text(total_qty);
            $(".subtotal-value").each(function() {
                total += parseFloat($(this).val());
            });
            $("#total").text(total.toFixed(2));
            $('input[name="total"]').val(total.toFixed(2));
        });

        //delete row
        $(document).on('click', '.ibtnDel', function() {
            var row = $(this).closest('tr');
            row.remove();
            var total_qty = 0;
            var total = 0;
            $(".qty").each(function() {
                total_qty += parseFloat($(this).val());
            });
            $("#total-qty").text(total_qty);
            $(".subtotal-value").each(function() {
                total += parseFloat($(this).val());
            });
            $("#total").text(total.toFixed(2));
            $('input[name="total"]').val(total.toFixed(2));
        });
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endpush
