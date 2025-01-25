@extends('backend.layout.main')
@section('content')
<section>
    <h3 class="text-center py-5">{{trans('file.Cash in Hand')}}</h3>
    {!! Form::open(['route' => 'report.cashInHand', 'method' => 'post']) !!}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="row">
                    <div class="col-md-5">
                        <label>{{ trans('file.Start Date & Time') }}</label>
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="start_date" value="{{ $start_date }}" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label>{{ trans('file.End Date & Time') }}</label>
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="end_date" value="{{ $end_date }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">{{ trans('file.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{Form::close()}}
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">

                        <h3><i class="fa fa-dollar"></i> {{trans('file.Cash in Hand')}}</h3>
                        <hr>
                        <div class="mt-3">

                            <p class="mt-2">{{trans('file.Previous_balance')}} <span class="float-right"> {{ number_format($previous_balance_total, 2) }}</span></p>
                            <p class="mt-2">{{trans('file.purchase')}} <span class="float-right"> {{ number_format($data['purchase'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.purchase_return')}} <span class="float-right"> {{ number_format($data['purchase_return'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.sale')}}<span class="float-right"> {{ number_format($data['sale'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.Sale Return')}}<span class="float-right"> {{ number_format($data['sale_return'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.Received')}} <span class="float-right"> {{number_format($data['payment_received'], $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Sent')}} <span class="float-right">- {{number_format($data['payment_sent'], $general_setting->decimal, '.', '')}}</span></p>
                            {{-- <p class="mt-2">{{trans('file.Sale Return')}} <span class="float-right">- {{number_format((float)$return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p>
                            <p class="mt-2">{{trans('file.Purchase Return')}} <span class="float-right"> {{number_format((float)$purchase_return[0]->grand_total, $general_setting->decimal, '.', '')}}</span></p> --}}
                            <p class="mt-2">{{trans('file.Expense')}} <span class="float-right"> {{ number_format($data['expense'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.Payroll')}} <span class="float-right"> {{ number_format($data['payroll'], 2) }}</span></p>
                            <p class="mt-2">{{trans('file.In Hand')}} <span class="float-right">{{ number_format($total_current_balance, 2)
                            }}</span></p>
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
    $("ul#report #profit-loss-report-menu").addClass("active");

</script>
@endpush
