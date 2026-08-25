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
                <h3 class="text-center mb-4">{{ trans('file.Daily Sale Report') }}</h3>

                <div class="filter-card">
                    {{ Form::open(['url' => 'report/daily_sale/' . $year . '/' . $month, 'method' => 'post', 'id' => 'report-form']) }}
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
                                <label class="font-weight-bold">Select Month & Year:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="month_picker" value="{{ date('F Y', strtotime($year . '-' . $month . '-01')) }}" readonly style="background-color: #fff; cursor: pointer;">
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
                                    <a href="{{ url('report/daily_sale/' . $prev_year . '/' . $prev_month) }}" class="btn btn-outline-secondary btn-sm prev-next-link" data-year="{{ $prev_year }}" data-month="{{ $prev_month }}">
                                        <i class="fa fa-arrow-left"></i> {{ trans('file.Previous') }}
                                    </a>
                                </th>
                                <th colspan="5" class="text-center font-weight-bold text-uppercase" style="font-size: 1.25rem; vertical-align: middle;">
                                    {{ date('F', strtotime($year . '-' . $month . '-01')) . ' ' . $year }}
                                </th>
                                <th class="text-right">
                                    <a href="{{ url('report/daily_sale/' . $next_year . '/' . $next_month) }}" class="btn btn-outline-secondary btn-sm prev-next-link" data-year="{{ $next_year }}" data-month="{{ $next_month }}">
                                        {{ trans('file.Next') }} <i class="fa fa-arrow-right"></i>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center bg-light">
                                <td><strong>Sunday</strong></td>
                                <td><strong>Monday</strong></td>
                                <td><strong>Tuesday</strong></td>
                                <td><strong>Wednesday</strong></td>
                                <td><strong>Thursday</strong></td>
                                <td><strong>Friday</strong></td>
                                <td><strong>Saturday</strong></td>
                            </tr>

                            @php
                                $i = 1;
                                $flag = 0;
                            @endphp

                            @while ($i <= $number_of_day)
                                <tr>
                                    @for ($j = 1; $j <= 7; $j++)
                                        @if ($i > $number_of_day)
                                            @break
                                        @endif

                                        @php
                                            $currentDate = $year . '-' . $month . '-' . sprintf('%02d', $i);
                                            $today = date('Y-m-d');
                                            $url = route('sales.index', ['starting_date' => $currentDate, 'ending_date' => $currentDate]);
                                        @endphp

                                        @if ($flag || $j == $start_day)
                                            <td style="{{ $currentDate == $today ? 'background-color: #f1f8ff; border: 2px solid #007bff;' : '' }}">
                                                <a href="{{ $url }}" target="_blank" class="report-link">
                                                    <p style="{{ $currentDate == $today ? 'color:#007bff; font-weight:bold;' : 'font-weight:bold;' }}">
                                                        {{ $i }}
                                                    </p>

                                                    @if (isset($brand_total[$i]))
                                                        @foreach ($brand_total[$i] as $key => $value)
                                                            <strong>{{ $key }} : </strong><span>{{ $value }}</span><br>
                                                        @endforeach
                                                    @endif

                                                    @if ($total_sale[$i])
                                                        <strong>Total : </strong><span>{{ $total_sale[$i] }}</span><br>
                                                    @endif

                                                    @if ($total_return[$i])
                                                        <strong style="color:red">Return : </strong><span>{{ $total_return[$i] }}</span><br>
                                                    @endif

                                                    @if ($total_discount[$i])
                                                        <strong>Discount : </strong><span>{{ $total_discount[$i] }}</span><br>
                                                    @endif

                                                    @if ($grand_total[$i])
                                                        <strong class="text-success">{{ trans('file.grand total') }} : </strong><span class="text-success font-weight-bold">{{ $grand_total[$i] }}</span><br>
                                                    @endif
                                                </a>
                                            </td>
                                            @php
                                                $i++;
                                                $flag = 1;
                                            @endphp
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>
                    </table>
                </div>

                {{-- Monthly Summary Calculations --}}
                @php
                    $month_total_sale = array_sum($total_sale);
                    $month_total_return = array_sum($total_return);
                    $month_total_discount = array_sum($total_discount);
                    $month_grand_total = array_sum($grand_total);

                    $month_brand_total = [];
                    foreach ($brand_total as $day => $brands) {
                        if (is_array($brands)) {
                            foreach ($brands as $brand_name => $b_amount) {
                                if (!isset($month_brand_total[$brand_name])) {
                                    $month_brand_total[$brand_name] = 0;
                                }
                                $month_brand_total[$brand_name] += $b_amount;
                            }
                        }
                    }
                    uksort($month_brand_total, function ($a, $b) {
                        $priority = ['Avijatry' => 1, 'China' => 2];
                        return ($priority[$a] ?? 1000) <=> ($priority[$b] ?? 1000) ?: strcmp($a, $b);
                    });
                @endphp

                <div class="row mt-4 justify-content-end">
                    <div class="col-md-12">
                        <div class="summary-card">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3 border-bottom">
                                <h5 class="mb-0 font-weight-bold text-dark">
                                    <i class="fa fa-calculator text-primary mr-1"></i> {{ date('F Y', strtotime($year . '-' . $month . '-01')) }} - {{ trans('file.Summary') ?? 'Monthly Summary' }}
                                </h5>
                                <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 0.95rem;">
                                    {{ trans('file.grand total') }}: {{ number_format($month_grand_total, 2) }}
                                </span>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    {{-- Brand-wise Totals --}}
                                    @if(count($month_brand_total) > 0)
                                    <div class="col-md-6 mb-3 border-right">
                                        <h6 class="font-weight-bold text-secondary mb-2"><i class="fa fa-tags mr-1"></i> Brand-wise Sale Total:</h6>
                                        <div class="row">
                                            @foreach($month_brand_total as $b_name => $b_total)
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
                                    <div class="{{ count($month_brand_total) > 0 ? 'col-md-6' : 'col-md-12' }}">
                                        <h6 class="font-weight-bold text-secondary mb-2"><i class="fa fa-money mr-1"></i> Financial Summary:</h6>
                                        <table class="table table-sm table-bordered mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="bg-light" style="width: 50%;">Total Sale:</th>
                                                    <td class="font-weight-bold text-right">{{ number_format($month_total_sale, 2) }}</td>
                                                </tr>
                                                @if($month_total_return > 0)
                                                <tr>
                                                    <th class="bg-light text-danger">Total Return:</th>
                                                    <td class="font-weight-bold text-danger text-right">- {{ number_format($month_total_return, 2) }}</td>
                                                </tr>
                                                @endif
                                                @if($month_total_discount > 0)
                                                <tr>
                                                    <th class="bg-light text-warning">Total Discount:</th>
                                                    <td class="font-weight-bold text-warning text-right">{{ number_format($month_total_discount, 2) }}</td>
                                                </tr>
                                                @endif
                                                <tr class="table-success" style="font-size: 1.05rem;">
                                                    <th class="font-weight-bold text-success">{{ trans('file.grand total') }}:</th>
                                                    <td class="font-weight-bold text-success text-right">{{ number_format($month_grand_total, 2) }}</td>
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
    // Sidebar active state
    $("ul#report").siblings('a').attr('aria-expanded', 'true');
    $("ul#report").addClass("show");
    $("ul#report #daily-sale-report-menu").addClass("active");

    // Warehouse filter logic
    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    var currentYear = "{{ $year }}";
    var currentMonth = "{{ sprintf('%02d', (int)$month) }}";

    $('#month_picker').datepicker({
        format: "MM yyyy",
        minViewMode: 1,
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function(e) {
        if(e.date) {
            currentYear = e.date.getFullYear();
            currentMonth = ('0' + (e.date.getMonth() + 1)).slice(-2);
            submitReportFilter(currentYear, currentMonth);
        }
    });

    function submitReportFilter(y, m) {
        var selected_year = y || currentYear;
        var selected_month = m || currentMonth;
        var action_url = "{{ url('report/daily_sale') }}/" + selected_year + "/" + selected_month;
        $('#report-form').attr('action', action_url);
        $('#report-form').submit();
    }

    $('#filter-btn').on("click", function(e) {
        e.preventDefault();
        submitReportFilter();
    });

    $('#warehouse_id').on("change", function() {
        submitReportFilter();
    });

    $('.prev-next-link').on('click', function(e) {
        var warehouse_id = $('#warehouse_id').val();
        if(warehouse_id && warehouse_id != '0') {
            e.preventDefault();
            var y = $(this).data('year');
            var m = $(this).data('month');
            submitReportFilter(y, m);
        }
    });
</script>
@endpush
