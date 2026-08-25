@extends('backend.layout.main')
@section('content')
<style>
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">{{ trans('file.Supplier Report') }}</h3>

                <div class="filter-card">
                    {!! Form::open(['route' => 'report.supplier', 'method' => 'post', 'id' => 'supplier-filter-form']) !!}
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label class="font-weight-bold">Start Date:</label>
                            <div class="input-group">
                                <input type="text" class="form-control date-picker" id="start_date" name="start_date"
                                    value="{{ $start_date }}" readonly style="background-color: #fff; cursor: pointer;" required />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <label class="font-weight-bold">End Date:</label>
                            <div class="input-group">
                                <input type="text" class="form-control date-picker" id="end_date" name="end_date"
                                    value="{{ $end_date }}" readonly style="background-color: #fff; cursor: pointer;" required />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-2">
                            <label class="font-weight-bold">{{ trans('file.Choose Supplier') }}:</label>
                            <input type="hidden" name="supplier_id_hidden" value="{{ $supplier_id }}" />
                            <select id="supplier_id" name="supplier_id" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                @foreach ($lims_supplier_list as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                        ({{ $supplier->phone_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-2 mt-md-4">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-filter"></i> {{ trans('file.submit') }}
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#supplier-payments" role="tab" data-toggle="tab">
                    Payment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#supplier-purchase-payments" role="tab" data-toggle="tab">Purchase
                    Payment</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#supplier-purchase" role="tab"
                    data-toggle="tab">{{ trans('file.Purchase') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#supplier-return" role="tab" data-toggle="tab">{{ trans('file.Return') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#supplier-quotation" role="tab"
                    data-toggle="tab">{{ trans('file.Quotation') }}</a>
            </li>
        </ul>
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade show active" id="supplier-payments">
                <div class="table-responsive mb-4">
                    <table id="payment-table" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported-payment"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>Account</th>
                                <th>{{ trans('file.Amount') }}</th>
                            </tr>
                        </thead>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>{{ trans('file.Total') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="supplier-purchase-payments">
                <div class="table-responsive mb-4">
                    <table id="purchase-payment-table" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported-payment"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.Payment Reference') }}</th>
                                <th>{{ trans('file.Purchase Reference') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Paid Method') }}</th>
                            </tr>
                        </thead>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>{{ trans('file.Total') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="supplier-purchase">
                <div class="table-responsive mb-4">
                    <table id="purchase-table" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported-purchase"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Warehouse') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                                <th>{{ trans('file.Paid') }}</th>
                                <th>{{ trans('file.Balance') }}</th>
                                <th>{{ trans('file.Status') }}</th>
                            </tr>
                        </thead>
                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>{{ trans('file.Total') }}</th>
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
            </div>

            <div role="tabpanel" class="tab-pane fade" id="supplier-return">
                <div class="table-responsive mb-4">
                    <table id="return-table" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported-return"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Warehouse') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                            </tr>
                        </thead>

                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>{{ trans('file.Total') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{ number_format(0, $general_setting->decimal, '.', '') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="supplier-quotation">
                <div class="table-responsive mb-4">
                    <table id="quotation-table" class="table table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported-quotation"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Warehouse') }}</th>
                                <th>{{ trans('file.customer') }}</th>
                                <th>{{ trans('file.product') }} ({{ trans('file.qty') }})</th>
                                <th>{{ trans('file.grand total') }}</th>
                                <th>{{ trans('file.Status') }}</th>
                            </tr>
                        </thead>

                        <tfoot class="tfoot active">
                            <tr>
                                <th></th>
                                <th>{{ trans('file.Total') }}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{ number_format(0, $general_setting->decimal, '.', '') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Details Modal -->
<div id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 id="productModalLabel" class="modal-title font-weight-bold text-dark">
                    <i class="fa fa-cubes text-primary mr-1"></i> <span id="productModalTitle">Products List</span>
                </h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mb-0" id="productModalTable">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 8%;" class="text-center">#</th>
                                <th style="width: 50%;">{{ trans('file.product') }}</th>
                                <th style="width: 22%;">{{ trans('file.Code') ?? 'Code' }}</th>
                                <th style="width: 20%;" class="text-right">{{ trans('file.qty') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ trans('file.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#report").siblings('a').attr('aria-expanded', 'true');
        $("ul#report").addClass("show");
        $("ul#report #supplier-report-menu").addClass("active");

        var start_date = <?php echo json_encode($start_date); ?>;
        var end_date = <?php echo json_encode($end_date); ?>;
        var supplier_id = <?php echo json_encode($supplier_id); ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#supplier_id').val($('input[name="supplier_id_hidden"]').val());
        $('.selectpicker').selectpicker('refresh');

        $('#purchase-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "supplier-purchase-data",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    supplier_id: supplier_id
                },
                dataType: "json",
                type: "post"
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "warehouse"
                },
                {
                    "data": "product"
                },
                {
                    "data": "grand_total"
                },
                {
                    "data": "paid"
                },
                {
                    "data": "balance"
                },
                {
                    "data": "status"
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
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3, 4, 5, 6, 7, 8]
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
            rowId: 'ObjectID',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_sale(api, false);
            }
        });

        function datatable_sum_sale(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(5).footer()).html(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
                $(dt_selector.column(6).footer()).html(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
                $(dt_selector.column(7).footer()).html(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(5).footer()).html(dt_selector.column(5, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
                $(dt_selector.column(6).footer()).html(dt_selector.column(6, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
                $(dt_selector.column(7).footer()).html(dt_selector.cells(rows, 7, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }

        $('#payment-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "supplier-payment",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    supplier_id: supplier_id
                },
                dataType: "json",
                type: "post"
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "account"
                },
                {
                    "data": "amount"
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
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 2, 3]
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
            rowId: 'ObjectID',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment1(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment1(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment1(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment1(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment1(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_payment1(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_payment1(api, false);
            }
        });

        function datatable_sum_payment1(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(3).footer()).html(dt_selector.cells(rows, 3, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(3).footer()).html(dt_selector.column(3, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }

        $('#purchase-payment-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "supplier-payment-data",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    supplier_id: supplier_id
                },
                dataType: "json",
                type: "post"
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "purchase_reference"
                },
                {
                    "data": "amount"
                },
                {
                    "data": "paying_method"
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
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 2, 3, 4]
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
            rowId: 'ObjectID',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-payment)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_payment(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_payment(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_payment(api, false);
            }
        });

        function datatable_sum_payment(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(4).footer()).html(dt_selector.cells(rows, 4, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(4).footer()).html(dt_selector.column(4, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }

        $('#return-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "supplier-return-data",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    supplier_id: supplier_id
                },
                dataType: "json",
                type: "post"
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "warehouse"
                },
                {
                    "data": "product"
                },
                {
                    "data": "grand_total"
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
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3, 4, 5]
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
            rowId: 'ObjectID',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-return)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-return)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-return)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_return(api, false);
            }
        });

        function datatable_sum_return(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(5).footer()).html(dt_selector.cells(rows, 5, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(5).footer()).html(dt_selector.column(5, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }

        $('#quotation-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "supplier-quotation-data",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    supplier_id: supplier_id
                },
                dataType: "json",
                type: "post"
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "warehouse"
                },
                {
                    "data": "customer"
                },
                {
                    "data": "product"
                },
                {
                    "data": "grand_total"
                },
                {
                    "data": "status"
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
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 3, 4, 5, 6, 7]
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
            rowId: 'ObjectID',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-quotation)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_quotation(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_quotation(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-quotation)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_quotation(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_quotation(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-quotation)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_quotation(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_quotation(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum_quotation(api, false);
            }
        });

        function datatable_sum_quotation(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                $(dt_selector.column(6).footer()).html(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(6).footer()).html(dt_selector.column(6, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }

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

        $(document).on('click', '.view-products-btn', function(e) {
            e.preventDefault();
            var reference = $(this).data('reference') || '';
            var products = $(this).data('products') || [];
            
            $('#productModalTitle').text('Products for Reference: ' + reference);
            var rows = '';
            if (products.length > 0) {
                $.each(products, function(idx, item) {
                    var codeBadge = item.code ? '<span class="badge badge-secondary px-2 py-1" style="font-size: 0.85rem;">' + item.code + '</span>' : '<span class="text-muted">-</span>';
                    rows += '<tr>' +
                        '<td class="text-center font-weight-bold text-secondary">' + (idx + 1) + '</td>' +
                        '<td><strong class="text-dark">' + item.name + '</strong></td>' +
                        '<td>' + codeBadge + '</td>' +
                        '<td class="text-right font-weight-bold text-primary" style="font-size: 0.95rem;">' + item.qty + '</td>' +
                        '</tr>';
                });
            } else {
                rows = '<tr><td colspan="4" class="text-center text-muted">No products found</td></tr>';
            }
            $('#productModalTable tbody').html(rows);
            $('#productModal').modal('show');
        });
    </script>
@endpush
