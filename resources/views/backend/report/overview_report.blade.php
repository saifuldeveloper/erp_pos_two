@extends('backend.layout.main')
@section('content')

<section class="forms">
    <div class="container-fluid">
        <h3 class="text-center">{{ trans('file.Overview Report') }}</h3>
    </div>
    
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('report.overview') }}" method="GET" id="overview-filter-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>{{ trans('file.Choose Your Date') }}</strong></label>
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control" value="{{ $start_date }} To {{ $end_date }}" required autocomplete="off" />
                                    <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                    <input type="hidden" name="end_date" value="{{ $end_date }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>{{ trans('file.Stock Count') }} ID</strong></label>
                                <input type="number" name="stock_count_id" class="form-control" value="{{ $stock_count_id }}" placeholder="Stock Count ID" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Row 1: Purchase and Sale -->
        <div class="row mt-4">
            <!-- Purchase Table -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header py-2 text-center">
                        <h4 class="mb-0 font-weight-bold">{{ trans('file.Purchase') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="text-white" style="background-color: #f9785e;">
                                    <tr>
                                        <th class="text-white font-weight-bold">{{ trans('file.Supplier') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Pair') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Purchase Price') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchases_by_supplier as $p)
                                    <tr>
                                        <td class="font-weight-bold">{{ $p->supplier_name }}</td>
                                        <td>{{ number_format((float)$p->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$p->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$p->total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="font-weight-bold">
                                        <td>{{ trans('file.Total Purchase') }}</td>
                                        <td>{{ number_format((float)$purchase_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sale Table -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header py-2 text-center">
                        <h4 class="mb-0 font-weight-bold">{{ trans('file.Sale') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="text-white" style="background-color: #f9785e;">
                                    <tr>
                                        <th class="text-white font-weight-bold">{{ trans('file.Supplier') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Pair') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Purchase Price') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-weight-bold">
                                        <td>{{ trans('file.Total sale') }}</td>
                                        <td>{{ number_format((float)$sales_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Purchase Return and Sale Return -->
        <div class="row mt-2">
            <!-- Purchase Return Table -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header py-2 text-center">
                        <h4 class="mb-0 font-weight-bold">{{ trans('file.Purchase Return') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="text-white" style="background-color: #f9785e;">
                                    <tr>
                                        <th class="text-white font-weight-bold">{{ trans('file.Supplier') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Pair') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Purchase Price') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchase_returns_by_supplier as $pr)
                                    <tr>
                                        <td class="font-weight-bold">{{ $pr->supplier_name }}</td>
                                        <td>{{ number_format((float)$pr->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$pr->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$pr->total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="font-weight-bold">
                                        <td>{{ trans('file.Total') }} {{ trans('file.Purchase Return') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sale Return Table -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header py-2 text-center">
                        <h4 class="mb-0 font-weight-bold">{{ trans('file.Sale Return') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="text-white" style="background-color: #f9785e;">
                                    <tr>
                                        <th class="text-white font-weight-bold">{{ trans('file.Supplier') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Pair') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Purchase Price') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="font-weight-bold">
                                        <td>{{ trans('file.Total') }} {{ trans('file.Sale Return') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            // Intermediate calculations
            $row3_qty = $purchase_total_qty - $sales_total_qty;
            $row3_revenue = $purchase_total_selling_price - $sales_total_revenue;
            $row3_cost = $purchase_total_cost - $sales_total_cost;

            $row5_qty = $row3_qty + $sale_returns_total_qty;
            $row5_revenue = $row3_revenue + $sale_returns_total_revenue;
            $row5_cost = $row3_cost + $sale_returns_total_cost;

            $row7_qty = $row5_qty - $purchase_return_total_qty;
            $row7_revenue = $row5_revenue - $purchase_return_total_selling_price;
            $row7_cost = $row5_cost - $purchase_return_total_cost;

            $expected_qty = $row7_qty - $waste_total_qty;
            $expected_revenue = $row7_revenue - $waste_total_revenue;
            $expected_cost = $row7_cost - $waste_total_cost;
        @endphp

        <!-- Consolidated Stock Summary Table -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-2 text-center">
                        <h4 class="mb-0 font-weight-bold">{{ trans('file.Stock Summary') }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-center">
                                <thead class="text-white" style="background-color: #f9785e;">
                                    <tr>
                                        <th style="background-color: #f9785e; border: 1px solid #dee2e6;"></th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Pair') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Sale Price') }}</th>
                                        <th class="text-white font-weight-bold">{{ trans('file.Purchase Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Purchase Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Purchase') }}</td>
                                        <td>{{ number_format((float)$purchase_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Sale Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Sale') }}</td>
                                        <td>{{ number_format((float)$sales_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 3 Subtotal -->
                                    <tr class="font-weight-bold">
                                        <td class="text-left pl-3">&nbsp;</td>
                                        <td>{{ number_format((float)$row3_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row3_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row3_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Sale Return Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Sale Return') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 5 Subtotal -->
                                    <tr class="font-weight-bold">
                                        <td class="text-left pl-3">&nbsp;</td>
                                        <td>{{ number_format((float)$row5_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row5_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row5_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Purchase Return Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Purchase Return') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 7 Subtotal -->
                                    <tr class="font-weight-bold">
                                        <td class="text-left pl-3">&nbsp;</td>
                                        <td>{{ number_format((float)$row7_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row7_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row7_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Waste Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Waste') }}</td>
                                        <td>{{ number_format((float)$waste_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Expected Stock Row -->
                                    <tr class="font-weight-bold">
                                        <td class="text-left pl-3">{{ trans('file.Expected Stock') }}</td>
                                        <td>{{ number_format((float)$expected_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$expected_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$expected_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Software Stock Row (From Stock Count) -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ trans('file.Software Stock') }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_current_qty, 0, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_current_revenue, $general_setting->decimal, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_current_cost, $general_setting->decimal, '.', '') : '-' }}</td>
                                    </tr>
                                    <!-- Not Found Row (From Stock Count) -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3 text-danger">{{ trans('file.Not Found') }}</td>
                                        <td class="text-danger">{{ $stock_count_id ? number_format((float)($stock_count_current_qty - $stock_count_updated_qty), 0, '.', '') : '-' }}</td>
                                        <td class="text-danger">{{ $stock_count_id ? number_format((float)($stock_count_current_revenue - $stock_count_updated_revenue), $general_setting->decimal, '.', '') : '-' }}</td>
                                        <td class="text-danger">{{ $stock_count_id ? number_format((float)($stock_count_current_cost - $stock_count_updated_cost), $general_setting->decimal, '.', '') : '-' }}</td>
                                    </tr>
                                    <!-- Physical Stock Row (From Stock Count) -->
                                    <tr class="font-weight-bold">
                                        <td class="text-left pl-3">{{ trans('file.Physical Stock') }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_qty, 0, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_revenue, $general_setting->decimal, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_cost, $general_setting->decimal, '.', '') : '-' }}</td>
                                    </tr>
                                    <!-- Difference Row -->
                                    <tr class="font-weight-bold" style="background-color: #ff9800; color: white;">
                                        <td class="text-left pl-3">{{ trans('file.Difference') }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)($expected_qty - $stock_count_updated_qty), 0, '.', '') : '-' }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #overview-report-menu").addClass("active");

    $(".daterangepicker-field").daterangepicker({
      callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date = endDate.format('YYYY-MM-DD');
        var title = start_date + ' To ' + end_date;
        $(this).val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
      }
    });
</script>
@endpush
