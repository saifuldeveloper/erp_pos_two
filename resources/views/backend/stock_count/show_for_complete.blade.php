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
                            <a href="{{ route('report.stockCount') }}" class="btn btn-primary ml-auto">
                                <i class="fas fa-list"></i>
                                Stock Count
                            </a>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => ['stock-count.update', $lims_stock_count->id],
                                'method' => 'put',
                                'files' => true,
                                'id' => 'stock-count-form',
                            ]) !!}
                            <input type="hidden" name="status" value="add">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="submit-btn">Add</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            @if (count($lims_stock_count->items) > 0)
                <div class="row">
                    <div class="col-md-12">
                        @php
                            $stockMatched = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total == $items[0]->current_quantity;
                            });

                            $overStock = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total > $items[0]->current_quantity;
                            });

                            $underStock = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total < $items[0]->current_quantity;
                            });

                            $stockCounts = [
                                ['title' => 'Stock Matched', 'data' => $stockMatched],
                                ['title' => 'Over Stock', 'data' => $overStock],
                                ['title' => 'Under Stock', 'data' => $underStock],
                            ];
                        @endphp
                        @foreach ($stockCounts as $stockCount)
                            @if ($stockCount['data']->count() > 0)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>{{ $stockCount['title'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover stock-count-table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.name') }}</th>
                                                        <th>{{ trans('file.Code') }}</th>
                                                        <th>Current Quantity</th>
                                                        <th>Quantity Find</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($stockCount['data'] as $items)
                                                        @php
                                                            $item = $items[0];
                                                            $total = $items->sum('updated_quantity');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ @$item->product->name }}</td>
                                                            <td>{{ $item->item_code }}</td>
                                                            <td>{{ $item->current_quantity }}</td>
                                                            <td>
                                                                @foreach ($items as $item)
                                                                    {{ $item->updated_quantity }}
                                                                    @if (!$loop->last)
                                                                        +
                                                                    @endif
                                                                @endforeach
                                                                = {{ $total }}
                                                            </td>
                                                            <td>{{ $stockCount['title'] }}
                                                                @if ($stockCount['title'] != 'Stock Matched')
                                                                    ({{ abs($total - $item->current_quantity) }})
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        {!! Form::open([
                            'route' => ['stock-count.update', $lims_stock_count->id],
                            'method' => 'put',
                            'files' => true,
                            'id' => 'stock-count-form',
                        ]) !!}
                        <input type="hidden" name="status" value="complete">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submit-btn">Complete</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // function productSearch(data) {
        //     $.ajax({
        //         type: 'GET',
        //         url: "{{ route('stock-count.search') }}",
        //         data: {
        //             data: data
        //         },

        //         success: function(datas) {

        //             $("input[name='product_code_name']").val('');

        //             datas.forEach(function(data) {

        //                 if (data.exists) {
        //                     if (!confirm(
        //                             "⚠️ This product already exists in stock count. Do you want to add again?"
        //                             )) {
        //                         return;
        //                     }
        //                 }

        //                 var newRow = $("<tr>");
        //                 var cols = '';

        //                 cols += '<td>' + data.name + '</td>';
        //                 cols += '<td>' + data.code + '</td>';
        //                 cols += '<td>' + data.qty + '</td>';

        //                 cols +=
        //                     '<td><input type="number" class="form-control qty" name="qty[]" value="' +
        //                     data.qty + '" step="any" required/></td>';

        //                 cols +=
        //                     '<td><button type="button" class="ibtnDel btn btn-danger">Delete</button></td>';

        //                 cols +=
        //                     '<input type="hidden" class="product-code" name="product_code[]" value="' +
        //                     data.code + '"/>';
        //                 cols += '<input type="hidden" name="product_id[]" value="' + data.id + '"/>';
        //                 cols += '<input type="hidden" name="current_qty[]" value="' + data.qty + '"/>';

        //                 newRow.append(cols);
        //                 $("table.order-list tbody").prepend(newRow);
        //             });
        //         }
        //     });
        // }

        // function productSearch(data) {
        //     $.ajax({
        //         type: 'GET',
        //         url: "{{ route('stock-count.search') }}",
        //         data: {
        //             data: data
        //         },

        //         success: function(datas) {

        //             $("input[name='product_code_name']").val('');

        //             datas.forEach(function(data) {

        //                 // 🔴 If already exists → show confirmation
        //                 if (data.exists) {

        //                     Swal.fire({
        //                         title: '⚠️ Warning',
        //                         text: "This product already exists in stock count. Do you want to add again?",
        //                         icon: 'warning',
        //                         showCancelButton: true,
        //                         confirmButtonText: 'Yes, add it',
        //                         cancelButtonText: 'No'
        //                     }).then((result) => {

        //                         if (result.isConfirmed) {
        //                             addRow(data);
        //                         }

        //                     });

        //                 } else {
        //                     // 🔵 If not exists → direct add
        //                     addRow(data);
        //                 }

        //             });
        //         }
        //     });
        // }
        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: "{{ route('stock-count.search') }}",
                data: {
                    data: data
                },

                success: function(datas) {

                    $("input[name='product_code_name']").val('');

                    // 🔥 important: process one by one
                    processProducts(0, datas);
                }
            });
        }

        function processProducts(index, datas) {

            if (index >= datas.length) return;

            let data = datas[index];

            if (data.exists) {

                Swal.fire({
                    title: '⚠️ Warning',
                    text: "This product already exists in stock count. Do you want to add again?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add it',
                    cancelButtonText: 'No'
                }).then((result) => {

                    if (result.isConfirmed) {
                        addRow(data);
                    }

                    // 🔥 next product
                    processProducts(index + 1, datas);
                });

            } else {

                addRow(data);

                // 🔥 next product
                processProducts(index + 1, datas);
            }
        }

        function addRow(data) {

            var newRow = $("<tr>");
            var cols = '';

            cols += '<td>' + data.name + '</td>';
            cols += '<td>' + data.code + '</td>';
            cols += '<td>' + data.qty + '</td>';

            cols += '<td><input type="number" class="form-control qty" name="qty[]" value="' + data.qty +
                '" step="any" required/></td>';

            cols += '<td><button type="button" class="ibtnDel btn btn-danger">Delete</button></td>';

            cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data.code + '"/>';
            cols += '<input type="hidden" name="product_id[]" value="' + data.id + '"/>';
            cols += '<input type="hidden" name="current_qty[]" value="' + data.qty + '"/>';

            newRow.append(cols);
            $("table.order-list tbody").prepend(newRow);
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

        $('.stock-count-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans('file.Search') }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            dom: '<"row"lfB>rtip',
        });
    </script>
@endpush
