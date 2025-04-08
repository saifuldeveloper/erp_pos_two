@extends('backend.layout.main')
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {!! session()->get('message') !!}
        </div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('not_permitted') }}
        </div>
    @endif

    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">Payroll Types</h3>
                </div>
            </div>
            <div class="container-fluid mb-2">
                <button class="btn btn-info" data-toggle="modal" data-target="#createModal">
                    <i class="dripicons-plus"></i> {{ trans('file.Add Payroll Type') }}
                </button>
            </div>
        </div>
        <div class="table-responsive container-fluid">
            <table id="payroll-type-table" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('file.Name') }}</th>
                        <th>{{ trans('file.Status') }}</th>
                        <th>{{ trans('file.Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrollTypes as $key => $type)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->status }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="{{ $type->id }}"
                                    data-name="{{ $type->name }}" data-status="{{ $type->status }}" data-toggle="modal"
                                    data-target="#editModal">
                                    <i class="dripicons-document-edit"></i> {{ trans('file.edit') }}
                                </button>
                                <form action="{{ route('payroll-types.destroy', $type->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmDelete()">
                                        <i class="dripicons-trash"></i> {{ trans('file.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Create Modal --}}
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('file.Add Payroll Type') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payroll-types.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>{{ trans('file.Name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.Status') }}</label>
                            <select name="status" class="form-control">
                                <option value="Active">{{ trans('file.Active') }}</option>
                                <option value="Inactive">{{ trans('file.Inactive') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('file.Edit Payroll Type') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ trans('file.Name') }} *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('file.Status') }}</label>
                            <select name="status" class="form-control">
                                <option value="Active">{{ trans('file.Active') }}</option>
                                <option value="Inactive">{{ trans('file.Inactive') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('file.update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $("ul#hrm").siblings('a').attr('aria-expanded', 'true');
        $("ul#hrm").addClass("show");
        $("ul#hrm #payroll-type-menu").addClass("active");
        function confirmDelete() {
            return confirm("Are you sure you want to delete?");
        }

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const status = $(this).data('status');

            const form = $('#editForm');
            form.attr('action', `/payroll-types/${id}`);
            form.find('input[name="name"]').val(name);
            form.find('select[name="status"]').val(status);
        });
    </script>
@endpush
