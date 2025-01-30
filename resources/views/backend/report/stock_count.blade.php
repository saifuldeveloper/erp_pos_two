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
                        <div class="form-group">
                            <label><strong>{{ trans('file.Brand') }}</strong></label>
                            <select id="brand_id" name="brand_id" class="form-control selectpicker" data-live-search="true"
                                data-live-search-style="begins" title="Select Brand...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_brand_list as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $brand->id == request()->brand_id ? 'selected' : '' }}>{{ $brand->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Product') }}</strong></label>
                            <select id="product_id" name="product_id" class="form-control selectpicker"
                                data-live-search="true" data-live-search-style="begins" title="Select Product...">
                                <option value="0">{{ trans('file.All') }}</option>
                                @foreach ($lims_product_list as $product)
                                    <option {{ $product->id == request()->product_id ? 'selected' : '' }}
                                        value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
            <div class="card">
                @if (count($lims_stock_count_all) > 0)
                    <div class="table-responsive">
                        <table class="table stock-count-list">
                            @if (request()->brand_id)
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $lims_stock_count_all->first()->brand->title }}</td>
                                </tr>
                            @endif
                            @if (request()->product_id)
                                <tr>
                                    <th>Product</th>
                                    <td>{{ $lims_stock_count_all->first()->product->name }}
                                        ({{ $lims_stock_count_all->first()->product->code }})</td>
                                </tr>
                            @endif
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
                                <td>{{ $current_quantity }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>{{ $total_before_update }}</td>
                            </tr>
                            <tr>
                                <th>Updated Quantity</th>
                                <td>{{ $updated_quantity }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>{{ $total_after_update }}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#report").siblings('a').attr('aria-expanded', 'true');
        $("ul#report").addClass("show");
        $("ul#report #stock-count-report-menu").addClass("active");
        $(".selectpicker").selectpicker('refresh');
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
