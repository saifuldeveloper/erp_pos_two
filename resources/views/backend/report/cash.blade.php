@extends('backend.layout.main')
@section('content')
    <section>
        <h3 class="text-center">{{ trans('file.Cash in Hand') }}</h3>
        {!! Form::open(['route' => 'report.cashInHand', 'method' => 'post']) !!}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3 mt-4">
                    <div class="form-group">
                        <label class="d-tc mt-2"><strong>{{ trans('file.Choose Your Date') }}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control"
                                    value="{{ $start_date }} To {{ $end_date }}" required />
                                <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                <input type="hidden" name="end_date" value="{{ $end_date }}" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">{{ trans('file.submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">

                            <h3><i class="fa fa-dollar"></i> {{ trans('file.Cash in Hand') }}</h3>
                            <hr>
                            <div class="mt-3">
                                <p class="mt-2">purchase <span class="float-right">
                                        {{ number_format((float) $purchase[0]->grand_total, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                <p class="mt-2">Purchase Return <span class="float-right">
                                        {{ number_format((float) $purchase_return[0]->grand_total, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                <p class="mt-2">Sale <span class="float-right">
                                        {{ number_format((float) $sale[0]->grand_total, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                <p class="mt-2">Sale Return <span class="float-right">
                                        {{ number_format((float) $return[0]->grand_total, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                <p class="mt-2">{{ trans('file.Received') }} <span class="float-right">
                                        {{ number_format((float) $payment_recieved, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                <p class="mt-2">{{ trans('file.Sent') }} <span class="float-right">-
                                        {{ number_format((float) $payment_sent, $general_setting->decimal, '.', '') }}</span>
                                </p>
                                {{-- <p class="mt-2">{{trans('file.Sale Return')}} <span class="float-right">- {{number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Purchase Return')}} <span class="float-right"> {{number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p> --}}
                                <p class="mt-2">{{ trans('file.Expense') }} <span class="float-right">-
                                        {{ number_format((float) $expense, $general_setting->decimal, '.', '') }}</span></p>
                                <p class="mt-2">{{ trans('file.Payroll') }} <span class="float-right">-
                                        {{ number_format((float) $payroll, $general_setting->decimal, '.', '') }}</span></p>
                                <p class="mt-2">{{ trans('file.In Hand') }} <span class="float-right">






                                        {{ number_format((float) ($payment_recieved - $payment_sent - $return[0]->grand_total - $expense - $payroll), $general_setting->decimal, '.', '') }}

                                    </span></p>
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
        $("ul#report #profit-loss-report-menu").addClass("active");

        var today = moment().format('YYYY-MM-DD');
    
    $(".daterangepicker-field").daterangepicker({
        startDate: today, // Start date is today
        endDate: today,   // End date is also today
        callback: function (startDate, endDate, period) {
            var start_date = startDate.format('YYYY-MM-DD');
            var end_date = endDate.format('YYYY-MM-DD');
            var title = start_date + ' To ' + end_date;
            $(this).val(title); // Update the visible input
            $('input[name="start_date"]').val(start_date);
            $('input[name="end_date"]').val(end_date);
        }
    });

    // Pre-fill the daterangepicker input with today's date
    $(".daterangepicker-field").val(today + " To " + today);

    // Set initial values for hidden inputs
    $('input[name="start_date"]').val(today);
    $('input[name="end_date"]').val(today);
    </script>
@endpush
