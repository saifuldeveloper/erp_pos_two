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
                    <h3 class="text-center">Stock Count Report</h3>
                </div>
                {!! Form::open(['route' => 'report.stockCount', 'method' => 'get']) !!}
                <div class="row ml-1 mt-2">
                    <div class="col-md-3">
                        @php
                            $starting_date = request()->starting_date ?? date('Y-m-d', strtotime('-1 month'));
                            $ending_date = request()->ending_date ?? date('Y-m-d');
                        @endphp
                        <div class="form-group">
                            <label><strong>{{ trans('file.Date') }}</strong></label>
                            <input type="text" class="daterangepicker-field form-control"
                                value="{{ $starting_date }} To {{ $ending_date }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}">
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}">
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
            @if (count($lims_stock_count_all) > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Brand Wise Stock Count</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $lims_stock_count_by_brand = $lims_stock_count_all->groupBy('brand_id');
                        @endphp
                        @if (count($lims_stock_count_by_brand) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Previous Quantity</th>
                                            <th>Total Price</th>
                                            <th>Updated Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lims_stock_count_by_brand as $key => $stock_count)
                                            @php
                                                $current_quantity = 0;
                                                $updated_quantity = 0;
                                                $total_before_update = 0;
                                                $total_after_update = 0;

                                                foreach ($stock_count as $stock) {
                                                    $current_quantity += $stock->items->sum('current_quantity');
                                                    $updated_quantity += $stock->items->sum('updated_quantity');
                                                    $total_before_update +=
                                                        $stock->items->sum('current_quantity') * $stock->product->price;
                                                    $total_after_update +=
                                                        $stock->items->sum('updated_quantity') * $stock->product->price;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $stock_count->first()->brand->title }}</td>
                                                <td>{{ $current_quantity }}</td>
                                                <td>{{ $total_before_update }}</td>
                                                <td>{{ $updated_quantity }}</td>
                                                <td>{{ $total_after_update }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Stock Count</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table stock-count-list">
                                @php
                                    $current_quantity = 0;
                                    $updated_quantity = 0;
                                    $total_before_update = 0;
                                    $total_after_update = 0;

                                    foreach ($lims_stock_count_all as $stock_count) {
                                        $current_quantity += $stock_count->items->sum('current_quantity');
                                        $updated_quantity += $stock_count->items->sum('updated_quantity');
                                        $total_before_update +=
                                            $stock_count->items->sum('current_quantity') * $stock_count->product->price;
                                        $total_after_update +=
                                            $stock_count->items->sum('updated_quantity') * $stock_count->product->price;
                                    }
                                @endphp
                                <tr>
                                    <th>Previous Quantity</th>
                                    <th>{{ $current_quantity }}</th>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <th>{{ $total_before_update }}</th>
                                </tr>
                                <tr>
                                    <th>Updated Quantity</th>
                                    <th>{{ $updated_quantity }}</th>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <th>{{ $total_after_update }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#report").siblings('a').attr('aria-expanded', 'true');
        $("ul#report").addClass("show");
        $("ul#report #stock-count-report-menu").addClass("active");
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
    </script>
@endpush
