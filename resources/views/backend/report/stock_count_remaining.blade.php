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
                        <a href="{{ route('report.stockCount') }}" class="btn btn-primary ml-auto">
                            <i class="fas fa-list"></i>
                            Stock Count
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="stock-count-report-table">
                            <thead>
                                <tr>
                                    <th>{{ trans('file.Warehouse') }}</th>
                                    <th>{{ trans('file.Product') }}</th>
                                    <th>{{ trans('file.item code') }}</th>
                                    <th>{{ trans('file.Current Quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->warehouse_name }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>{{ $product->qty }}</td>
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
                "targets": [0, 1, 2],
                "orderable": false
            }]
        });
    </script>
@endpush
