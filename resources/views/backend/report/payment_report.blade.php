@extends('backend.layout.main')
@section('content')
<style>
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .dark-mode .filter-card {
        background-color: #212837 !important;
        border: 1px solid #3b4253 !important;
    }
    .dark-mode .date-picker {
        background-color: #343d55 !important;
        border-color: #404656 !important;
        color: #eaeaea !important;
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">{{trans('file.Payment Report')}}</h3>

                <div class="filter-card">
                    {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post', 'id' => 'payment-filter-form']) !!}
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-3 col-sm-5 mb-2">
                            <label class="font-weight-bold">Start Date:</label>
                            <div class="input-group">
                                <input type="text" class="form-control date-picker" id="start_date" name="start_date" value="{{ $start_date }}" readonly style="cursor: pointer;" required />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-5 mb-2">
                            <label class="font-weight-bold">End Date:</label>
                            <div class="input-group">
                                <input type="text" class="form-control date-picker" id="end_date" name="end_date" value="{{ $end_date }}" readonly style="cursor: pointer;" required />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 mb-2 mt-md-4">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-filter"></i> {{trans('file.submit')}}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <div class="table-responsive mb-4">
                    <table id="report-table" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="not-exported"></th>
                                <th>{{trans('file.Date')}}</th>
                                <th>{{trans('file.Payment Reference')}} </th>
                                <th>{{trans('file.Sale Reference')}}</th>
                                <th>{{trans('file.Purchase Reference')}}</th>
                                <th>{{trans('file.Paid By')}}</th>
                                <th>{{trans('file.Amount')}}</th>
                                <th>{{trans('file.Created By')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lims_payment_data as $payment)
                            <?php
                                $sale = DB::table('sales')->find($payment->sale_id);
                                $purchase = DB::table('purchases')->find($payment->purchase_id);
                                $user = DB::table('users')->find($payment->user_id);
                            ?>
                            <tr>
                                <td></td>
                                <td>{{date($general_setting->date_format, strtotime($payment->created_at->toDateString())) . ' '. $payment->created_at->toTimeString()}}</td>
                                <td>{{$payment->payment_reference}}</td>
                                <td>@if($sale){{$sale->reference_no}}@endif</td>
                                <td>@if($purchase){{$purchase->reference_no}}@endif</td>
                                <td>{{$payment->paying_method}}</td>
                                <td>{{$payment->amount}}</td>
                                <td>{{$user->name ?? 'N/A'}}<br>{{$user->email ?? ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active">
                            <th></th>
                            <th>{{trans('file.Total')}}:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{number_format(0, $general_setting->decimal, '.', '')}}</th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li#payment-report-menu").addClass("active");

    $('#start_date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    $('#end_date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
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
                footer:true
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
                footer:true
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
                footer:true
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
                footer:true
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed({{$general_setting->decimal}}));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed({{$general_setting->decimal}}));
        }
    }
</script>
@endpush
