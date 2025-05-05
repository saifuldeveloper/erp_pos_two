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
                        <h3 class="text-start"> {{ trans('file.Stock Count Report') }}</h3>
                        <a href="{{ route('report.stockCount.remaining') }}" class="btn btn-primary ml-auto">
                            <i class="fas fa-list"></i>
                            Remaining Products
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                {!! Form::open(['route' => 'report.stockCount', 'method' => 'get']) !!}
                <div class="row mb-3">
                    <div class="col-md-4 offset-md-1 mt-4">
                        <div class="form-group row">
                            <label class="d-tc mt-2"><strong>{{ trans('file.Choose Your Date') }}</strong> &nbsp;</label>
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
                    <div class="col-md-3 mt-4">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="row pb-3 ">
                <div class="col-md-4 mb-3">
                    <div class="wrapper count-title">
                        <div>
                            <div class="count-number"></div>
                            <div class="name"><strong style="color: #ff8040">{{ trans('Total Product') }}
                                    : {{ $stockCountItems->groupBy('product_id')->count() }}
                                </strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="wrapper count-title">
                        <div>
                            <div class="count-number"></div>
                            <div class="name"><strong style="color: #ff8040">{{ trans('Total Current Quantity') }}
                                    : {{ $stockCountItems->sum('current_quantity') }}
                                </strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="wrapper count-title">
                        <div>
                            <div class="count-number"></div>
                            <div class="name"><strong style="color: #ff8040">{{ trans('Total Update Quantity') }}
                                    :{{ $stockCountItems->sum('updated_quantity') }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="wrapper count-title">
                        <div>
                            <div class="count-number"></div>
                            <div class="name">
                                @foreach ($brandWiseStockCounts as $key => $brandWiseStockCount)
                                    @php
                                        $sumOfCurrentQuantity = array_sum(
                                            array_column($brandWiseStockCount, 'current_quantity'),
                                        );
                                        $sumOfUpdatedQuantity = array_sum(
                                            array_column($brandWiseStockCount, 'updated_quantity'),
                                        );
                                    @endphp

                                    <strong style="color: #ff8040">
                                        {{ $key }} :
                                        {{ $sumOfCurrentQuantity }} To
                                        {{ $sumOfUpdatedQuantity }}
                                    </strong><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="stock-count-report-table">
                            <thead>
                                <tr>
                                    <th>{{ trans('file.Date') }}</th>
                                    <th>{{ trans('file.Warehouse') }}</th>
                                    <th>{{ trans('file.Product') }}</th>
                                    <th>{{ trans('file.item code') }}</th>
                                    <th>{{ trans('file.Current Quantity') }}</th>
                                    <th>{{ trans('Update Quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockCountItems as $stockCountItem)
                                    <tr>
                                        <td>{{ $stockCountItem->stockCount->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $stockCountItem->stockCount->warehouse->name }}</td>
                                        <td>{{ $stockCountItem->product->name }}</td>
                                        <td>{{ $stockCountItem->item_code }}</td>
                                        <td>{{ $stockCountItem->current_quantity }}</td>
                                        <td>{{ $stockCountItem->updated_quantity }}</td>
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
                "targets": [0, 1, 2, 3, 4, 5],
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
