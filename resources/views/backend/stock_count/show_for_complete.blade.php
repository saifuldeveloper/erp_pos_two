@extends('backend.layout.main')

@section('content')
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
            padding: 15px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 100px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .stat-card.teal { border-left: 5px solid #0891b2; }
        .stat-card.slate { border-left: 5px solid #4b5563; }
        .stat-card.red { border-left: 5px solid #dc3545; }
        .stat-card.orange { border-left: 5px solid #f59e0b; }
        .stat-card.green { border-left: 5px solid #22c55e; }
        .stat-card.indigo { border-left: 5px solid #6366f1; }

        .stat-card .title-small {
            font-size: 11px;
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
        .stat-card.red .value-large { color: #dc3545; }
        .stat-card.orange .value-large { color: #f59e0b; }
        .stat-card.green .value-large { color: #22c55e; }
        .stat-card.indigo .value-large { color: #6366f1; }

        .stat-icon-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .stat-icon-circle.red { background-color: #fde8e8; color: #dc3545; }
        .stat-icon-circle.orange { background-color: #fef3c7; color: #f59e0b; }
        .stat-icon-circle.green { background-color: #dcfce7; color: #22c55e; }
        .stat-icon-circle.indigo { background-color: #e0e7ff; color: #6366f1; }

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
        .dark-mode .stat-icon-circle.red {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }
        .dark-mode .stat-icon-circle.orange {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }
        .dark-mode .stat-icon-circle.green {
            background-color: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }
        .dark-mode .stat-icon-circle.indigo {
            background-color: rgba(99, 102, 241, 0.2);
            color: #6366f1;
        }
        .dark-mode .stat-card [style*="color: #4b5563"] {
            color: #eaeaea !important;
        }
    </style>

    <section class="forms">
        <div class="container-fluid">
            <!-- Stat Widget Bar -->
            <div class="row">
                <!-- Card 1: Total Counted (Teal) -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card teal">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Total Checked ID') }}</div>
                                <div class="value-large">{{ $totalCountedProducts }}</div>
                            </div>
                            <div>
                                <div class="title-small">{{ trans('file.Total Checked Pairs') }}</div>
                                <div class="value-large">{{ number_format($totalCountedQty, 2, '.', '') }}</div>
                            </div>
                            <div style="font-size: 28px; color: #0891b2; opacity: 0.8;">
                                <i class="fa fa-barcode"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2: Remaining (Slate) -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('stock-count.remaining-products', $lims_stock_count->id) }}" class="d-block" style="text-decoration: none; color: inherit;">
                        <div class="stat-card slate" style="cursor: pointer;">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="title-small"><i class="fa fa-list" style="color: #3b82f6; margin-right: 5px;"></i> {{ trans('file.Remaining ID') }}</div>
                                    <div class="value-large">{{ $remainingCount }}</div>
                                </div>
                                <div>
                                    <div class="title-small" style="color: #3b82f6;">{{ trans('file.Remaining Pairs') }}</div>
                                    <div class="value-large">{{ number_format($remainingQty, 2, '.', '') }}</div>
                                </div>
                                <div style="font-size: 28px; color: #4b5563; opacity: 0.8;">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Card 3: Sold Products (Indigo) -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('stock-count.sold-products', $lims_stock_count->id) }}" class="d-block" style="text-decoration: none; color: inherit;">
                        <div class="stat-card indigo" style="cursor: pointer;">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="title-small"><i class="fa fa-shopping-bag" style="color: #6366f1; margin-right: 5px;"></i> {{ trans('file.Sold Products') }}</div>
                                    <div class="value-large">{{ $soldCount }}</div>
                                </div>
                                <div>
                                    <div class="title-small" style="color: #6366f1;">{{ trans('file.Sold Pairs') }}</div>
                                    <div class="value-large">{{ number_format($soldQty, 2, '.', '') }}</div>
                                </div>
                                <div style="font-size: 28px; color: #6366f1; opacity: 0.8;">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Card 4: Waste Products (Red) -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('stock-count.waste-products', $lims_stock_count->id) }}" class="d-block" style="text-decoration: none; color: inherit;">
                        <div class="stat-card red" style="cursor: pointer;">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="title-small"><i class="fa fa-trash" style="color: #dc3545; margin-right: 5px;"></i> {{ trans('file.Waste Products') }}</div>
                                    <div class="value-large">{{ $wasteCount }}</div>
                                </div>
                                <div>
                                    <div class="title-small" style="color: #dc3545;">{{ trans('file.Waste Pairs') }}</div>
                                    <div class="value-large">{{ number_format($wasteQty, 2, '.', '') }}</div>
                                </div>
                                <div style="font-size: 28px; color: #dc3545; opacity: 0.8;">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Card 4: Stock Matched (Green) -->
                <div class="col-md-4 col-sm-6">
                    <div class="stat-card green">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Stock Matched') }}</div>
                                <div class="value-large">{{ number_format($matchedCountQty, 2, '.', '') }}</div>
                            </div>
                            <div class="stat-icon-circle green">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 5: Over Stock (Red) -->
                <div class="col-md-4 col-sm-6">
                    <div class="stat-card red">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Over Match') }}</div>
                                <div class="value-large">{{ number_format($overCountQty, 2, '.', '') }}</div>
                            </div>
                            <div>
                                <div class="title-small">{{ trans('file.Pairs Found') }}</div>
                                <div class="value-large">{{ number_format($overFindQty, 2, '.', '') }}</div>
                            </div>
                            <div class="stat-icon-circle red">
                                <i class="fa fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 6: Under Stock (Orange) -->
                <div class="col-md-4 col-sm-6">
                    <div class="stat-card orange">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Under Stock') }}</div>
                                <div class="value-large">{{ number_format($underCountQty, 2, '.', '') }}</div>
                            </div>
                            <div>
                                <div class="title-small">{{ trans('file.Pairs Found') }}</div>
                                <div class="value-large">{{ number_format($underFindQty, 2, '.', '') }}</div>
                            </div>
                            <div class="stat-icon-circle orange">
                                <i class="fa fa-arrow-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Count Stock') }} #{{ $lims_stock_count->id }} - <span class="text-primary">{{ $lims_stock_count->warehouse->name ?? trans('file.All Warehouse') }}</span></h4>
                            <a href="{{ route('report.overview', ['stock_count_id' => $lims_stock_count->id]) }}" class="btn btn-info ml-auto mr-2">
                                <i class="fa fa-pie-chart"></i> Overview Report
                            </a>
                            <a href="{{ route('report.stockCount') }}" class="btn btn-primary">
                                <i class="fa fa-list"></i> Stock Count
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
                                                <button class="btn btn-secondary" type="button">
                                                    <i class="fa fa-barcode"></i>
                                                </button>
                                                <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                                    placeholder="Please type product code and select..."
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5>{{ trans('file.Product Table') }}</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            @if (!$lims_stock_count->warehouse_id)
                                                                @foreach ($lims_warehouse_list as $wh)
                                                                    <th class="text-center" style="background-color: #f1f5f9; border-left: 2px solid #cbd5e1;">
                                                                        <span class="badge badge-primary" style="font-size: 13px;">{{ $wh->name }}</span>
                                                                        <div style="font-size: 11px; color: #64748b; font-weight: normal; margin-top: 2px;">(Current / Counted)</div>
                                                                    </th>
                                                                @endforeach
                                                                <th class="text-center" style="width: 100px;">{{ trans('file.Total') }}</th>
                                                            @else
                                                                <th>{{ trans('file.Current Quantity') }}</th>
                                                                <th>{{ trans('file.Quantity') }}</th>
                                                            @endif
                                                            <th><i class="dripicons-trash"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- Dynamically populated via JS --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" id="submit-btn">{{ trans('file.add') }}</button>
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
                                                <h5>{{ trans('file.' . $stockCount['title']) }}</h5>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover stock-count-table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.name') }}</th>
                                                        <th>{{ trans('file.Code') }}</th>
                                                        <th>{{ trans('file.Current Quantity') }}</th>
                                                        <th>{{ trans('file.Quantity Find') }}</th>
                                                        <th>{{ trans('file.Remarks') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_current_qty = 0;
                                                        $total_find_qty = 0;
                                                        $total_diff = 0;
                                                    @endphp
                                                    @foreach ($stockCount['data'] as $items)
                                                        @php
                                                            $item = $items[0];
                                                            $total_current = $items->groupBy('warehouse_id')->map(function($whItems) {
                                                                return floatval($whItems->first()->current_quantity);
                                                            })->sum();
                                                            $total = $items->sum('updated_quantity');
                                                            $total_current_qty += $total_current;
                                                            $total_find_qty += $total;
                                                            $total_diff += abs($total - $total_current);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ @$item->product->name }}</td>
                                                            <td><span class="badge badge-light border">{{ $item->item_code }}</span></td>
                                                            <td>{{ $total_current }}</td>
                                                            <td>
                                                                @if (!$lims_stock_count->warehouse_id)
                                                                    @foreach ($items->groupBy('warehouse_id') as $whId => $whItems)
                                                                        @php
                                                                            $whName = $whItems->first()->warehouse->name ?? 'WH';
                                                                            $whCounted = $whItems->sum('updated_quantity');
                                                                        @endphp
                                                                        <span class="badge badge-light border mr-1" title="{{ $whName }}">
                                                                            {{ $whName }}: <strong>{{ $whCounted }}</strong>
                                                                        </span>
                                                                    @endforeach
                                                                    <span class="font-weight-bold text-primary">= {{ $total }}</span>
                                                                @else
                                                                    @foreach ($items as $sci)
                                                                        {{ $sci->updated_quantity }}
                                                                        @if (!$loop->last)
                                                                            +
                                                                        @endif
                                                                    @endforeach
                                                                    = {{ $total }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ trans('file.' . $stockCount['title']) }}
                                                                @if ($stockCount['title'] != 'Stock Matched')
                                                                    ({{ abs($total - $total_current) }})
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>{{ trans('file.Total') }}:</th>
                                                        <th></th>
                                                        <th>{{ $total_current_qty }}</th>
                                                        <th>{{ $total_find_qty }}</th>
                                                        <th>
                                                            @if ($stockCount['title'] != 'Stock Matched')
                                                                {{ $total_diff }}
                                                            @else
                                                                0
                                                            @endif
                                                        </th>
                                                    </tr>
                                                </tfoot>
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
                            'id' => 'complete-form',
                        ]) !!}
                        <input type="hidden" name="status" value="complete">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="complete-btn">{{ trans('file.Complete') }}</button>
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

        // Array data depending on warehouse
        var product_code = [];
        var product_name = [];
        var product_qty = [];

        // Array data with selection
        var rowindex;
        $('.selectpicker').selectpicker('refresh');
        $('[data-toggle="tooltip"]').tooltip();

        var isMultiWarehouse = {{ (!$lims_stock_count->warehouse_id) ? 'true' : 'false' }};
        var rowCounter = 0;
        var lims_productcodeSearch = $('#lims_productcodeSearch');

        lims_productcodeSearch.autocomplete({
            delay: 0,
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('stock-count.autocomplete') }}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            response: function(event, ui) {
                if ($('#lims_productcodeSearch').val().trim() === '') {
                    return;
                }
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                }
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });

        lims_productcodeSearch.on('keydown', function(e) {
            if (e.which == 13) {
                var autocompleteInstance = $(this).autocomplete('instance');
                var isMenuVisible = autocompleteInstance && autocompleteInstance.menu && autocompleteInstance.menu.element.is(':visible');
                var hasSelectedItem = isMenuVisible && autocompleteInstance.menu.active;

                if (!hasSelectedItem) {
                    e.preventDefault();
                    e.stopPropagation();
                    var code = $(this).val().trim();
                    if (code.length > 0) {
                        $(this).autocomplete("close");
                        productSearch(code);
                    }
                }
            }
        });

        // Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            $(this).closest("tr").remove();
            if (typeof calculateTotal === "function") calculateTotal();
        });

        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: "{{ route('stock-count.search') }}",
                data: {
                    data: data,
                    stock_count_id: "{{ $lims_stock_count->id }}"
                },
                success: function(datas) {
                    $("input[name='product_code_name']").val('');

                    if (datas.length === 0) return;

                    // Check if any item already exists in stock count
                    let hasExistingProduct = datas.some(item => item.exists);

                    if (hasExistingProduct) {
                        Swal.fire({
                            title: '⚠️ Warning',
                            text: "This product (or some of its variants) already exists in stock count. Do you want to add them anyway?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                datas.forEach(function(item) {
                                    addRow(item);
                                });
                            }
                        });
                    } else {
                        datas.forEach(function(item) {
                            addRow(item);
                        });
                    }
                }
            });
        }

        function addRow(data) {
            rowCounter++;
            var rowUid = 'row_' + Date.now() + '_' + rowCounter;

            if (isMultiWarehouse && data.warehouses && data.warehouses.length > 0) {
                var whColumns = '';
                var totalInitialQty = 0;

                data.warehouses.forEach(function(wh, idx) {
                    var whQty = parseFloat(wh.qty) || 0;
                    totalInitialQty += whQty;
                    whColumns += `
                        <td style="border-left: 2px solid #cbd5e1; vertical-align: middle; background-color: #f8fafc;">
                            <div class="d-flex align-items-center justify-content-center" style="gap: 8px;">
                                <span class="badge badge-secondary" style="font-size: 13px; min-width: 28px;" title="Current Stock in ${wh.warehouse_name}">${wh.qty}</span>
                                <input type="number" 
                                    class="form-control form-control-sm wh-qty-input ${rowUid}-wh-qty" 
                                    name="items[${rowUid}_${wh.warehouse_id}][qty]" 
                                    value="${wh.qty}" 
                                    min="0" 
                                    step="any" 
                                    required 
                                    style="width: 80px; text-align: center; font-weight: bold;"
                                    data-row="${rowUid}"
                                />
                                <input type="hidden" name="items[${rowUid}_${wh.warehouse_id}][warehouse_id]" value="${wh.warehouse_id}"/>
                                <input type="hidden" name="items[${rowUid}_${wh.warehouse_id}][current_qty]" value="${wh.qty}"/>
                                <input type="hidden" name="items[${rowUid}_${wh.warehouse_id}][product_id]" value="${data.id}"/>
                                <input type="hidden" name="items[${rowUid}_${wh.warehouse_id}][code]" value="${data.code}"/>
                            </div>
                        </td>
                    `;
                });

                var newRow = `<tr id="${rowUid}">
                    <td style="vertical-align: middle;"><strong>${data.name}</strong></td>
                    <td style="vertical-align: middle;"><span class="badge badge-light border" style="font-size: 13px;">${data.code}</span></td>
                    ${whColumns}
                    <td class="text-center font-weight-bold ${rowUid}-total-qty" style="vertical-align: middle; font-size: 15px; color: #0284c7;">
                        ${totalInitialQty}
                    </td>
                    <td style="vertical-align: middle;"><button type="button" class="ibtnDel btn btn-sm btn-danger"><i class="dripicons-trash"></i></button></td>
                </tr>`;

                $("table.order-list tbody").prepend(newRow);
            } else {
                var newRow = `<tr>
                    <td style="vertical-align: middle;"><strong>${data.name}</strong></td>
                    <td style="vertical-align: middle;"><span class="badge badge-light border" style="font-size: 13px;">${data.code}</span></td>
                    <td style="vertical-align: middle;">${data.qty}</td>
                    <td style="vertical-align: middle;"><input type="number" class="form-control qty" name="qty[]" value="${data.qty}" step="any" required/></td>
                    <td style="vertical-align: middle;"><button type="button" class="ibtnDel btn btn-sm btn-danger"><i class="dripicons-trash"></i></button></td>
                    <input type="hidden" class="product-code" name="product_code[]" value="${data.code}"/>
                    <input type="hidden" name="product_id[]" value="${data.id}"/>
                    <input type="hidden" name="current_qty[]" value="${data.qty}"/>
                </tr>`;

                $("table.order-list tbody").prepend(newRow);
            }
        }

        $(document).on('input', '.wh-qty-input', function() {
            var rowUid = $(this).data('row');
            var total = 0;
            $('.' + rowUid + '-wh-qty').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('.' + rowUid + '-total-qty').text(total);
        });

        // Enter key navigation configuration
        $(window).keydown(function(e) {
            if (e.which == 13) {
                var $targ = $(e.target);
                if (!$targ.is("textarea") && !$targ.is("#lims_productcodeSearch") && !$targ.is(":button,:submit")) {
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

        // Form submit validation
        $('#stock-count-form').on('submit', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!");
                e.preventDefault();
            } else {
                $("#submit-btn").prop('disabled', true);
            }
        });

        $('#complete-btn').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '⚠️ Are you sure?',
                text: "Do you want to mark this stock count as completed? Once completed, you will be taken to the resolve page.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Complete it!',
                cancelButtonText: 'No, Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#complete-form').submit();
                }
            });
        });

        // Initialize DataTable
        $('.stock-count-table').DataTable({
            "order": [],
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
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
