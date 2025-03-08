@extends('backend.layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <h3>{{ trans('All Payment') }}</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-5">
                                <a href="{{ route('purchases.index') }}" class="btn btn-primary btn-block">
                                    Purchase Payment
                                </a>
                            </div>
                            <div class="col-md-4 mb-5">
                                <a href="{{ route('payroll.index') }}" class="btn btn-primary btn-block">
                                    Payroll Payment
                                </a>
                            </div>
                            <div class="col-md-4 mb-5">
                                <a href="{{ route('supplier.index') }}" class="btn btn-primary btn-block">
                                    Supplier Payment
                                </a>
                            </div>
                            <div class="col-md-4 mb-5">
                                <a href="{{ route('expenses.index') }}" class="btn btn-primary btn-block">
                                    Expenses Payment
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>

        </div>

    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#account").siblings('a').attr('aria-expanded', 'true');
        $("ul#account").addClass("show");
        $("ul#account #payment").addClass("active");
    </script>
@endpush
