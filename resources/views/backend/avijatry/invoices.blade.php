@extends('backend.layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                @if ($invoices == 'API error')
                    <div class="card-header mt-2">
                        <h3 class="text-center text-danger"> API Connection Could Not Be Established </h3>
                    </div>
                @else
                    <div class="card-header mt-2">
                        <h3 class="text-center"> Avijatry Invoices </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="purchase-table" class="table purchase-list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Date') }}</th>
                                        <th>{{ trans('file.memo id') }}</th>
                                        <th>{{ trans('file.Purchase Status') }}</th>
                                        <th>{{ trans('file.grand total') }}</th>
                                        <th>{{ trans('file.commission') }}</th>
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
                                        // API theke asha main data array
                                        $invoiceList =
                                            is_array($invoices) && isset($invoices['data']) ? $invoices['data'] : [];
                                    @endphp

                                    @forelse ($invoiceList as $invoice)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($invoice['created_at'])->format('Y-m-d') }}</td>
                                            <td>
                                                {{ $invoice['id'] }}

                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $invoice['retail_store_status'] }}</span>
                                            </td>
                                            {{-- API response e total_amount ba total_receivable check korun --}}
                                            <td>{{ number_format($invoice['total_amount'] ?? 0, 2) }}</td>
                                            <td>

                                                {{ $invoice['total_commission'] }}

                                            </td>
                                            <td>{{ number_format($invoice['total_payment'] ?? 0, 2) }}</td>

                                            <td>
                                                {{ number_format(
                                                    ($invoice['total_amount'] ?? 0) - ($invoice['total_payment'] ?? 0) - $invoice['total_commission'],
                                                    2,
                                                ) }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown">
                                                        {{ trans('file.action') }} <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu edit-options dropdown-menu-right">
                                                        <li>
                                                            <a class="btn btn-link"
                                                                href="{{ route('invoice.show', $invoice['id']) }}">
                                                                <i class="dripicons-preview"></i> View
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $total_receivable += $invoice['total_amount'] ?? 0;
                                            $total_payment += $invoice['total_payment'] ?? 0;
                                            $total_due +=
                                                ($invoice['total_amount'] ?? 0) - ($invoice['total_payment'] ?? 0);
                                        @endphp
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Invoices Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="tfoot active">
                                    <tr>
                                        
                                        <th colspan="3"></th>
                                        <th>{{ number_format($total_receivable, 2) }}</th>
                                        <th></th>
                                        <th>{{ number_format($total_payment, 2) }}</th>
                                        <th>{{ number_format($total_due, 2) }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>

                            {{-- Dynamic Pagination Footer --}}
                            <div class="card-footer clearfix mt-3">
                                @if (isset($invoices['current_page']))
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $invoices['from'] }} to {{ $invoices['to'] }} of
                                            {{ $invoices['total'] }} entries
                                        </div>
                                        <ul class="pagination pagination-sm m-0">
                                            {{-- Previous Link --}}
                                            <li class="page-item {{ $invoices['current_page'] <= 1 ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ request()->fullUrlWithQuery(['page' => $invoices['current_page'] - 1]) }}">
                                                    &laquo; Previous
                                                </a>
                                            </li>

                                            {{-- Current Page --}}
                                            <li class="page-item active">
                                                <span class="page-link">Page {{ $invoices['current_page'] }} of
                                                    {{ $invoices['last_page'] }}</span>
                                            </li>

                                            {{-- Next Link --}}
                                            <li
                                                class="page-item {{ $invoices['current_page'] >= $invoices['last_page'] ? 'disabled' : '' }}">
                                                <a class="page-link"
                                                    href="{{ request()->fullUrlWithQuery(['page' => $invoices['current_page'] + 1]) }}">
                                                    Next &raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
