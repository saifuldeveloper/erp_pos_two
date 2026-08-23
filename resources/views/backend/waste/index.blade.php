@extends('backend.layout.main') @section('content')

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
                        <div class="card-header">
                            <h3 class="text-center">{{ trans('file.Waste List') }}</h3>
                        </div>
                        {!! Form::open(['route' => 'waste.index', 'method' => 'get']) !!}
                        <div class="row ml-1 mt-2 mb-3 align-items-end">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label><strong>{{ trans('file.Start Date') }} *</strong></label>
                                    <input type="text" name="start_date" class="form-control date" value="{{ $start_date }}" required readonly />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label><strong>{{ trans('file.End Date') }} *</strong></label>
                                    <input type="text" name="end_date" class="form-control date" value="{{ $end_date }}" required readonly />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary w-100" id="filter-btn" type="submit">{{trans('file.submit')}}</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="wasteTable" class="table table-striped table-hover" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th>{{ trans('file.Date') }}</th>
                                    <th>{{ trans('file.Receiver Type') }}</th>
                                    <th>{{ trans('file.Receiver') }}</th>
                                    <th>{{ trans('file.Count') }}</th>
                                    <th>{{ trans('file.Purchase Price') }}</th>
                                    <th>{{ trans('file.Total') }}</th>
                                    <th class="not-exported">{{ trans('file.action') }}</th>
                                </tr>
                            </thead>
                            <tfoot class="tfoot active">
                                <th>{{trans('file.Total')}}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @foreach ($wastes as $waste)
                <div class="modal fade" id="view-waste-{{ $waste->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="view-waste-{{ $waste->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> {{ trans('file.Waste Details') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('file.Product Name') }}</th>
                                            <th>{{ trans('file.Quantity') }}</th>
                                            <th>{{ trans('file.Price') }}</th>
                                            <th>{{ trans('file.Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($waste->items as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->product->name }}
                                                    @if($item->varient_code)
                                                        <br><small>[{{ $item->varient_code }}]</small>
                                                    @endif
                                                </td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ $item->subtotal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    aria-label="Close">{{ trans('file.Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#waste").siblings('a').attr('aria-expanded', 'true');
        $("ul#waste").addClass("show");
        $("ul#waste #waste-list-menu").addClass("active");

        var start_date = <?php echo json_encode($start_date); ?>;
        var end_date = <?php echo json_encode($end_date); ?>;

        $(document).ready(function() {
            $('#wasteTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('waste.wastedata') }}',
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    type: 'GET'
                },
                columns: [{
                        data: 'date',
                        render: function(data, type, row) {
                            return data ? moment(data).format('DD-MM-YYYY') : '';
                        }
                    },
                    {
                        data: 'receiver_type'
                    },
                    {
                        data: 'receiver_name'
                    },
                    {
                        data: 'total_qty',
                        render: $.fn.dataTable.render.number(',', '.', 0)
                    },
                    {
                        data: 'purchase_price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '৳')
                    },
                    {
                        data: 'total_price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '৳')
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var html = `<div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ trans('file.action') }}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a class="open-EditbrandDialog btn btn-link" href="{{ url('wastes') }}/${data}/edit">
                                        <i class="dripicons-document-edit"></i>
                                        {{ trans('file.edit') }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="btn btn-link" href="javascript:void(0)" data-toggle="modal" data-target="#view-waste-${data}">
                                        <i class="dripicons-preview"></i>
                                        {{ trans('file.View') }}
                                    </a>
                                </li>`;

                            @if(in_array("waste-delete", $all_permission))
                            html += `<form action="{{ url('wastes') }}/${data}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <li class="divider"></li>
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure want to delete?')"><i class="dripicons-trash"></i> {{ trans('file.delete') }}</button>
                                </li>
                                </form>`;
                            @endif

                            html += `</ul></div>`;
                            return html;
                        }
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('waste-link');
                    $(row).attr('data-id', data['id']);
                },
                order: [['0', 'desc']],
                'columnDefs': [
                    {
                        "orderable": false,
                        'targets': [4, 6]
                    }
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
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                rowId: 'ObjectID',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            datatable_sum(dt, true);
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                            datatable_sum(dt, false);
                        },
                        footer: true
                    },
                    {
                        extend: 'excel',
                        text: '<i title="export to excel" class="dripicons-document-new"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            datatable_sum(dt, true);
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                            datatable_sum(dt, false);
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            datatable_sum(dt, true);
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                            datatable_sum(dt, false);
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        action: function(e, dt, button, config) {
                            datatable_sum(dt, true);
                            $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                            datatable_sum(dt, false);
                        },
                        footer: true
                    },
                ],
                drawCallback: function () {
                    var api = this.api();
                    datatable_sum(api, false);
                }
            });
        });

        function datatable_sum(dt_selector, is_calling_first) {
            var rows;
            if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
                rows = dt_selector.rows( '.selected' ).indexes();

                $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum().toFixed(0));
                $( dt_selector.column( 4 ).footer() ).html('৳' + dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
                $( dt_selector.column( 5 ).footer() ).html('৳' + dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
            }
            else {
                $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum().toFixed(0));
                $( dt_selector.column( 4 ).footer() ).html('৳' + dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
                $( dt_selector.column( 5 ).footer() ).html('৳' + dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
            }
        }

        $(document).on("click", "tr.waste-link td:not(:last-child)", function() {
            var id = $(this).parent().attr('data-id');
            $('#view-waste-' + id).modal('show');
        });
    </script>
@endpush
