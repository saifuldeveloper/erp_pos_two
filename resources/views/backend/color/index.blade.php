@extends('backend.layout.main') @section('content')
    @if ($errors->has('name'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}
        </div>
    @endif
    @if ($errors->has('code'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ $errors->first('code') }}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

    <section>
        <div class="container-fluid">
            <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-primary"><i
                    class="dripicons-plus"></i> Add Color</a>&nbsp;
        </div>
        <div class="table-responsive">
            <table id="color-table" class="table">
                <thead>
                    <tr>
                        <th class="not-exported" width="15%">#</th>
                        <th width="50%">{{ trans('file.Name') }}</th>
                        <th width="50%">{{ trans('file.Code') }}</th>
                        <th class="not-exported">{{ trans('file.Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colors as $key => $color)
                        <tr data-id="{{ $color->id }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->code }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">{{ trans('file.Action') }}
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                        user="menu">
                                        <li>
                                            <button type="button" data-id="{{ $color->id }}"
                                                class="open-EditColorDialog btn btn-link" data-toggle="modal"
                                                data-target="#editModal"><i class="dripicons-document-edit"></i>
                                                {{ trans('file.edit') }}
                                            </button>
                                        </li>
                                        <li class="divider"></li>
                                        {{ Form::open(['route' => ['color.destroy', $color->id], 'method' => 'DELETE']) }}
                                        <li>
                                            <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i
                                                    class="dripicons-trash"></i> {{ trans('file.delete') }}</button>
                                        </li>
                                        {{ Form::close() }}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <!-- Modal -->

    <div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'color.store', 'method' => 'post']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Add Color</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('file.Name') }} *</label>
                        {{ Form::text('name', null, ['required' => 'required', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('file.Code') }} (Optional)</label>
                        {{ Form::text('code', null, ['class' => 'form-control']) }}
                    </div>
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => ['color.update', 1], 'method' => 'put']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"> {{ trans('file.Update Color') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="color_id">
                    <div class="form-group">
                        <label>{{ trans('file.Name') }} *</label>
                        {{ Form::text('name', null, ['required' => 'required', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('file.Code') }}</label>
                        {{ Form::text('code', null, ['class' => 'form-control']) }}
                    </div>
                    <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #color-menu").addClass("active");

        var color_id = [];
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

        $(document).ready(function() {
            $(document).on('click', '.open-EditColorDialog', function() {
                var url = "color/"
                var id = $(this).data('id').toString();
                url = url.concat(id).concat("/edit");

                $.get(url, function(data) {
                    $("input[name='name']").val(data['name']);
                    $("input[name='code']").val(data['code']);
                    $("input[name='color_id']").val(data['id']);
                });
            });

            $('#color-table').DataTable({
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
                }],
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
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'excel',
                        text: '<i title="export to excel" class="dripicons-document-new"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        text: '<i title="delete" class="dripicons-cross"></i>',
                        className: 'buttons-delete',
                        action: function(e, dt, node, config) {
                            if (user_verified == '1') {
                                color_id.length = 0;
                                $(':checkbox:checked').each(function(i) {
                                    if (i) {
                                        color_id[i - 1] = $(this).closest('tr').data('id');
                                    }
                                });
                                if (color_id.length && confirm("Are you sure want to delete?")) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'color/deletebyselection',
                                        data: {
                                            colorIdArray: color_id
                                        },
                                        success: function(data) {
                                            alert(data);
                                        }
                                    });
                                    dt.rows({
                                        page: 'current',
                                        selected: true
                                    }).remove().draw(false);
                                } else if (!color_id.length)
                                    alert('No color is selected!');
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
        });
    </script>
@endpush
