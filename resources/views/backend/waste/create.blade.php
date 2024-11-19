@extends('backend.layout.main') @section('content')

@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center" id="waste-header">
                        <a href="#" class="btn btn-primary collapsed float-right" data-toggle="collapse" data-target="#waste-form" aria-expanded="false">{{ trans('file.Add Waste')}} <i class="dripicons-plus"></i></a>
                    </div>
                    <div class="collapse" id="waste-form">
                        <div class="card-body">
                            <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                            {!! Form::open(['route' => 'waste.store', 'method' => 'POST', 'id' => 'waste-form']) !!}
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.Receiver Type')}} *</label>
                                        <select name="receiver_type" id="receiver_type" class="selectpicker form-control">
                                            <option selected disabled value="">{{ trans('file.Select One') }}</option>
                                            <option value="supplier">{{ trans('file.Supplier') }}</option>
                                            <option value="customer">{{ trans('file.customer') }}</option>
                                            <option value="biller">{{ trans('file.Biller') }}</option>
                                            <option value="employee">{{ trans('file.Employee') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id="receiverList">
                                        <label>{{trans('file.Receiver')}} *</label>
                                        <select name="receiver_id" id="receiver_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select receiver...">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.Product')}} *</label>
                                        <select name="product_id" id="product_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select product...">
                                            @foreach ($products as $product)
                                                <option data-price="{{$product->price}}" data-qty="{{$product->qty}}" value="{{$product->id}}">{{$product->name .'- '.$product->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.Quantity')}} *</label>
                                        <input type="number" name="quantity" id="quantity" min="1" max="" value="1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.Unit Price')}} *</label>
                                        <input type="text" name="amount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.Total')}} *</label>
                                        <input type="text" name="total" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{trans('file.Note')}}</label>
                                        <input type="text" name="note" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <button type="submit" id="submit-btn" class="btn btn-primary">{{trans('file.submit')}}</button>
                                    </div>

                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="wasteTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.Receiver Type') }}</th>
                                <th>{{ trans('file.Receiver') }}</th>
                                <th>{{ trans('file.Product') }}</th>
                                <th>{{ trans('file.Quantity') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Total') }}</th>
                                <th class="not-exported">{{ trans('file.action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale #waste-list-menu").addClass("active");

    $(document).ready(function() {
        $('#receiver_type').on('change', function() {
            var type = $(this).val();
            $.get('receiver-list/' + type, function(data) {
                $('#receiverList').empty().html(data);
                $('.selectpicker').selectpicker('refresh');
            });
        });

        $('#product_id').on('change', function() {
            var price = $('option:selected', this).data('price');
            var qty = $('option:selected', this).data('qty');
            $('input[name="amount"]').val(price);
            $('input[name="quantity"]').attr('max', qty);
            calculateTotal();
        });

        function calculateTotal() {
            var quantity = $('input[name="quantity"]').val();
            var amount = $('input[name="amount"]').val();
            var total = parseFloat(quantity) * parseFloat(amount);
            $('input[name="total"]').val(total);
        }

        $('#quantity, #amount').on('change', calculateTotal);

        $('#wasteTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('waste.wastedata') }}',
            type: 'GET'
        },
        columns: [
            { data: 'date', render: function(data, type, row) { return data ? moment(data).format('DD-MM-YYYY') : ''; } }, // তারিখ
            { data: 'receiver_type' }, // Receiver Type
            { data: 'receiver_name' }, // Receiver ID
            { data: 'product_info' }, // Product Name + Code
            { data: 'qty' }, // Quantity
            { data: 'unit_price' }, // Unit Price
            { data: 'total_price', render: $.fn.dataTable.render.number(',', '.', 2, '৳') }, // Total Price
            {
                data: 'id',
                render: function(data, type, row) {
                    return `<button class="btn btn-sm btn-primary edit-btn" data-id="${data}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>`;
                }
            }
        ],
        'language': {

            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        rowId: 'ObjectID',
        buttons: [
            {
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
