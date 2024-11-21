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
                                    <th>{{ trans('file.Total') }}</th>
                                    <th class="not-exported">{{ trans('file.action') }}</th>
                                </tr>
                            </thead>
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
                                <h4 class="modal-title"> Waste Details</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($waste->items as $item)
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
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
                                    aria-label="Close">Close</button>
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

        $(document).ready(function() {
            $('#wasteTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('waste.wastedata') }}',
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
                        data: 'total_price',
                        render: $.fn.dataTable.render.number(',', '.', 2, '৳')
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `<div class="btn-group">
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
                                </li>
                                <form action="{{ url('wastes') }}/${data}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <li class="divider"></li>
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure want to delete?')"><i class="dripicons-trash"></i> {{ trans('file.delete') }}</button>
                                </li>
                                </form>
                            </ul>
                        </div>`;
                        }
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
                ],
            });
        });
    </script>
@endpush
