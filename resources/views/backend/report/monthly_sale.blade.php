@extends('backend.layout.main')
@section('content')
<style>
    .report-link {
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .report-link:hover {
        color: green !important;
        text-decoration: underline;
    }
    .filter-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .datepicker.datepicker-dropdown {
        padding: 10px;
    }
    .summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
</style>
<section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">{{ trans('file.Monthly Sale Report') }}</h3>

                <div class="filter-card">
                    {{ Form::open(['url' => 'report/monthly_sale/' . $year, 'method' => 'post', 'id' => 'report-form']) }}
                        <input type="hidden" name="warehouse_id_hidden" value="{{ $warehouse_id }}">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-4 col-sm-6 mb-2">
                                <label class="font-weight-bold">{{ trans('file.Warehouse') }}:</label>
                                <select class="selectpicker form-control" id="warehouse_id" name="warehouse_id" data-live-search="true">
                                    <option value="0">{{ trans('file.All Warehouse') }}</option>
                                    @foreach ($lims_warehouse_list as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ $warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-2">
                                <label class="font-weight-bold">Select Year:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="year_picker" value="{{ $year }}" readonly style="background-color: #fff; cursor: pointer;">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 mb-2 mt-md-4">
                                <button type="button" id="filter-btn" class="btn btn-primary btn-block">
                                    <i class="fa fa-filter"></i> {{ trans('file.submit') }}
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
                        <thead>
                            <tr class="bg-light">
                                <th>
                                    <a href="{{ url('report/monthly_sale/' . ($year - 1)) }}" class="btn btn-outline-secondary btn-sm prev-next-link" data-year="{{ $year - 1 }}">
                                        <i class="fa fa-arrow-left"></i> {{ trans('file.Previous') }}
                                    </a>
                                </th>
                                <th colspan="10" class="text-center font-weight-bold text-uppercase" style="font-size: 1.25rem; vertical-align: middle;">
                                    {{ $year }}
                                </th>
                                <th class="text-right">
                                    <a href="{{ url('report/monthly_sale/' . ($year + 1)) }}" class="btn btn-outline-secondary btn-sm prev-next-link" data-year="{{ $year + 1 }}">
                                        {{ trans('file.Next') }} <i class="fa fa-arrow-right"></i>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center bg-light font-weight-bold">
                                <td>January</td>
                                <td>February</td>
                                <td>March</td>
                                <td>April</td>
                                <td>May</td>
                                <td>June</td>
                                <td>July</td>
                                <td>August</td>
                                <td>September</td>
                                <td>October</td>
                                <td>November</td>
                                <td>December</td>
                            </tr>
                            <tr>
                                @for ($m = 1; $m <= 12; $m++)
                                    <td>
                                        @if ((isset($grand_total[$m]) && $grand_total[$m] > 0) || (isset($total_sale[$m]) && $total_sale[$m] > 0))
                                            @php
                                                $month_padded = sprintf('%02d', $m);
                                                $total_days = cal_days_in_month(CAL_GREGORIAN, $m, $year);
                                                $start_date = $year . '-' . $month_padded . '-01';
                                                $end_date = $year . '-' . $month_padded . '-' . $total_days;
                                            @endphp

                                            <a href="{{ route('sales.index', ['starting_date' => $start_date, 'ending_date' => $end_date]) }}"
                                                target="_blank" class="report-link">

                                                {{-- Brand-wise Sales --}}
                                                @if (isset($brand_total[$m]))
                                                    @foreach ($brand_total[$m] as $brand => $b_total)
                                                        <strong>{{ $brand }} : </strong><span>{{ $b_total }}</span><br>
                                                    @endforeach
                                                @endif

                                                {{-- Total Sales --}}
                                                @if (isset($total_sale[$m]) && $total_sale[$m] > 0)
                                                    <strong>Total : </strong> <span>{{ $total_sale[$m] }}</span><br>
                                                @endif

                                                {{-- Return --}}
                                                @if (isset($total_return[$m]) && $total_return[$m] > 0)
                                                    <strong style="color:red">Return : </strong> <span>{{ $total_return[$m] }}</span><br>
                                                @endif

                                                {{-- Discount --}}
                                                @if (isset($total_discount[$m]) && $total_discount[$m] > 0)
                                                    <strong>Discount : </strong> <span>{{ $total_discount[$m] }}</span><br>
                                                @endif

                                                {{-- Grand Total --}}
                                                <strong class="text-success">{{ trans('file.grand total') }} : </strong>
                                                <span class="text-success font-weight-bold">{{ $grand_total[$m] }}</span><br>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Yearly Sale Summary Calculations --}}
                @php
                    $year_total_sale = array_sum($total_sale);
                    $year_total_return = array_sum($total_return);
                    $year_total_discount = array_sum($total_discount);
                    $year_grand_total = array_sum($grand_total);

                    $year_brand_total = [];
                    foreach ($brand_total as $m => $brands) {
                        if (is_array($brands)) {
                            foreach ($brands as $brand_name => $b_amount) {
                                if (!isset($year_brand_total[$brand_name])) {
                                    $year_brand_total[$brand_name] = 0;
                                }
                                $year_brand_total[$brand_name] += $b_amount;
                            }
                        }
                    }
                    uksort($year_brand_total, function ($a, $b) {
                        $priority = ['Avijatry' => 1, 'China' => 2];
                        return ($priority[$a] ?? 1000) <=> ($priority[$b] ?? 1000) ?: strcmp($a, $b);
                    });
                @endphp

                <div class="row mt-4 justify-content-end">
                    <div class="col-md-12">
                        <div class="summary-card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
                                <h5 class="mb-0 font-weight-bold text-dark">
                                    <i class="fa fa-calculator text-primary mr-1"></i> {{ $year }} - {{ trans('file.Summary') ?? 'Yearly Summary' }}
                                </h5>
                                <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 0.95rem;">
                                    {{ trans('file.grand total') }}: {{ number_format($year_grand_total, 2) }}
                                </span>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    {{-- Brand-wise Totals --}}
                                    @if(count($year_brand_total) > 0)
                                    <div class="col-md-6 mb-3 border-right">
                                        <h6 class="font-weight-bold text-secondary mb-2"><i class="fa fa-tags mr-1"></i> Brand-wise Sale Total:</h6>
                                        <div class="row">
                                            @foreach($year_brand_total as $b_name => $b_total)
                                                <div class="col-sm-6 mb-2">
                                                    <div class="d-flex justify-content-between p-2 rounded bg-light border">
                                                        <span class="font-weight-bold text-dark">{{ $b_name }}:</span>
                                                        <span class="font-weight-bold text-primary">{{ number_format($b_total, 2) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Financial Summary Totals --}}
                                    <div class="{{ count($year_brand_total) > 0 ? 'col-md-6' : 'col-md-12' }}">
                                        <h6 class="font-weight-bold text-secondary mb-2"><i class="fa fa-money mr-1"></i> Financial Summary:</h6>
                                        <table class="table table-sm table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light" style="width: 50%;">Total Sale:</th>
                                                    <td class="font-weight-bold text-right">{{ number_format($year_total_sale, 2) }}</td>
                                                </tr>
                                                @if($year_total_return > 0)
                                                <tr>
                                                    <th class="bg-light text-danger">Total Return:</th>
                                                    <td class="font-weight-bold text-danger text-right">- {{ number_format($year_total_return, 2) }}</td>
                                                </tr>
                                                @endif
                                                @if($year_total_discount > 0)
                                                <tr>
                                                    <th class="bg-light text-warning">Total Discount:</th>
                                                    <td class="font-weight-bold text-warning text-right">{{ number_format($year_total_discount, 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="table-success" style="font-size: 1.05rem;">
                                                    <th class="font-weight-bold text-success">{{ trans('file.grand total') }}:</th>
                                                    <td class="font-weight-bold text-success text-right">{{ number_format($year_grand_total, 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
    $("ul#report").siblings('a').attr('aria-expanded', 'true');
    $("ul#report").addClass("show");
    $("ul#report #monthly-sale-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    var currentYear = "{{ $year }}";

    $('#year_picker').datepicker({
        format: "yyyy",
        minViewMode: 2,
        autoclose: true
    }).on('changeDate', function(e) {
        if(e.date) {
            currentYear = e.date.getFullYear();
            submitMonthlySaleFilter(currentYear);
        }
    });

    function submitMonthlySaleFilter(y) {
        var selected_year = y || currentYear;
        var action_url = "{{ url('report/monthly_sale') }}/" + selected_year;
        $('#report-form').attr('action', action_url);
        $('#report-form').submit();
    }

    $('#filter-btn').on("click", function(e) {
        e.preventDefault();
        submitMonthlySaleFilter();
    });

    $('#warehouse_id').on("change", function() {
        submitMonthlySaleFilter();
    });

    $('.prev-next-link').on('click', function(e) {
        var warehouse_id = $('#warehouse_id').val();
        if(warehouse_id && warehouse_id != '0') {
            e.preventDefault();
            var y = $(this).data('year');
            submitMonthlySaleFilter(y);
        }
    });
</script>
@endpush
