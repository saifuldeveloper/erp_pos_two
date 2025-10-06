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
            <div class="card">
                <div class="card-header mt-2">
                    <div class="d-flex">
                        <h3 class="text-start"> {{ trans('file.Stock Count Report') }}</h3><br>

                        <a href="{{ route('report.stockCount') }}" class="btn btn-primary ml-auto">
                            <i class="fas fa-list"></i>
                            Stock Count
                        </a>

                    </div>
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <div class="wrapper count-title">
                                    <h4><strong style="color: #ff8040">Total Qty:</strong>{{ $count_data['total_qty'] }}</h4>
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="wrapper count-title">
                                    <h4><strong style="color: #ff8040">Total Price:</strong> {{ $count_data['total_price'] }}</h4>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="wrapper count-title">
                                    <h4><strong style="color: #ff8040">Cost:</strong> {{ $count_data['total_cost'] }}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div>
                        {!! Form::open(['route' => 'report.stockCount.remaining', 'method' => 'get']) !!}
                        <div class="row mb-3">
                            <div class="col-md-4 offset-md-1 mt-4">
                                <div class="form-group row">
                                    <label class="d-tc mt-2"><strong>{{ trans('file.Choose Your Date') }}</strong>
                                        &nbsp;</label>
                                    <div class="d-tc">
                                        <div class="input-group">
                                            <input type="text" class="daterangepicker-field form-control"
                                                value="{{ request('start_date') ?? date('Y-m-d') }} To {{ request('end_date') ?? date('Y-m-d') }}">
                                            <input type="hidden" name="start_date" value="{{ request('start_date') }}" />
                                            <input type="hidden" name="end_date" value="{{ request('end_date') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4">
                                <input type="text" class="form-control" name="countID" value="{{ request('countID') }}"
                                    placeholder="Enter Counting ID">
                            </div>
                            <div class="col-md-3 mt-4">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">{{ trans('file.submit') }}</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="stock-count-report-table">
                            <thead>
                                <tr>
                                    {{-- <th>{{ trans('file.Warehouse') }}</th> --}}
                                    <th>{{ trans('file.Product') }}</th>
                                    <th>{{ trans('file.item code') }}</th>
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <th>{{ trans('file.Current Quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        {{-- <td>{{ $product->warehouse_name }}</td> --}}
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->cost }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $('#stock-count-report-table').DataTable({
            "order": [],
            "columnDefs": [{
                "targets": [0, 1, 2],
                "orderable": false
            }]
        });

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' to ' + end_date;
                $(this).val(title);
                $('input[name="start_date"]').val(start_date);
                $('input[name="end_date"]').val(end_date);
            }
        });
    </script>
@endpush
