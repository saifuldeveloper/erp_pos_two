@extends('backend.layout.main')
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>{{ trans('file.Count Stock') }}</h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => 'stock-count.store',
                                'method' => 'post',
                                'files' => true,
                                'id' => 'stock-count-form',
                            ]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h2>Do you want to start stock count?</h2>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                        <a href="{{ url('/dashboard') }}" class="btn btn-danger">No</a>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
