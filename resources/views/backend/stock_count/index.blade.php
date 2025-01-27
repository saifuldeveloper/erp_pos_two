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
            <a class="btn btn-primary" href="{{ route('stock-count.create') }}">
                <i class="dripicons-plus"></i>
                {{ trans('file.Count Stock') }}
            </a>
        </div>
        <div class="table-responsive">
            <table id="stock-count-table" class="table stock-count-list">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{trans('file.reference')}}</th>
                        <th>{{ trans('file.Date') }}</th>
                        <th>{{ trans('file.Warehouse') }}</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_stock_count_all as $key => $stock_count)
                        <?php
                        $warehouse = DB::table('warehouses')->find($stock_count->warehouse_id);
                        ?>
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $stock_count->reference_no }}</td>
                            <td>{{ date($general_setting->date_format, strtotime($stock_count->created_at->toDateString())) . ' ' . $stock_count->created_at->toTimeString() }}
                            </td>
                            <td>{{ $warehouse->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Action
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        <li>
                                            <button type="button" class="btn btn-link show-btn" data-toggle="modal"
                                                data-target="#show-stock-count-{{ $stock_count->id }}">
                                                <i class="dripicons-preview"></i>
                                                Show
                                            </button>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('stock-count.edit', $stock_count->id) }}"
                                                class="btn btn-link edit-btn">
                                                <i class="dripicons-document-edit"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade show" id="show-stock-count-{{ $stock_count->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="show-stock-count" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="show-stock-count">Stock Count ({{ $stock_count->reference_no  }})</h4>
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
            </table>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");

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
        });
    </script>
@endpush
