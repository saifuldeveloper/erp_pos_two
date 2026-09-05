@extends('backend.layout.main')
@section('content')

<style>
    .kpi-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 12px;
        background-color: #fff;
        border: 1px solid #e2e8f0;
    }
    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .kpi-purchase { border-left: 4px solid #2563eb !important; }
    .kpi-sale { border-left: 4px solid #16a34a !important; }
    .kpi-profit { border-left: 4px solid #0891b2 !important; }
    .kpi-stock { border-left: 4px solid #ea580c !important; }

    .bg-soft-primary { background-color: #eff6ff; }
    .bg-soft-success { background-color: #f0fdf4; }
    .bg-soft-info { background-color: #ecfeff; }
    .bg-soft-warning { background-color: #fff7ed; }
    .bg-soft-danger { background-color: #fef2f2; }

    .icon-shape {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .report-card {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        background-color: #fff;
    }
    .report-card .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .report-table thead th {
        background-color: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #cbd5e1;
        padding: 10px 8px;
    }
    .report-table tbody td {
        padding: 10px 8px;
        font-size: 14px;
        vertical-align: middle;
    }
    .report-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .table-total-row,
    .table-total-row td {
        background-color: #f8fafc !important;
        font-weight: 700;
        border-top: 2px solid #cbd5e1;
    }
    .subtotal-row,
    .subtotal-row td {
        background-color: #f8fafc !important;
        color: #64748b;
        font-style: italic;
    }
    .expected-stock-row,
    .expected-stock-row td {
        background-color: #e0f2fe !important;
        color: #0369a1;
        font-size: 15px;
    }
    .stock-count-row,
    .stock-count-row td {
        background-color: #f0fdf4 !important;
        color: #166534;
        font-size: 15px;
    }
    .difference-row,
    .difference-row td {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
        color: #fff !important;
        font-size: 15px;
    }

    /* =========================================================
       DARK MODE STYLES & OVERRIDES (Seamless Theme Integration)
       ========================================================= */
    body.dark-mode .kpi-card,
    .dark-mode .kpi-card {
        background-color: #283046 !important;
        border: 1px solid #3b4253 !important;
    }
    body.dark-mode .kpi-card .text-muted,
    .dark-mode .kpi-card .text-muted {
        color: #b4b7bd !important;
    }
    body.dark-mode .kpi-card .text-muted strong,
    .dark-mode .kpi-card .text-muted strong {
        color: #eaeaea !important;
    }
    body.dark-mode .bg-soft-primary, .dark-mode .bg-soft-primary { background-color: rgba(37, 99, 235, 0.22) !important; }
    body.dark-mode .bg-soft-success, .dark-mode .bg-soft-success { background-color: rgba(22, 163, 74, 0.22) !important; }
    body.dark-mode .bg-soft-info, .dark-mode .bg-soft-info { background-color: rgba(8, 145, 178, 0.22) !important; }
    body.dark-mode .bg-soft-warning, .dark-mode .bg-soft-warning { background-color: rgba(234, 88, 12, 0.22) !important; }
    body.dark-mode .bg-soft-danger, .dark-mode .bg-soft-danger { background-color: rgba(220, 38, 38, 0.22) !important; }

    body.dark-mode .card,
    .dark-mode .card {
        background-color: #283046 !important;
        border-color: #3b4253 !important;
    }
    body.dark-mode .report-card,
    .dark-mode .report-card {
        background-color: #283046 !important;
        border: 1px solid #3b4253 !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25) !important;
    }
    body.dark-mode .report-card .card-header,
    .dark-mode .report-card .card-header {
        background-color: #1e2538 !important;
        border-bottom: 1px solid #3b4253 !important;
        color: #eaeaea !important;
    }
    body.dark-mode .report-card .card-header span,
    body.dark-mode .report-card .card-header h4,
    body.dark-mode .report-card .card-header .text-dark,
    .dark-mode .report-card .card-header span,
    .dark-mode .report-card .card-header h4,
    .dark-mode .report-card .card-header .text-dark {
        color: #eaeaea !important;
    }
    body.dark-mode .report-card .card-header .badge,
    body.dark-mode .report-card .card-header .badge-light,
    .dark-mode .report-card .card-header .badge,
    .dark-mode .report-card .card-header .badge-light {
        background-color: #283046 !important;
        color: #d0d2d6 !important;
        border: 1px solid #3b4253 !important;
    }

    body.dark-mode .stock-summary-card .card-header,
    .dark-mode .stock-summary-card .card-header {
        background-color: #1e2538 !important;
        border-bottom: 1px solid #3b4253 !important;
    }

    body.dark-mode .report-table,
    body.dark-mode .report-table tbody,
    .dark-mode .report-table,
    .dark-mode .report-table tbody {
        background-color: #283046 !important;
        color: #d0d2d6 !important;
    }
    body.dark-mode .report-table thead th,
    .dark-mode .report-table thead th {
        background-color: #343d55 !important;
        color: #f1f5f9 !important;
        border-color: #4b5563 !important;
        font-weight: 700 !important;
    }
    body.dark-mode .report-table tbody td,
    .dark-mode .report-table tbody td {
        background-color: #283046 !important;
        color: #d0d2d6 !important;
        border-color: #3b4253 !important;
    }
    body.dark-mode .report-table tbody td.text-muted,
    .dark-mode .report-table tbody td.text-muted {
        color: #82868b !important;
    }
    body.dark-mode .report-table tbody tr:hover td,
    .dark-mode .report-table tbody tr:hover td {
        background-color: #323b54 !important;
    }
    body.dark-mode .report-table.table-bordered,
    body.dark-mode .report-table.table-bordered th,
    body.dark-mode .report-table.table-bordered td,
    .dark-mode .report-table.table-bordered,
    .dark-mode .report-table.table-bordered th,
    .dark-mode .report-table.table-bordered td {
        border-color: #3b4253 !important;
    }
    body.dark-mode .table-total-row,
    body.dark-mode .table-total-row td,
    .dark-mode .table-total-row,
    .dark-mode .table-total-row td {
        background-color: #1e2538 !important;
        color: #ffffff !important;
        border-top: 2px solid #4b5563 !important;
        border-color: #3b4253 !important;
        font-weight: 700 !important;
    }
    body.dark-mode .subtotal-row,
    body.dark-mode .subtotal-row td,
    .dark-mode .subtotal-row,
    .dark-mode .subtotal-row td {
        background-color: #1a202c !important;
        color: #94a3b8 !important;
        border-color: #3b4253 !important;
        font-style: italic !important;
    }
    body.dark-mode .expected-stock-row,
    body.dark-mode .expected-stock-row td,
    .dark-mode .expected-stock-row,
    .dark-mode .expected-stock-row td {
        background-color: rgba(14, 165, 233, 0.22) !important;
        color: #38bdf8 !important;
        border-color: #0284c7 !important;
        font-weight: 700 !important;
    }
    body.dark-mode .stock-count-row,
    body.dark-mode .stock-count-row td,
    .dark-mode .stock-count-row,
    .dark-mode .stock-count-row td {
        background-color: rgba(34, 197, 94, 0.22) !important;
        color: #4ade80 !important;
        border-color: #16a34a !important;
        font-weight: 700 !important;
    }
    body.dark-mode .difference-row,
    body.dark-mode .difference-row td,
    .dark-mode .difference-row,
    .dark-mode .difference-row td {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
        color: #ffffff !important;
        border-color: #c2410c !important;
        font-weight: 700 !important;
    }
    body.dark-mode .text-dark,
    .dark-mode .text-dark {
        color: #eaeaea !important;
    }
    body.dark-mode .input-group-text,
    .dark-mode .input-group-text {
        background-color: #1e2538 !important;
        border-color: #3b4253 !important;
        color: #d0d2d6 !important;
    }
    body.dark-mode .daterangepicker-field,
    .dark-mode .daterangepicker-field {
        background-color: #283046 !important;
        border-color: #3b4253 !important;
        color: #d0d2d6 !important;
    }
    body.dark-mode .btn-outline-secondary,
    .dark-mode .btn-outline-secondary {
        border-color: #3b4253 !important;
        color: #d0d2d6 !important;
    }
    body.dark-mode .btn-outline-secondary:hover,
    .dark-mode .btn-outline-secondary:hover {
        background-color: #343d55 !important;
        color: #ffffff !important;
    }

    @media print {
        header, nav, .side-navbar, #overview-filter-form, .btn-print-wrapper, footer {
            display: none !important;
        }
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
        }
        .kpi-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

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

    $gross_profit = $sales_total_revenue - $sales_total_cost;
    $profit_margin = $sales_total_revenue > 0 ? ($gross_profit / $sales_total_revenue) * 100 : 0;
@endphp

<section class="forms">
    <!-- Header Title & Action Bar -->
    <div class="container-fluid mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h3 class="font-weight-bold text-dark mb-1">
                    <i class="fa fa-pie-chart text-primary mr-2"></i>{{ trans('file.Overview Report') }}
                </h3>
                <p class="text-muted mb-0" style="font-size: 13px;">Comprehensive business summary of Purchases, Sales, Returns, Waste, and Physical Stock Count.</p>
            </div>
            <div class="btn-print-wrapper mt-2 mt-sm-0">
                <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="window.print();">
                    <i class="fa fa-print mr-1"></i> Print Report
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="container-fluid">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-body py-3">
                <form action="{{ route('report.overview') }}" method="GET" id="overview-filter-form">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label class="small font-weight-bold text-muted mb-1">{{ trans('file.Choose Your Date') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i class="fa fa-calendar text-muted"></i></span>
                                </div>
                                <input type="text" class="daterangepicker-field form-control border-left-0" value="{{ $start_date }} To {{ $end_date }}" required autocomplete="off" />
                                <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                <input type="hidden" name="end_date" value="{{ $end_date }}" />
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="small font-weight-bold text-muted mb-1">{{ trans('file.Warehouse') }}</label>
                            <select name="warehouse_id" class="form-control selectpicker" data-live-search="true" title="Choose Warehouse...">
                                <option value="">{{ trans('file.All Warehouse') }}</option>
                                @foreach($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ ($warehouse_id == $warehouse->id) ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="small font-weight-bold text-muted mb-1">Stock Count Session</label>
                            <select name="stock_count_id" class="form-control selectpicker" data-live-search="true" title="Choose Stock Count...">
                                <option value="">All / Choose Session...</option>
                                @foreach($lims_stock_count_list as $sc)
                                    <option value="{{ $sc->id }}" {{ $stock_count_id == $sc->id ? 'selected' : '' }}>
                                        #{{ $sc->id }} ({{ date('d-m-Y', strtotime($sc->created_at)) }}) - {{ $sc->warehouse_name ?? 'All Warehouse' }} {{ $sc->is_resolved ? '[Resolved]' : ($sc->is_completed ? '[Completed]' : '[Pending]') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex">
                                <button class="btn btn-primary shadow-sm mr-2" style="flex: 1;" type="submit"><i class="fa fa-filter mr-1"></i> {{ trans('file.submit') }}</button>
                                <a href="{{ route('report.overview') }}" class="btn btn-outline-secondary" style="flex: 1;"><i class="fa fa-undo mr-1"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Top KPI Summary Cards (Commented Out) -->
    {{--
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <!-- Card 1: Total Purchase -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0 rounded-lg kpi-card kpi-purchase">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-uppercase font-weight-bold text-muted" style="font-size: 12px; letter-spacing: 0.5px;">{{ trans('file.Purchase') }}</span>
                            <div class="icon-shape bg-soft-primary text-primary rounded-circle p-2">
                                <i class="fa fa-shopping-cart fa-lg"></i>
                            </div>
                        </div>
                        <h3 class="font-weight-bold mb-1 text-primary">{{ number_format((float)$purchase_total_cost, $general_setting->decimal, '.', '') }}</h3>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span><i class="fa fa-cubes mr-1"></i>Qty: <strong>{{ number_format((float)$purchase_total_qty, 0, '.', '') }}</strong></span>
                            <span>Est. Sale: <strong>{{ number_format((float)$purchase_total_selling_price, $general_setting->decimal, '.', '') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Sale -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0 rounded-lg kpi-card kpi-sale">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-uppercase font-weight-bold text-muted" style="font-size: 12px; letter-spacing: 0.5px;">{{ trans('file.Sale') }} (Revenue)</span>
                            <div class="icon-shape bg-soft-success text-success rounded-circle p-2">
                                <i class="fa fa-line-chart fa-lg"></i>
                            </div>
                        </div>
                        <h3 class="font-weight-bold mb-1 text-success">{{ number_format((float)$sales_total_revenue, $general_setting->decimal, '.', '') }}</h3>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span><i class="fa fa-cubes mr-1"></i>Qty: <strong>{{ number_format((float)$sales_total_qty, 0, '.', '') }}</strong></span>
                            <span>COGS: <strong>{{ number_format((float)$sales_total_cost, $general_setting->decimal, '.', '') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Gross Profit -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0 rounded-lg kpi-card kpi-profit">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-uppercase font-weight-bold text-muted" style="font-size: 12px; letter-spacing: 0.5px;">Gross Profit</span>
                            <div class="icon-shape bg-soft-info text-info rounded-circle p-2">
                                <i class="fa fa-money fa-lg"></i>
                            </div>
                        </div>
                        <h3 class="font-weight-bold mb-1 {{ $gross_profit >= 0 ? 'text-info' : 'text-danger' }}">
                            {{ number_format((float)$gross_profit, $general_setting->decimal, '.', '') }}
                        </h3>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span>Margin: <strong>{{ number_format($profit_margin, 1) }}%</strong></span>
                            <span>Net Returns: <strong>{{ number_format((float)$sale_returns_total_qty, 0, '.', '') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4: Expected Stock -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card h-100 shadow-sm border-0 rounded-lg kpi-card kpi-stock">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-uppercase font-weight-bold text-muted" style="font-size: 12px; letter-spacing: 0.5px;">{{ trans('file.Expected Stock') }}</span>
                            <div class="icon-shape bg-soft-warning text-warning rounded-circle p-2">
                                <i class="fa fa-cubes fa-lg"></i>
                            </div>
                        </div>
                        <h3 class="font-weight-bold mb-1 text-warning">{{ number_format((float)$expected_qty, 0, '.', '') }} <small style="font-size: 14px;" class="text-muted">Pairs</small></h3>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 13px;">
                            <span>Cost: <strong>{{ number_format((float)$expected_cost, $general_setting->decimal, '.', '') }}</strong></span>
                            <span>Value: <strong>{{ number_format((float)$expected_revenue, $general_setting->decimal, '.', '') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}

    <div class="container-fluid">
        <!-- Row 1: Purchase and Sale -->
        <div class="row mt-4">
            <!-- Purchase Table -->
            <div class="col-md-6 mb-4">
                <div class="card report-card h-100">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <span class="font-weight-bold text-dark"><i class="fa fa-shopping-cart text-primary mr-2"></i>{{ trans('file.Purchase') }}</span>
                        <span class="badge badge-light border">{{ count($purchases_by_brand) }} Brands</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchases_by_brand as $p)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ $p->brand_name }}</td>
                                        <td>{{ number_format((float)$p->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$p->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$p->total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="table-total-row">
                                        <td class="text-left pl-3">{{ trans('file.Total Purchase') }}</td>
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
                <div class="card report-card h-100">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <span class="font-weight-bold text-dark"><i class="fa fa-line-chart text-success mr-2"></i>{{ trans('file.Sale') }}</span>
                        <span class="badge badge-light border">{{ count($sales_by_brand) }} Brands</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sales_by_brand as $s)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ $s->brand_name }}</td>
                                        <td>{{ number_format((float)$s->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$s->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$s->total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="table-total-row">
                                        <td class="text-left pl-3">{{ trans('file.Total sale') }}</td>
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

        <!-- Row 2: Purchase Return, Sale Return and Waste -->
        <div class="row mt-2">
            <!-- Purchase Return Table -->
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <span class="font-weight-bold text-dark"><i class="fa fa-reply text-warning mr-2"></i>{{ trans('file.Purchase Return') }}</span>
                        <span class="badge badge-light border">{{ count($purchase_returns_by_brand) }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchase_returns_by_brand as $pr)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ $pr->brand_name }}</td>
                                        <td>{{ number_format((float)$pr->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$pr->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$pr->total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="table-total-row">
                                        <td class="text-left pl-3">{{ trans('file.Total') }}</td>
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
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <span class="font-weight-bold text-dark"><i class="fa fa-undo text-info mr-2"></i>{{ trans('file.Sale Return') }}</span>
                        <span class="badge badge-light border">{{ count($sale_returns_by_brand) }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale_returns_by_brand as $sr)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ $sr->brand_name }}</td>
                                        <td>{{ number_format((float)$sr->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sr->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sr->total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="table-total-row">
                                        <td class="text-left pl-3">{{ trans('file.Total') }}</td>
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

            <!-- Waste Table -->
            <div class="col-md-4 mb-4">
                <div class="card report-card h-100">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <span class="font-weight-bold text-dark"><i class="fa fa-trash text-danger mr-2"></i>{{ trans('file.Waste') }}</span>
                        <span class="badge badge-light border">{{ count($wastes_by_brand) }}</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wastes_by_brand as $w)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3">{{ $w->brand_name }}</td>
                                        <td>{{ number_format((float)$w->total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$w->total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$w->total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-3">{{ trans('file.Not Found') }}</td>
                                    </tr>
                                    @endforelse
                                    <tr class="table-total-row">
                                        <td class="text-left pl-3">{{ trans('file.Total') }}</td>
                                        <td>{{ number_format((float)$waste_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_cost, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consolidated Stock Summary Table -->
        <div class="row mt-4 justify-content-center">
            <div class="col-lg-10 col-xl-9 mb-4">
                <div class="card report-card stock-summary-card shadow">
                    <div class="card-header py-3 bg-dark text-white d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-weight-bold text-white"><i class="fa fa-calculator text-warning mr-2"></i>{{ trans('file.Stock Summary') }}</h4>
                        <span class="badge badge-warning text-dark font-weight-bold px-3 py-1">Inventory Balance Movement</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table report-table table-bordered mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th class="text-left pl-3" style="width: 35%;">Category / Transaction</th>
                                        <th>{{ trans('file.Pair') }}</th>
                                        <th>{{ trans('file.Sale Price') }}</th>
                                        <th>{{ trans('file.Purchase Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Purchase Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3"><span class="badge badge-primary mr-2">+</span> {{ trans('file.Purchase') }}</td>
                                        <td>{{ number_format((float)$purchase_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Sale Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3"><span class="badge badge-secondary mr-2">-</span> {{ trans('file.Sale') }}</td>
                                        <td>{{ number_format((float)$sales_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sales_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 3 Subtotal -->
                                    <tr class="subtotal-row">
                                        <td class="text-left pl-3">Subtotal (Purchase - Sale)</td>
                                        <td>{{ number_format((float)$row3_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row3_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row3_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Sale Return Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3"><span class="badge badge-info mr-2">+</span> {{ trans('file.Sale Return') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$sale_returns_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 5 Subtotal -->
                                    <tr class="subtotal-row">
                                        <td class="text-left pl-3">Subtotal (+ Sale Return)</td>
                                        <td>{{ number_format((float)$row5_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row5_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row5_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Purchase Return Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3"><span class="badge badge-warning mr-2">-</span> {{ trans('file.Purchase Return') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_selling_price, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$purchase_return_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>
                                    <!-- Row 7 Subtotal -->
                                    <tr class="subtotal-row">
                                        <td class="text-left pl-3">Subtotal (- Purchase Return)</td>
                                        <td>{{ number_format((float)$row7_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$row7_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$row7_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>

                                    <!-- Waste Row -->
                                    <tr>
                                        <td class="font-weight-bold text-left pl-3"><span class="badge badge-danger mr-2">-</span> {{ trans('file.Waste') }}</td>
                                        <td>{{ number_format((float)$waste_total_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$waste_total_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>

                                    <!-- Expected Stock Row -->
                                    <tr class="font-weight-bold expected-stock-row">
                                        <td class="text-left pl-3"><i class="fa fa-check-circle mr-2"></i>{{ trans('file.Expected Stock') }}</td>
                                        <td>{{ number_format((float)$expected_qty, 0, '.', '') }}</td>
                                        <td>{{ number_format((float)$expected_revenue, $general_setting->decimal, '.', '') }}</td>
                                        <td>{{ number_format((float)$expected_cost, $general_setting->decimal, '.', '') }}</td>
                                    </tr>

                                    <!-- Stock Count Row (From Stock Count) -->
                                    <tr class="stock-count-row">
                                        <td class="font-weight-bold text-left pl-3">
                                            <i class="fa fa-barcode mr-2"></i>{{ trans('file.Stock Count') }}
                                            @if($stock_count_id)
                                                <span class="badge badge-success ml-1">Session #{{ $stock_count_id }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_qty, 0, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_revenue, $general_setting->decimal, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)$stock_count_updated_cost, $general_setting->decimal, '.', '') : '-' }}</td>
                                    </tr>

                                    <!-- Difference Row -->
                                    <tr class="font-weight-bold difference-row">
                                        <td class="text-left pl-3"><i class="fa fa-balance-scale mr-2"></i>{{ trans('file.Difference') }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)($expected_qty - $stock_count_updated_qty), 0, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)($expected_revenue - $stock_count_updated_revenue), $general_setting->decimal, '.', '') : '-' }}</td>
                                        <td>{{ $stock_count_id ? number_format((float)($expected_cost - $stock_count_updated_cost), $general_setting->decimal, '.', '') : '-' }}</td>
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
