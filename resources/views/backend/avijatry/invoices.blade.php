@extends('backend.layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                @if ($invoices == 'API error')
                    <div class="card-header mt-2">
                        <h3 class="text-center"> API Connection Could Not Be Established </h3>
                    </div>
                @else
                    <div class="card-header mt-2">
                        <h3 class="text-center"> Avijatry Invoices </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="purchase-table" class="table purchase-list" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="not-exported"></th>
                                            <th>{{ trans('file.Date') }}</th>
                                            <th>{{ trans('file.Purchase Status') }}</th>
                                            <th>{{ trans('file.grand total') }}</th>
                                            <th>{{ trans('file.Paid') }}</th>
                                            <th>{{ trans('file.Due') }}</th>
                                            <th class="not-exported">{{ trans('file.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_receivable = 0;
                                            $total_payment = 0;
                                            $total_due = 0;
                                        @endphp
                                        @foreach ($invoices as $key => $invoice)
                                            <tr>
                                                <td></td>
                                                <td>{{ Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d') }}</td>
                                                <td>{{ $invoice['retail_store_status'] }}</td>
                                                <td>{{ $invoice['total_receivable'] }}</td>
                                                <td>{{ $invoice['total_payment'] }}</td>
                                                <td>{{ $invoice['total_receivable'] - $invoice['total_payment'] }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-default btn-sm dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ trans('file.action') }}
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default"
                                                            user="menu">
                                                            <li>
                                                                <a class="btn btn-link"
                                                                    href="{{ route('invoice.show', $invoice['id']) }}">
                                                                    <i class="dripicons-preview"></i>
                                                                    View
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                $total_receivable += $invoice['total_receivable'];
                                                $total_payment += $invoice['total_payment'];
                                                $total_due += $invoice['total_receivable'] - $invoice['total_payment'];
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="tfoot active">
                                        <th></th>
                                        <th>{{ trans('file.Total') }}</th>
                                        <th></th>
                                        <th>{{ $total_receivable }}</th>
                                        <th>{{ $total_payment }}</th>
                                        <th>{{ $total_due }}</th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
