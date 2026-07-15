@extends('backend.layout.main')
@section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

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

        $matchedCountQty = 0;
        foreach($stockMatched as $items) {
            $matchedCountQty += $items->sum('updated_quantity');
        }

        $overCountQty = 0;
        foreach($overStock as $items) {
            $overCountQty += $items->sum('updated_quantity');
        }

        $underCountQty = 0;
        foreach($underStock as $items) {
            $underCountQty += $items->sum('updated_quantity');
        }

        $totalCountedQty = $lims_stock_count->items->flatten()->sum('updated_quantity');
        $totalCountedProducts = count($lims_stock_count->items);

        $counted_product_ids = $lims_stock_count->items->flatten()->pluck('product_id')->unique()->toArray();
        
        $lims_product_list_all = \App\Models\Product::ActiveStandard()
            ->join('product_warehouse', 'products.id', 'product_warehouse.product_id')
            ->where('product_warehouse.warehouse_id', $lims_stock_count->warehouse_id)
            ->where('product_warehouse.qty', '>', 0)
            ->select('products.id', 'products.name', 'products.code', 'products.price', 'products.cost', 'product_warehouse.qty')
            ->groupBy('products.id')
            ->get();
            
        $remainingProducts = $lims_product_list_all->filter(function($p) use ($counted_product_ids) {
            return !in_array($p->id, $counted_product_ids);
        });

        $remainingCount = $remainingProducts->count();
        $remainingQty = $remainingProducts->sum('qty');
        
        $totalRemainingPurchaseValue = $remainingProducts->sum(function($p) {
            return $p->qty * $p->cost;
        });
        
        $totalRemainingSaleValue = $remainingProducts->sum(function($p) {
            return $p->qty * $p->price;
        });

        // Fetch sold products under this stock count
        $soldQuery = \App\Models\Product_Sale::join('sales', 'product_sales.sale_id', '=', 'sales.id')
            ->join('products', 'product_sales.product_id', '=', 'products.id')
            ->leftJoin('product_variants', function($join) {
                $join->on('product_sales.product_id', '=', 'product_variants.product_id')
                     ->on('product_sales.variant_id', '=', 'product_variants.variant_id');
            })
            ->where('sales.warehouse_id', $lims_stock_count->warehouse_id)
            ->where('sales.created_at', '>=', $lims_stock_count->created_at);

        if ($lims_stock_count->is_completed) {
            $soldQuery->where('sales.created_at', '<=', $lims_stock_count->updated_at);
        }

        $soldProducts = $soldQuery->select(
                'products.id',
                'products.name',
                \Illuminate\Support\Facades\DB::raw('COALESCE(product_variants.item_code, products.code) as code'),
                'products.price',
                'products.cost',
                \Illuminate\Support\Facades\DB::raw('SUM(product_sales.qty) as sold_qty')
            )
            ->groupBy('products.id', 'products.name', 'product_variants.item_code', 'products.code', 'products.price', 'products.cost')
            ->get();

        $soldQty = $soldProducts->sum('sold_qty');
        $soldCount = $soldProducts->count();
    @endphp

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
                <div class="col-md-4 col-sm-6">
                    <div class="stat-card teal">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">মোট চেক করা আইডি</div>
                                <div class="value-large">{{ $totalCountedProducts }}</div>
                            </div>
                            <div>
                                <div class="title-small">মোট চেক জোড়া</div>
                                <div class="value-large">{{ number_format($totalCountedQty, 2, '.', '') }}</div>
                            </div>
                            <div style="font-size: 28px; color: #0891b2; opacity: 0.8;">
                                <i class="fa fa-barcode"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2: Remaining (Slate) -->
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('stock-count.remaining-products', $lims_stock_count->id) }}" class="d-block" style="text-decoration: none; color: inherit;">
                        <div class="stat-card slate" style="cursor: pointer;">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="title-small"><i class="fa fa-list" style="color: #3b82f6; margin-right: 5px;"></i> অবশিষ্ট বাকি আইডি</div>
                                    <div class="value-large">{{ $remainingCount }}</div>
                                </div>
                                <div>
                                    <div class="title-small" style="color: #3b82f6;">অবশিষ্ট বাকি জোড়া</div>
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
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('stock-count.sold-products', $lims_stock_count->id) }}" class="d-block" style="text-decoration: none; color: inherit;">
                        <div class="stat-card indigo" style="cursor: pointer;">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <div class="title-small"><i class="fa fa-shopping-bag" style="color: #6366f1; margin-right: 5px;"></i> বিক্রিত পণ্য</div>
                                    <div class="value-large">{{ $soldCount }}</div>
                                </div>
                                <div>
                                    <div class="title-small" style="color: #6366f1;">বিক্রিত জোড়া</div>
                                    <div class="value-large">{{ number_format($soldQty, 2, '.', '') }}</div>
                                </div>
                                <div style="font-size: 28px; color: #6366f1; opacity: 0.8;">
                                    <i class="fa fa-shopping-cart"></i>
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
                                <div class="title-small">সম্পূর্ণ মিল</div>
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
                                <div class="title-small">অতিরিক্ত ম্যাচ</div>
                                <div class="value-large">{{ number_format($overCountQty, 2, '.', '') }}</div>
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
                                <div class="title-small">আন্ডার স্টক</div>
                                <div class="value-large">{{ number_format($underCountQty, 2, '.', '') }}</div>
                            </div>
                            <div class="stat-icon-circle orange">
                                <i class="fa fa-arrow-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::open([
                'route' => ['stock-count.update', $lims_stock_count->id],
                'method' => 'put',
                'files' => true,
                'id' => 'stock-count-form',
            ]) !!}

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
                                                        <th>
                                                            <div class="form-check form-check-inline">
                                                                <input
                                                                    class="form-check
                                                                    input all"
                                                                    type="radio" name="resolved[all]"
                                                                    id="update_stock-all" value="update_stock">
                                                                <label class="form-check label" for="update_stock-all"
                                                                    style="margin-right: 10px;">Update All</label>
                                                            </div>
                                                            <div
                                                                class="form-check
                                                                form-check-inline">
                                                                <input class="form-check input all" type="radio"
                                                                    name="resolved[all]" id="cancel-all" value="cancel">
                                                                <label class="form-check label" for="cancel-all"
                                                                    style="margin-right: 10px;">Cancel All</label>
                                                            </div>
                                                        </th>
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
                                                            $total = $items->sum('updated_quantity');
                                                            $total_current_qty += $item->current_quantity;
                                                            $total_find_qty += $total;
                                                            $total_diff += abs($total - $item->current_quantity);
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
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="resolved[{{ $item->item_code }}]"
                                                                        id="update_stock-{{ $item->id }}"
                                                                        value="update_stock">
                                                                    <label class="form-check label"
                                                                        for="update_stock-{{ $item->id }}"
                                                                        style="margin-right: 10px;">
                                                                        Update Stock
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="resolved[{{ $item->item_code }}]"
                                                                        id="cancel-{{ $item->id }}" value="cancel">
                                                                    <label class="form-check label"
                                                                        for="cancel-{{ $item->id }}"
                                                                        style="margin-right: 10px;">
                                                                        Cancel
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total:</th>
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
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            <input type="hidden" name="status" value="resolved">
            <div class="form-group d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary" id="submit-btn">Resolved</button>
                <button type="button" class="btn btn-danger" id="revert-btn"><i class="fa fa-undo"></i> Back to Counting</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open([
                'route' => ['stock-count.incomplete', $lims_stock_count->id],
                'method' => 'POST',
                'id' => 'revert-form',
                'style' => 'display:none;'
            ]) !!}
            {!! Form::close() !!}
        </div>
    </section>

@endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        // Sidebar active menu
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");

        $('#revert-btn').on('click', function() {
            Swal.fire({
                title: '⚠️ Are you sure?',
                text: "Do you want to revert this stock count back to counting mode? You will be able to add more products to count.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Revert it!',
                cancelButtonText: 'No, Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#revert-form').submit();
                }
            });
        });

        // DataTable Initialization
        var table = $('.stock-count-table').DataTable({
            "order": [],
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
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
            dom: '<"row"lfB>rtip',
        });


        $('.all').on('change', function() {
            var value = $(this).val();
            $(table.cells().nodes()).find('input[type="radio"][value="' + value + '"]').prop('checked', true);
        });

        $('#submit-btn').on('click', function(e) {
            e.preventDefault();

            let btn = $(this);
            let allData = [];

            $(table.cells().nodes()).find('input[type="radio"]:checked').each(function() {
                let name = $(this).attr('name');
                if (name && name.includes('resolved[')) {
                    let val = $(this).val();
                    let itemCode = name.match(/\[(.*?)\]/)[1];
                    if (itemCode !== 'all') {
                        allData.push({ code: itemCode, action: val });
                    }
                }
            });

            if (allData.length === 0) {
                alert("Please select at least one item.");
                return;
            }

            // 2 Split data into chunks of 100
            let chunkSize = 100;
            let chunks = [];
            for (let i = 0; i < allData.length; i += chunkSize) {
                chunks.push(allData.slice(i, i + chunkSize));
            }

            btn.prop('disabled', true).text('Processing (0%)...');

            // 3 fast chunk send start
            sendChunk(0, chunks, btn);
        });

        // Recursive function to send each chunk sequentially
        function sendChunk(index, chunks, btn) {
            if (index >= chunks.length) {
                // alert('All data processed successfully!');
                window.location.href = "{{ route('stock-count.create') }}";
                return;
            }

            $.ajax({
                url: $('#stock-count-form').attr('action'),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
                    status: "resolved",
                    resolved_batch: chunks[index],
                    is_final_chunk: (index === chunks.length - 1) ? 1 : 0
                },
                success: function() {
                    let progress = Math.round(((index + 1) / chunks.length) * 100);
                    btn.text('Processing (' + progress + '%)...');

                    // next chunk call
                    sendChunk(index + 1, chunks, btn);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Resume Resolve');
                    alert('Error in batch ' + (index + 1) + '. Check console for details.');
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endpush

