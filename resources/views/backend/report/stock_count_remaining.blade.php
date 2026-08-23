@extends('backend.layout.main')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('message') }}
        </div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('not_permitted') }}
        </div>
    @endif

    <style>
        .stat-card {
            background: #ffffff;
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 90px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .stat-card.teal { border-left: 5px solid #0891b2; }
        .stat-card.slate { border-left: 5px solid #4b5563; }
        .stat-card.orange { border-left: 5px solid #f59e0b; }
        .stat-card.green { border-left: 5px solid #22c55e; }
        
        .stat-card .title-small {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 5px;
            white-space: nowrap;
        }
        .stat-card .value-large {
            font-size: 20px;
            font-weight: 700;
        }
        .stat-card.teal .value-large { color: #0891b2; }
        .stat-card.slate .value-large { color: #1f2937; }
        .stat-card.orange .value-large { color: #f59e0b; }
        .stat-card.green .value-large { color: #22c55e; }

        .stat-icon {
            font-size: 28px;
            opacity: 0.8;
        }
        .stat-icon.teal { color: #0891b2; }
        .stat-icon.slate { color: #4b5563; }
        .stat-icon.orange { color: #f59e0b; }
        .stat-icon.green { color: #22c55e; }

        /* Dark mode overrides */
        .dark-mode .stat-card {
            background-color: #283046;
            border: 1px solid #3b4253;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }
        .dark-mode .stat-card .title-small {
            color: #b4b7bd;
        }
        .dark-mode .stat-card.slate .value-large {
            color: #eaeaea;
        }
        .dark-mode .stat-icon.slate {
            color: #b4b7bd;
        }
    </style>

    <section class="forms">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Stock Count Report') }}</h4>
                            <a href="{{ route('report.stockCount') }}" class="btn btn-info ml-auto">
                                <i class="fa fa-list"></i> Stock Count
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <!-- Card 1: Total Items (Teal) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card teal">
                                        <div>
                                            <div class="title-small">{{ trans('file.Total Items') }}</div>
                                            <div class="value-large">{{ $remainingCount }}</div>
                                        </div>
                                        <div class="stat-icon teal">
                                            <i class="fa fa-th-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2: Total Quantity (Slate) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card slate">
                                        <div>
                                            <div class="title-small">{{ trans('file.Total Quantity') }}</div>
                                            <div class="value-large">{{ number_format($remainingQty, 2, '.', '') }}</div>
                                        </div>
                                        <div class="stat-icon slate">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 3: Total Purchase Value (Orange) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card orange">
                                        <div>
                                            <div class="title-small">{{ trans('file.Grand Total Purchase Value') }}</div>
                                            <div class="value-large">{{ number_format($totalRemainingPurchaseValue, 2, '.', '') }}</div>
                                        </div>
                                        <div class="stat-icon orange">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 4: Total Sale Value (Green) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card green">
                                        <div>
                                            <div class="title-small">{{ trans('file.Grand Total Sale Value') }}</div>
                                            <div class="value-large">{{ number_format($totalRemainingSaleValue, 2, '.', '') }}</div>
                                        </div>
                                        <div class="stat-icon green">
                                            <i class="fa fa-tags"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!! Form::open(['route' => 'report.stockCount.remaining', 'method' => 'GET', 'id' => 'filter-form']) !!}
                            <div class="row mb-4 align-items-end">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label class="form-label font-weight-bold"><i class="fa fa-hashtag text-primary"></i> Stock Count Session</label>
                                        <select name="countID" class="form-control selectpicker" data-live-search="true" title="Choose Stock Count...">
                                            <option value="">All / Latest Count</option>
                                            @foreach($lims_stock_count_list as $sc)
                                                <option value="{{ $sc->id }}" {{ $countID == $sc->id ? 'selected' : '' }}>
                                                    #{{ $sc->id }} ({{ date('d-m-Y', strtotime($sc->created_at)) }}) - {{ $sc->warehouse_name ?? 'All Warehouse' }} {{ $sc->is_resolved ? '[Resolved]' : ($sc->is_completed ? '[Completed]' : '[Pending]') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="form-label font-weight-bold">{{ trans('file.Choose Your Date') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="daterangepicker-field form-control"
                                                value="{{ $start_date ? $start_date . ' To ' . $end_date : '' }}" placeholder="Select date range...">
                                            <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                            <input type="hidden" name="end_date" value="{{ $end_date }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="form-label font-weight-bold">Brand</label>
                                        <select name="brand_id" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Brand...">
                                            <option value="0">All Brands</option>
                                            @foreach($lims_brand_list as $brand)
                                                <option value="{{ $brand->id }}" {{ $brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label class="form-label font-weight-bold">Category</label>
                                        <select name="category_id" class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                            <option value="0">All Categories</option>
                                            @foreach($lims_category_list as $category)
                                                <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->parent ? $category->parent->name . ' - ' . $category->name : $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2" style="flex: 1;"><i class="fa fa-filter"></i> {{ trans('file.submit') }}</button>
                                        <a href="{{ route('report.stockCount.remaining') }}" class="btn btn-secondary" style="flex: 1;"><i class="fa fa-undo"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="stock-count-report-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('file.Product') }}</th>
                                            <th>{{ trans('file.item code') }}</th>
                                            <th>{{ trans('file.cost') }}</th>
                                            <th>{{ trans('file.price') }}</th>
                                            <th>{{ trans('file.Current Quantity') }}</th>
                                            <th>{{ trans('file.Total Cost') }}</th>
                                            <th>{{ trans('file.Total Price') }}</th>
                                            <th class="not-export text-center">{{ trans('file.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                            @php
                                                $rowPurchaseVal = $product->qty * $product->cost;
                                                $rowSaleVal = $product->qty * $product->price;
                                            @endphp
                                            <tr data-id="{{ $product->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="view-stock-btn font-weight-bold text-primary" data-id="{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ number_format($product->cost, 2, '.', '') }}</td>
                                                <td>{{ number_format($product->price, 2, '.', '') }}</td>
                                                <td>{{ number_format($product->qty, 2, '.', '') }}</td>
                                                <td>{{ number_format($rowPurchaseVal, 2, '.', '') }}</td>
                                                <td>{{ number_format($rowSaleVal, 2, '.', '') }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-info view-stock-btn" data-id="{{ $product->id }}" title="{{ trans('file.View') }}">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align: right;">Total:</th>
                                            <th>{{ number_format($remainingQty, 2, '.', '') }}</th>
                                            <th>{{ number_format($totalRemainingPurchaseValue, 2, '.', '') }}</th>
                                            <th>{{ number_format($totalRemainingSaleValue, 2, '.', '') }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Stock Details Modal -->
    <div id="product-details" tabindex="-1" role="dialog" aria-labelledby="productDetailsLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="productDetailsLabel" class="modal-title">{{ trans('file.Product Details') }}</h5>
                    <button id="print-stock-btn" type="button" class="btn btn-default btn-sm ml-3">
                        <i class="dripicons-print"></i> {{ trans('file.Print') }}
                    </button>
                    <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true"><i class="dripicons-cross"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="printable-modal-body">
                    <div class="row">
                        <!-- Top: Warehouse Quantity (Full Width) -->
                        <div class="col-md-12" id="product-warehouse-section">
                            <h5>{{ trans('file.Warehouse Quantity') }}</h5>
                            <table class="table table-bordered table-hover product-warehouse-list">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bottom Left: Product Variant Information (col-md-7) -->
                        <div class="col-md-7 mt-3" id="product-variant-section">
                            <h5>{{ trans('file.Product Variant Information') }}</h5>
                            <table class="table table-bordered table-hover product-variant-list">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bottom Right: Warehouse quantity of product variants (col-md-5) -->
                        <div class="col-md-5 mt-3" id="product-variant-warehouse-section">
                            <h5>{{ trans('file.Warehouse quantity of product variants') }}</h5>
                            <table class="table table-bordered table-hover product-variant-warehouse-list">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // Sidebar active menu
        $("ul#report").siblings('a').attr('aria-expanded','true');
        $("ul#report").addClass("show");
        $("ul#report #stock-count-remaining-menu").addClass("active");

        // DataTable Initialization
        $('#stock-count-report-table').DataTable({
            "order": [],
            "pageLength": 10,
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"]
            ],
            'language': {
                'lengthMenu': '_MENU_ {{ trans("file.records per page") }}',
                "info": '<small>{{ trans("file.Showing") }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans("file.Search") }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            dom: '<"row align-items-center mb-2"<"col-md-3"l><"col-md-5"B><"col-md-4"f>><"row"<"col-md-12"tr>><"row mt-2"<"col-md-5"i><"col-md-7"p>>',
            buttons: [
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: ':visible:Not(.not-export)',
                        rows: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-excel"></i> CSV',
                    exportOptions: {
                        columns: ':visible:Not(.not-export)',
                        rows: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    exportOptions: {
                        columns: ':visible:Not(.not-export)',
                        rows: ':visible'
                    }
                }
            ]
        });

        $(".daterangepicker-field").daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $(".daterangepicker-field").on('apply.daterangepicker', function(ev, picker) {
            var start_date = picker.startDate.format('YYYY-MM-DD');
            var end_date = picker.endDate.format('YYYY-MM-DD');
            $(this).val(start_date + ' To ' + end_date);
            $('input[name="start_date"]').val(start_date);
            $('input[name="end_date"]').val(end_date);
        });

        $(".daterangepicker-field").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
        });

        // View Stock Details Handler
        $(document).on("click", ".view-stock-btn", function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var productId = $(this).data('id') || row.data('id');

            $("table.product-warehouse-list thead").empty();
            $("table.product-warehouse-list tbody").empty();
            $("table.product-variant-list thead").empty();
            $("table.product-variant-list tbody").empty();
            $("table.product-variant-warehouse-list thead").empty();
            $("table.product-variant-warehouse-list tbody").empty();

            $("#product-warehouse-section").addClass('d-none');
            $("#product-variant-section").addClass('d-none');
            $("#product-variant-warehouse-section").addClass('d-none');

            // 1. Fetch Variant Information
            $.get('{{ url("products/variant-data") }}/' + productId, function(variantData) {
                if (variantData && variantData.length > 0) {
                    var newHead = $("<thead>");
                    var newBody = $("<tbody>");
                    var newRow = $("<tr>");
                    newRow.append('<th>{{ trans("file.Variant") }}</th><th>{{ trans("file.Item Code") }}</th><th>{{ trans("file.Additional Cost") }}</th><th>{{ trans("file.Additional Price") }}</th><th>{{ trans("file.Qty") }}</th>');
                    newHead.append(newRow);
                    
                    $.each(variantData, function(i, v) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + (v.name || 'N/A') + '</td>';
                        cols += '<td>' + (v.item_code || 'N/A') + '</td>';
                        cols += '<td>' + (v.additional_cost ? v.additional_cost : 0) + '</td>';
                        cols += '<td>' + (v.additional_price ? v.additional_price : 0) + '</td>';
                        cols += '<td>' + (v.qty ? v.qty : 0) + '</td>';
                        newRow.append(cols);
                        newBody.append(newRow);
                    });

                    $("table.product-variant-list").append(newHead).append(newBody);
                    $("#product-variant-section").removeClass('d-none');
                }
            });

            // 2. Fetch Warehouse & Variant Warehouse Quantities
            $.get('{{ url("products/product_warehouse") }}/' + productId, function(data) {
                if (data.product_warehouse && data.product_warehouse[0] && data.product_warehouse[0].length > 0) {
                    var warehouses = data.product_warehouse[0];
                    var quantities = data.product_warehouse[1];
                    var imeiNumbers = data.product_warehouse[4] || [];

                    var newHead = $("<thead>");
                    var newBody = $("<tbody>");
                    var newRow = $("<tr>");
                    newRow.append('<th>{{ trans("file.Warehouse") }}</th><th>{{ trans("file.Quantity") }}</th><th>{{ trans("file.IMEI or Serial Numbers") }}</th>');
                    newHead.append(newRow);

                    $.each(warehouses, function(index) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + warehouses[index] + '</td>';
                        cols += '<td>' + quantities[index] + '</td>';
                        cols += '<td>' + (imeiNumbers[index] || 'N/A') + '</td>';
                        newRow.append(cols);
                        newBody.append(newRow);
                    });

                    $("table.product-warehouse-list").append(newHead).append(newBody);
                    $("#product-warehouse-section").removeClass('d-none');
                }

                if (data.product_variant_warehouse && data.product_variant_warehouse[0] && data.product_variant_warehouse[0].length > 0) {
                    var vWarehouses = data.product_variant_warehouse[0];
                    var vNames = data.product_variant_warehouse[1];
                    var vQuantities = data.product_variant_warehouse[2];

                    var newHead = $("<thead>");
                    var newBody = $("<tbody>");
                    var newRow = $("<tr>");
                    newRow.append('<th>{{ trans("file.Warehouse") }}</th><th>{{ trans("file.Variant") }}</th><th>{{ trans("file.Quantity") }}</th>');
                    newHead.append(newRow);

                    $.each(vWarehouses, function(index) {
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + vWarehouses[index] + '</td>';
                        cols += '<td>' + vNames[index] + '</td>';
                        cols += '<td>' + vQuantities[index] + '</td>';
                        newRow.append(cols);
                        newBody.append(newRow);
                    });

                    $("table.product-variant-warehouse-list").append(newHead).append(newBody);
                    $("#product-variant-warehouse-section").removeClass('d-none');
                }
            });

            $('#product-details').modal('show');
        });

        // Print Stock Details
        $("#print-stock-btn").on("click", function() {
            var divToPrint = document.getElementById('printable-modal-body');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" href="<?php echo asset("vendor/bootstrap/css/bootstrap.min.css"); ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} table { width: 100%; } }</style><body onload="window.print()">' +
                divToPrint.innerHTML + '</body>'
            );
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 10);
        });
    </script>
@endpush
