@extends('backend.layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
    @endif

    <section>
        <div class="container-fluid">
            <h2 class="text-center"> Due Clear List of {{ $lims_supplier->name }}</h2>
        </div>
        <div class="table-responsive">
            <table id="supplier-table" class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th class="not-exported">{{ trans('file.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lims_supplier_due_list as $key => $supplier_due)
                        <tr data-id="{{ $supplier_due->id }}">
                            <td>{{ Carbon\Carbon::parse($supplier_due->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $supplier_due->account->name }}</td>
                            <td>{{ $supplier_due->amount }}</td>
                            <td>{{ $supplier_due->note }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">{{ trans('file.action') }}
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        <li>
                                            <button type="button" class="clear-due btn btn-link" data-toggle="modal"
                                                data-target="#clearDueModal-{{ $supplier_due->id }}">
                                                <i class="dripicons-brush"></i>
                                                Edit
                                            </button>
                                        </li>
                                        <li class="divider"></li>
                                        {{ Form::open(['route' => ['supplier.clearDue.delete', $supplier_due->id], 'method' => 'DELETE']) }}
                                        <li>
                                            <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i
                                                    class="dripicons-trash"></i>
                                                {{ trans('file.delete') }}</button>
                                        </li>
                                        {{ Form::close() }}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <div id="clearDueModal-{{ $supplier_due->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    {!! Form::open(['route' => ['supplier.clearDue.update', $supplier_due->id], 'method' => 'post']) !!}
                                    <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Clear Due') }}</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="italic">
                                            <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                                        </p>
                                        <div class="form-group">
                                            <label for="created_at">Date *</label>
                                            <input type="date" name="created_at" class="form-control" required
                                                value="{{ Carbon\Carbon::parse($supplier_due->created_at)->format('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="account_id">Account *</label>
                                            @foreach ($lims_accounts as $account)
                                                <div class="form-check form-check">
                                                    <input class="form-check-input" type="radio" name="account_id"
                                                        id="account_id" value="{{ $account->id }}"
                                                        {{ $account->id == $supplier_due->account_id ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="account_id">{{ $account->name }}
                                                        ({{ $account->total_balance }}Tk)
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('file.Amount') }} *</label>
                                            <input type="number" name="amount" step="any" class="form-control"
                                                required value="{{ $supplier_due->amount }}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('file.Note') }}</label>
                                            <textarea name="note" rows="4" class="form-control">{{ $supplier_due->note }}</textarea>
                                        </div>
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary"
                                            id="submit-button">
                                    </div>
                                    {!! Form::close() !!}
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
        $("ul#people").siblings('a').attr('aria-expanded', 'true');
        $("ul#people").addClass("show");
        $("ul#people #supplier-list-menu").addClass("active");

        var supplier_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        $('#supplier-table').DataTable({
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
                    'targets': [0, 1, 2, 3]
                },
                {
                    'checkboxes': {
                        'selectRow': true
                    },
                    'targets': 0
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
                        stripHtml: false
                    },
                    customize: function(doc) {
                        for (var i = 1; i < doc.content[1].table.body.length; i++) {
                            if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -
                                1) {
                                var imagehtml = doc.content[1].table.body[i][0].text;
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                var src = regex.exec(imagehtml)[1];
                                var tempImage = new Image();
                                tempImage.src = src;
                                var canvas = document.createElement("canvas");
                                canvas.width = tempImage.width;
                                canvas.height = tempImage.height;
                                var ctx = canvas.getContext("2d");
                                ctx.drawImage(tempImage, 0, 0);
                                var imagedata = canvas.toDataURL("image/png");
                                delete doc.content[1].table.body[i][0].text;
                                doc.content[1].table.body[i][0].image = imagedata;
                                doc.content[1].table.body[i][0].fit = [30, 30];
                            }
                        }
                    },
                },
                {
                    extend: 'excel',
                    text: '<i title="export to excel" class="dripicons-document-new"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                    var regex = /<img.*?src=['"](.*?)['"]/;
                                    data = regex.exec(data)[1];
                                }
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible',
                        stripHtml: false
                    },
                },
                {
                    text: '<i title="delete" class="dripicons-cross"></i>',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            supplier_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    supplier_id[i - 1] = $(this).closest('tr').data(
                                        'id');
                                }
                            });
                            if (supplier_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'supplier/deletebyselection',
                                    data: {
                                        supplierIdArray: supplier_id
                                    },
                                    success: function(data) {
                                        alert(data);
                                    }
                                });
                                dt.rows({
                                    page: 'current',
                                    selected: true
                                }).remove().draw(false);
                            } else if (!supplier_id.length)
                                alert('No supplier is selected!');
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
        });
    </script>
@endpush
