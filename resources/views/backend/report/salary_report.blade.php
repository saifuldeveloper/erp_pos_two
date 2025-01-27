@extends('backend.layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>
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
                    <h3 class="text-center">{{ trans('file.Salary') }}</h3>
                </div>
                {!! Form::open(['route' => 'report.salary', 'method' => 'get']) !!}
                <div class="row ml-1 mt-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Employee') }}</strong></label>
                            <select id="employee_id" name="employee_id" class="form-control selectpicker"
                                data-live-search="true" data-live-search-style="begins" title="Select Employee...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_employee_list as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ $employee->id == $employee_id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Date') }}</strong></label>
                            <input type="text" class="daterangepicker-field form-control"
                                value="{{ $starting_date }} To {{ $ending_date }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
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

            @if ($employee_id != '')
                <div class="card">
                    <div class="card-header">
                        <h3>Employee Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ url('public/images/employee', $selected_employee->image) }}"
                                                class="img-fluid" alt="Employee Image" height="300" width="300">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $selected_employee->name }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>Email</th>
                                                <td>{{ $selected_employee->email }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Phone Number</th>
                                                <td>{{ $selected_employee->phone_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{ $selected_employee->department->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Staff ID</th>
                                                <td>{{ $selected_employee->staff_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $selected_employee->address }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th>City</th>
                                                <td>{{ $selected_employee->city }}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>{{ $selected_employee->country }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>Salary</th>
                                                <td>{{ $selected_employee->salary }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Payable</th>
                                                <td>
                                                    {{ number_format((float) $lims_payroll_all->where('employee_id', $employee_id)->count() * $selected_employee->salary, $general_setting->decimal, '.', '') }}    
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Paid</th>
                                                <td>
                                                    {{-- sum of $lims_payroll_all->where('employee_id', $employee_id)->sum('amount') --}}
                                                    {{ number_format((float) $lims_payroll_all->where('employee_id', $employee_id)->sum('amount'), $general_setting->decimal, '.', '') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table id="payroll-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported"></th>
                        <th>{{ trans('file.date') }}</th>
                        <th>{{ trans('file.reference') }}</th>
                        <th>{{ trans('file.Employee') }}</th>
                        <th>{{ trans('file.Account') }}</th>
                        <th>{{ trans('file.Salary') }}</th>
                        <th>{{ trans('file.Amount') }}</th>
                        <th>{{ trans('file.Method') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_payroll_all as $key => $payroll)
                        @php
                            $employee = \App\Models\Employee::find($payroll->employee_id);
                            $account = \App\Models\Account::find($payroll->account_id);
                        @endphp
                        <tr data-id="{{ $payroll->id }}">
                            <td>{{ $key }}</td>
                            <td>{{ date($general_setting->date_format, strtotime($payroll->created_at->toDateString())) }}
                            </td>
                            <td>{{ $payroll->reference_no }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $account->name }}</td>
                            <td>{{ number_format((float) $employee->salary, $general_setting->decimal, '.', '') }}</td>
                            <td>{{ number_format((float) $payroll->amount, $general_setting->decimal, '.', '') }}</td>
                            @if ($payroll->paying_method == 0)
                                <td>Cash</td>
                            @elseif($payroll->paying_method == 1)
                                <td>Cheque</td>
                            @else
                                <td>Credit Card</td>
                            @endif
                        </tr>
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
        $("ul#report #salary-report-menu").addClass("active");

        var payroll_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var starting_date = startDate.format('YYYY-MM-DD');
                var ending_date = endDate.format('YYYY-MM-DD');
                var title = starting_date + ' To ' + ending_date;
                $(this).val(title);
                $('input[name="starting_date"]').val(starting_date);
                $('input[name="ending_date"]').val(ending_date);
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#payroll-table').DataTable({
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
                    'targets': [0, 1, 6]
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
                        rows: ':visible',
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
                        rows: ':visible',
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
                        rows: ':visible',
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    text: '<i title="delete" class="dripicons-cross"></i>',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            payroll_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    payroll_id[i - 1] = $(this).closest('tr').data('id');
                                }
                            });
                            if (payroll_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'payroll/deletebyselection',
                                    data: {
                                        payrollIdArray: payroll_id
                                    },
                                    success: function(data) {
                                        alert(data);
                                    }
                                });
                                dt.rows({
                                    page: 'current',
                                    selected: true
                                }).remove().draw(false);
                            } else if (!payroll_id.length)
                                alert('No payroll is selected!');
                        } else
                            alert('This feature is disable for demo!');
                    }
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
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            } else {
                $(dt_selector.column(6).footer()).html(dt_selector.cells(rows, 6, {
                    page: 'current'
                }).data().sum().toFixed({{ $general_setting->decimal }}));
            }
        }
    </script>
@endpush
