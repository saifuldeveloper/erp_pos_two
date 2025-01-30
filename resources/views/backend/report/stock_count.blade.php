@extends('backend.layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">Stock Count Report</h3>
                </div>
                {!! Form::open(['route' => 'report.stockCount', 'method' => 'get']) !!}
                <div class="row ml-1 mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Brand') }}</strong></label>
                            <select id="brand_id" name="brand_id" class="form-control selectpicker" data-live-search="true"
                                data-live-search-style="begins" title="Select Brand...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_brand_list as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $brand->id == request()->brand_id ? 'selected' : '' }}>
                                        {{ $brand->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Product') }}</strong></label>
                            <select id="product_id" name="product_id" class="form-control selectpicker"
                                data-live-search="true" data-live-search-style="begins" title="Select Product...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_product_list as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $product->id == request()->product_id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Warehouse') }}</strong></label>
                            <select id="warehouse_id" name="warehouse_id" class="form-control selectpicker"
                                data-live-search="true" data-live-search-style="begins" title="Select Warehouse...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ $warehouse->id == request()->warehouse_id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-group">
                            <button class="btn btn-primary w-100" id="filter-btn"
                                type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="table-responsive">
            <table id="stock-count-table" class="table stock-count-list">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.reference') }}</th>
                        <th>{{ trans('file.Date') }}</th>
                        <th>{{ trans('file.Warehouse') }}</th>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Current Quantity</th>
                        <th>Total Price</th>
                        <th>Updated Quantity</th>
                        <th>Total Price</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_stock_count_all as $key => $stock_count)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $stock_count->reference_no }}</td>
                            <td>{{ date($general_setting->date_format, strtotime($stock_count->created_at->toDateString())) . ' ' . $stock_count->created_at->toTimeString() }}
                            </td>
                            <td>{{ $stock_count->warehouse->name }}</td>
                            <td>{{ $stock_count->brand->title }}</td>
                            <td>{{ $stock_count->product->name }}</td>
                            <td>{{ $stock_count->items->sum('current_quantity') }}</td>
                            <td>{{ $stock_count->product->price * $stock_count->items->sum('current_quantity') }}</td>
                            <td>{{ $stock_count->items->sum('updated_quantity') }}</td>
                            <td>{{ $stock_count->product->price * $stock_count->items->sum('updated_quantity') }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default show-btn" data-toggle="modal"
                                        data-target="#show-stock-count-{{ $stock_count->id }}">
                                        <i class="dripicons-preview"></i>
                                        Show
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade show" id="show-stock-count-{{ $stock_count->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="show-stock-count" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="show-stock-count">Stock Count
                                            ({{ $stock_count->reference_no }})
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-2 text-center">
                                            <div class="col-md-3"><strong>{{ trans('file.Product') }}</strong></div>
                                            <div class="col-md-3"><strong>{{ trans('file.Item Code') }}</strong></div>
                                            <div class="col-md-3"><strong>Current Quantity</strong></div>
                                            <div class="col-md-3"><strong>Updated Quantity</strong></div>
                                        </div>
                                        @foreach ($stock_count->items as $item)
                                            <div class="row mb-2 text-center">
                                                <div class="col-md-3">{{ $item->product->name }}</div>
                                                <div class="col-md-3">{{ $item->item_code }}</div>
                                                <div class="col-md-3">{{ $item->current_quantity }}</div>
                                                <div class="col-md-3">{{ $item->updated_quantity }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#report").siblings('a').attr('aria-expanded', 'true');
        $("ul#report").addClass("show");
        $("ul#report #stock-count-report-menu").addClass("active");

        $('#stock-count-table').DataTable({
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
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3]
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                }
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                    },
                },
                {
                    extend: 'excel',
                    text: '<i title="export to excel" class="dripicons-document-new"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                    },
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                    },
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                    },
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum(api, false);
            }
        });

        function datatable_sum(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(6).footer()).html(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(7).footer()).html(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(8).footer()).html(dt_selector.cells(rows, 8, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(9).footer()).html(dt_selector.cells(rows, 9, {
                    page: 'current'
                }).data().sum().toFixed(2));
            } else {
                $(dt_selector.column(6).footer()).html(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(7).footer()).html(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(8).footer()).html(dt_selector.cells(rows, 8, {
                    page: 'current'
                }).data().sum().toFixed(2));
                $(dt_selector.column(9).footer()).html(dt_selector.cells(rows, 9, {
                    page: 'current'
                }).data().sum().toFixed(2));
            }
        }
    </script>
@endpush
