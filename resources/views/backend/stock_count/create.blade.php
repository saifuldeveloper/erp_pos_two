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
                            <h4>{{ trans('file.Count Stock') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open([
                                'route' => 'stock-count.store',
                                'method' => 'post',
                                'files' => true,
                                'id' => 'stock-count-form',
                            ]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('file.Date') }}</label>
                                                <input type="text" name="created_at" class="form-control date"
                                                    value="{{ date('d-m-Y') }}" placeholder="Choose date" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('file.Warehouse') }} *</label>
                                                <select required name="warehouse_id" class="selectpicker form-control"
                                                    data-live-search="true" title="Select warehouse...">
                                                    @foreach ($lims_warehouse_list as $warehouse)
                                                        <option value="{{ $warehouse->id }}"
                                                            {{ $warehouse->is_default ? 'selected' : '' }}>
                                                            {{ $warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Attach Document') }}</label> <i
                                                    class="dripicons-question" data-toggle="tooltip"
                                                    title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                <input type="file" name="document" class="form-control">
                                                @if ($errors->has('extension'))
                                                    <span>
                                                        <strong>{{ $errors->first('extension') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div> --}}
                                        <div class="col-md-12 mt-3">
                                            <label>{{ trans('file.Select Product') }}</label>
                                            <div class="search-box input-group">
                                                <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                                <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                                    placeholder="Please type product code and select..."
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5>Product Table</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            <th>Current Quantity</th>
                                                            <th>{{ trans('file.Quantity') }}</th>
                                                            <th><i class="dripicons-trash"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('file.Note') }}</label>
                                                <textarea rows="5" class="form-control" name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"
                                            id="submit-btn">{{ trans('file.submit') }}</button>
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
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");

        // array data depend on warehouse
        var product_code = [];
        var product_name = [];
        var product_qty = [];

        // array data with selection
        var rowindex;
        $('.selectpicker').selectpicker('refresh');


        $('[data-toggle="tooltip"]').tooltip();

        <?php $productArray = []; ?>
        var lims_product_code = [
            @foreach ($lims_product_list as $product)
                <?php
                $productArray[] = htmlspecialchars($product->code) . '|' . preg_replace('/[\n\r]/', '<br>', htmlspecialchars($product->name));
                ?>
            @endforeach
            <?php
            echo '"' . implode('","', $productArray) . '"';
            ?>
        ];

        var lims_productcodeSearch = $('#lims_productcodeSearch');

        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_code, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                };
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });

        //Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            $(this).closest("tr").remove();
            calculateTotal();
        });

        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: "{{ route('stock-count.search') }}",
                data: {
                    data: data
                },
                success: function(datas) {
                    var flag = 1;
                    var product_code = [];
                    $(".product-code").each(function(i) {
                        product_code.push($(this).val());
                    });
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        datas.forEach(function(data) {
                            var newRow = $("<tr>");
                            var cols = '';
                            cols += '<td>' + data[0] +
                                '</td>';
                            cols += '<td>' + data[1] + '</td>';
                            cols += '<td>' + data[2] + '</td>';
                            cols +=
                                '<td><input type="number" class="form-control qty" name="qty[]" value="0" step="any" required/></td>';
                            cols +=
                                '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                            cols +=
                                '<input type="hidden" class="product-code" name="product_code[]" value="' +
                                data[1] + '"/>';
                            cols +=
                                '<input type="hidden" class="current-qty" name="current_qty[]" value="' +
                                data[2] + '"/>';
                            cols +=
                                '<input type="hidden" class="product-id" name="product_id[]" value="' +
                                data[3] + '"/>';
                            newRow.append(cols);
                            $("table.order-list tbody").prepend(newRow);
                            rowindex = newRow.index();
                        });
                    }
                }
            });
        }

        $(window).keydown(function(e) {
            if (e.which == 13) {
                var $targ = $(e.target);
                if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                    var focusNext = false;
                    $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                        if (this === e.target) {
                            focusNext = true;
                        } else if (focusNext) {
                            $(this).focus();
                            return false;
                        }
                    });
                    return false;
                }
            }
        });

        $('#stock-count-form').on('submit', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
                e.preventDefault();
            } else {
                $("#submit-btn").prop('disabled', true);
            }
        });
    </script>
@endpush
