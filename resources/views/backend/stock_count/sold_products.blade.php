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
        .stat-card.indigo { border-left: 5px solid #6366f1; }
        
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
        .stat-card.indigo .value-large { color: #6366f1; }

        .stat-icon {
            font-size: 28px;
            opacity: 0.8;
        }
        .stat-icon.teal { color: #0891b2; }
        .stat-icon.slate { color: #4b5563; }
        .stat-icon.orange { color: #f59e0b; }
        .stat-icon.green { color: #22c55e; }
        .stat-icon.indigo { color: #6366f1; }

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
                            <h4>{{ trans('file.Sold Products') }} (Warehouse: {{ $lims_stock_count->warehouse->name ?? trans('file.All Warehouse') }}) (#{{ $lims_stock_count->id }})</h4>
                            <a href="{{ route('stock-count.show', $lims_stock_count->id) }}" class="btn btn-info ml-auto">
                                <i class="fa fa-arrow-left"></i> Back to Count
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <!-- Card 1: Total Items (Indigo) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card indigo">
                                        <div>
                                            <div class="title-small">{{ trans('file.Total Sold Items') }}</div>
                                            <div class="value-large">{{ $soldCount }}</div>
                                        </div>
                                        <div class="stat-icon indigo">
                                            <i class="fa fa-th-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card 2: Total Quantity (Slate) -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-card slate">
                                        <div>
                                            <div class="title-small">{{ trans('file.Total Sold Pairs') }}</div>
                                            <div class="value-large">{{ number_format($soldQty, 2, '.', '') }}</div>
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
                                            <div class="title-small">{{ trans('file.Total Sold Purchase Value') }}</div>
                                            <div class="value-large">{{ number_format($totalSoldPurchaseValue, 2, '.', '') }}</div>
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
                                            <div class="title-small">{{ trans('file.Total Sold Sale Value') }}</div>
                                            <div class="value-large">{{ number_format($totalSoldSaleValue, 2, '.', '') }}</div>
                                        </div>
                                        <div class="stat-icon green">
                                            <i class="fa fa-tags"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!! Form::open(['route' => ['stock-count.sold-products', $lims_stock_count->id], 'method' => 'GET', 'id' => 'filter-form']) !!}
                            <div class="row mb-4 align-items-end">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2" style="flex: 1;"><i class="fa fa-filter"></i> Filter</button>
                                        <a href="{{ route('stock-count.sold-products', $lims_stock_count->id) }}" class="btn btn-secondary" style="flex: 1;"><i class="fa fa-undo"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div class="table-responsive">
                                <table class="table table-hover" id="sold-products-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('file.Product Name') }}</th>
                                            <th>{{ trans('file.Code') }}</th>
                                            <th>{{ trans('file.Purchase Price (Unit)') }}</th>
                                            <th>{{ trans('file.Sale Price (Unit)') }}</th>
                                            <th>{{ trans('file.Sold Pairs') }}</th>
                                            <th>{{ trans('file.Total Purchase Value') }}</th>
                                            <th>{{ trans('file.Total Sale Value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($soldProducts as $index => $product)
                                            @php
                                                $rowPurchaseVal = $product->sold_qty * $product->cost;
                                                $rowSaleVal = $product->sold_qty * $product->price;
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ number_format($product->cost, 2, '.', '') }}</td>
                                                <td>{{ number_format($product->price, 2, '.', '') }}</td>
                                                <td>{{ number_format($product->sold_qty, 2, '.', '') }}</td>
                                                <td>{{ number_format($rowPurchaseVal, 2, '.', '') }}</td>
                                                <td>{{ number_format($rowSaleVal, 2, '.', '') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{ trans('file.Total') }}:</th>
                                            <th>{{ $soldCount }} {{ trans('file.Items') }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>{{ number_format($soldQty, 2, '.', '') }}</th>
                                            <th>{{ number_format($totalSoldPurchaseValue, 2, '.', '') }}</th>
                                            <th>{{ number_format($totalSoldSaleValue, 2, '.', '') }}</th>
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
@endsection

@push('scripts')
    <script type="text/javascript">
        // Sidebar active menu
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");

        // DataTable Initialization
        $('#sold-products-table').DataTable({
            "order": [],
            "pageLength": 25,
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
            buttons: [
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    exportOptions: {
                        columns: ':visible:Not(.not-export)',
                        rows: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-excel-o"></i> CSV',
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
    </script>
@endpush
