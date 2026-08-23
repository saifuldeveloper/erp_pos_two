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

    <style>
        .stat-card {
            background: #ffffff;
            border: 1px solid #e4e7eb;
            border-radius: 8px;
            padding: 15px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 90px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .stat-card.teal { border-left: 5px solid #0891b2; }
        .stat-card.slate { border-left: 5px solid #4b5563; }
        .stat-card.indigo { border-left: 5px solid #6366f1; }
        .stat-card.green { border-left: 5px solid #10b981; }
        .stat-card.red { border-left: 5px solid #ef4444; }
        .stat-card.purple { border-left: 5px solid #8b5cf6; }

        .stat-card .title-small {
            font-size: 11px;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 4px;
            white-space: nowrap;
        }
        .stat-card .value-large {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.2;
        }
        .stat-card.teal .value-large { color: #0891b2; }
        .stat-card.slate .value-large { color: #1f2937; }
        .stat-card.indigo .value-large { color: #6366f1; }
        .stat-card.green .value-large { color: #10b981; }
        .stat-card.red .value-large { color: #ef4444; }
        .stat-card.purple .value-large { color: #8b5cf6; }

        .badge-diff-over {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .badge-diff-under {
            background-color: #fee2e2;
            color: #b91c1c;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .badge-diff-zeroed {
            background-color: #7f1d1d;
            color: #ffffff;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .badge-diff-matched {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .filter-tab-btn {
            border-radius: 20px;
            padding: 6px 16px;
            font-weight: 600;
            font-size: 13px;
            margin-right: 6px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-tab-btn.active {
            background-color: #0f172a;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* Dark Mode Styling Overrides */
        .dark-mode .stat-card {
            background-color: #283046;
            border: 1px solid #3b4253;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }
        .dark-mode .stat-card .title-small {
            color: #b4b7bd;
        }
        .dark-mode .stat-card.slate .value-large {
            color: #eaeaea;
        }
        .dark-mode .stat-card .value-large[style*="color: #4b5563"] {
            color: #eaeaea !important;
        }
        .dark-mode .stat-card.teal .value-large { color: #22d3ee; }
        .dark-mode .stat-card.indigo .value-large { color: #818cf8; }
        .dark-mode .stat-card.green .value-large { color: #4ade80; }
        .dark-mode .stat-card.red .value-large { color: #f87171; }
        .dark-mode .stat-card.purple .value-large { color: #c084fc; }

        .dark-mode .card {
            background-color: #283046;
            border: 1px solid #3b4253;
        }
        .dark-mode .card-header {
            background-color: #283046 !important;
            border-color: #3b4253 !important;
            color: #eaeaea !important;
        }
        .dark-mode .card-header h3,
        .dark-mode .card-header h5 {
            color: #eaeaea !important;
        }
        .dark-mode .bg-white {
            background-color: #283046 !important;
            color: #eaeaea !important;
        }
        .dark-mode .bg-light {
            background-color: #1e2538 !important;
            color: #eaeaea !important;
        }
        .dark-mode .text-dark {
            color: #eaeaea !important;
        }
        .dark-mode .table {
            color: #eaeaea;
        }
        .dark-mode .table thead th,
        .dark-mode .table tfoot th {
            background-color: #1e2538 !important;
            color: #eaeaea !important;
            border-color: #3b4253 !important;
        }
        .dark-mode .table tbody tr td {
            background-color: #283046 !important;
            color: #eaeaea !important;
            border-color: #3b4253 !important;
        }
        .dark-mode .table-bordered,
        .dark-mode .table-bordered th,
        .dark-mode .table-bordered td {
            border-color: #3b4253 !important;
        }
        .dark-mode .table-hover tbody tr:hover td {
            background-color: #323b54 !important;
        }
        .dark-mode .filter-tab-btn {
            background-color: #1e2538;
            color: #b4b7bd;
            border-color: #3b4253;
        }
        .dark-mode .filter-tab-btn.active {
            background-color: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        .dark-mode .badge-light {
            background-color: #1e2538;
            color: #eaeaea;
            border-color: #3b4253 !important;
        }
    </style>

    <section class="forms">
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="card mb-3">
                <div class="card-header py-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 font-weight-bold" style="color: #1e293b;">
                                <i class="fa fa-clipboard-check text-primary mr-2"></i> {{ trans('file.Stock Count Report') }}
                            </h3>
                            <small class="text-muted">সফটওয়্যার স্টক, বাস্তব গণনা ও জিরো (০) করা পণ্যের পূর্ণাঙ্গ অডিট রিপোর্ট</small>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="{{ route('report.stockCount.remaining') }}" class="btn btn-outline-primary mr-2">
                                <i class="fa fa-hourglass-half"></i> {{ trans('file.Remaining ID') }}
                            </a>
                            <a href="{{ route('stock-count.index') }}" class="btn btn-primary">
                                <i class="fa fa-list"></i> {{ trans('file.Stock Count') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body py-3">
                    {!! Form::open(['route' => 'report.stockCount', 'method' => 'get', 'id' => 'filter-form']) !!}
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold mb-1"><i class="fa fa-hashtag text-primary"></i> Stock Count Session</label>
                            <select name="countID" class="form-control selectpicker" data-live-search="true" title="Choose Stock Count...">
                                <option value="">All / Latest Count</option>
                                @foreach($lims_stock_count_list as $sc)
                                    <option value="{{ $sc->id }}" {{ $countID == $sc->id ? 'selected' : '' }}>
                                        #{{ $sc->id }} ({{ date('d-m-Y', strtotime($sc->created_at)) }}) - {{ $sc->warehouse_name ?? 'All Warehouse' }} {{ $sc->is_resolved ? '[Resolved]' : ($sc->is_completed ? '[Completed]' : '[Pending]') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold mb-1"><i class="fa fa-calendar-alt text-primary"></i> {{ trans('file.Choose Your Date') }}</label>
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control"
                                    value="{{ $start_date ? $start_date . ' To ' . $end_date : '' }}" placeholder="Select date range...">
                                <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                <input type="hidden" name="end_date" value="{{ $end_date }}" />
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label class="font-weight-bold mb-1"><i class="fa fa-warehouse text-primary"></i> {{ trans('file.Warehouse') }}</label>
                            <select name="warehouse_id" class="form-control selectpicker" data-live-search="true" title="All Warehouses">
                                <option value="all" {{ ($warehouse_id == 'all' || !$warehouse_id) ? 'selected' : '' }}>{{ trans('file.All Warehouse') }}</option>
                                @foreach($lims_warehouse_list as $wh)
                                    <option value="{{ $wh->id }}" {{ $warehouse_id == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex">
                                <button class="btn btn-primary mr-2" style="flex: 1;" type="submit">
                                    <i class="fa fa-filter"></i> {{ trans('file.submit') }}
                                </button>
                                <a href="{{ route('report.stockCount') }}" class="btn btn-secondary" style="flex: 1;">
                                    <i class="fa fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="row mb-3">
                <!-- Card 1: Teal (Total Checked ID) -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card teal">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Total Checked ID') }}</div>
                                <div class="value-large">{{ $totalProducts }}</div>
                            </div>
                            <div>
                                <div class="title-small">মোট কোড / ভ্যারিয়েন্ট</div>
                                <div class="value-large" style="color: #4b5563;">{{ $totalItems }}</div>
                            </div>
                            <div style="font-size: 28px; color: #0891b2; opacity: 0.8;">
                                <i class="fa fa-cubes"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Slate (Current System Quantity) -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card slate">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Current Quantity') }} (সফটওয়্যার)</div>
                                <div class="value-large">{{ number_format($totalCurrentQty, 0, '.', '') }}</div>
                            </div>
                            <div>
                                <div class="title-small">মোট মূল্য</div>
                                <div class="value-large" style="color: #4b5563; font-size: 17px;">{{ number_format($totalCurrentRevenue, 2, '.', '') }} ৳</div>
                            </div>
                            <div style="font-size: 28px; color: #4b5563; opacity: 0.8;">
                                <i class="fa fa-desktop"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Indigo (Counted Physical Quantity) -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card indigo">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Total Checked Pairs') }} (বাস্তব গোনা)</div>
                                <div class="value-large">{{ number_format($totalUpdatedQty, 0, '.', '') }}</div>
                            </div>
                            <div>
                                <div class="title-small">মোট মূল্য</div>
                                <div class="value-large" style="color: #4b5563; font-size: 17px;">{{ number_format($totalUpdatedRevenue, 2, '.', '') }} ৳</div>
                            </div>
                            <div style="font-size: 28px; color: #6366f1; opacity: 0.8;">
                                <i class="fa fa-barcode"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Green / Red / Purple (Difference) -->
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="stat-card {{ $totalDiffQty > 0 ? 'purple' : ($totalDiffQty < 0 ? 'red' : 'green') }}">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <div class="title-small">{{ trans('file.Difference') }} (মোট তফাৎ)</div>
                                <div class="value-large">
                                    {{ $totalDiffQty > 0 ? '+' : '' }}{{ number_format($totalDiffQty, 0, '.', '') }}
                                </div>
                            </div>
                            <div>
                                <div class="title-small">মূল্যের তফাৎ</div>
                                <div class="value-large" style="font-size: 17px;">
                                    {{ $totalDiffRevenue > 0 ? '+' : '' }}{{ number_format($totalDiffRevenue, 2, '.', '') }} ৳
                                </div>
                            </div>
                            <div style="font-size: 28px; color: {{ $totalDiffQty > 0 ? '#8b5cf6' : ($totalDiffQty < 0 ? '#ef4444' : '#10b981') }}; opacity: 0.8;">
                                <i class="fa {{ $totalDiffQty > 0 ? 'fa-arrow-circle-up' : ($totalDiffQty < 0 ? 'fa-arrow-circle-down' : 'fa-check-circle') }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Summary: Status Breakdown & Brand Summary -->
            <div class="row mb-4">
                <!-- Status Breakdown Badges (Including Zeroed Out Products) -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-2 font-weight-bold d-flex justify-content-between align-items-center">
                            <span><i class="fa fa-chart-pie text-info mr-1"></i> গণনার ফলাফল বিভাজন (Status Breakdown)</span>
                            @if($zeroedCount > 0)
                                <span class="badge badge-danger px-2 py-1"><i class="fa fa-exclamation-triangle"></i> জিরো করা পণ্য আছে</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column justify-content-around py-3">
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                <span class="text-success font-weight-bold"><i class="fa fa-check-circle"></i> সম্পূর্ণ মিল (Stock Matched):</span>
                                <span class="badge badge-success px-3 py-2" style="font-size: 13px;">{{ $matchedCount }} আইটেম ({{ number_format($matchedQty, 0) }} জোড়া)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                <span class="text-primary font-weight-bold"><i class="fa fa-plus-circle"></i> অতিরিক্ত স্টক (Over Match):</span>
                                <span class="badge badge-primary px-3 py-2" style="font-size: 13px;">{{ $overCount }} আইটেম (+{{ number_format($overQty, 0) }} জোড়া বাড়তি)</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                <span class="text-warning font-weight-bold" style="color: #d97706 !important;"><i class="fa fa-minus-circle"></i> ঘাটতি স্টক (Under Stock):</span>
                                <span class="badge badge-warning px-3 py-2" style="font-size: 13px; background-color: #f59e0b; color: #fff;">{{ $underCount - $zeroedCount }} আইটেম (-{{ number_format($underQty - $zeroedQty, 0) }} জোড়া ঘাটতি)</span>
                            </div>
                            <!-- Zeroed Out Remaining Products Row -->
                            <div class="d-flex justify-content-between align-items-center p-2 rounded" style="background-color: #fef2f2; border: 1px dashed #ef4444;">
                                <span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> না পাওয়া / স্টক ০ করা পণ্য (Zeroed Out):</span>
                                <span class="badge badge-danger px-3 py-2" style="font-size: 13px;">{{ $zeroedCount }} আইটেম (-{{ number_format($zeroedQty, 0) }} জোড়া / ক্ষতি: {{ number_format($zeroedRevenue, 2) }} ৳)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Brand-wise Summary -->
                <div class="col-md-6 mb-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-white py-2 font-weight-bold">
                            <i class="fa fa-tags text-warning mr-1"></i> ব্র্যান্ডভিত্তিক সারসংক্ষেপ (Brand-wise Overview)
                        </div>
                        <div class="card-body p-2" style="max-height: 220px; overflow-y: auto;">
                            <table class="table table-sm table-bordered text-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>{{ trans('file.Brand') }}</th>
                                        <th>সফটওয়্যার স্টক</th>
                                        <th>বাস্তব গোনা</th>
                                        <th>পার্থক্য</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($brandWiseStockCounts as $brandName => $bData)
                                    <tr>
                                        <td class="font-weight-bold text-left pl-2">{{ $brandName }}</td>
                                        <td>{{ number_format($bData['current_qty'], 0) }}</td>
                                        <td>{{ number_format($bData['updated_qty'], 0) }}</td>
                                        <td class="font-weight-bold {{ $bData['diff_qty'] > 0 ? 'text-primary' : ($bData['diff_qty'] < 0 ? 'text-danger' : 'text-success') }}">
                                            {{ $bData['diff_qty'] > 0 ? '+' : '' }}{{ number_format($bData['diff_qty'], 0) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-muted">কোনো ব্র্যান্ড ডাটা পাওয়া যায়নি</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Filter Tabs -->
            <div class="d-flex flex-wrap align-items-center mb-3">
                <span class="mr-2 font-weight-bold text-muted"><i class="fa fa-filter"></i> ফিল্টার ভিউ:</span>
                <button class="btn btn-outline-dark filter-tab-btn active" data-filter="all">
                    সবগুলো ({{ $totalItems }})
                </button>
                <button class="btn btn-outline-success filter-tab-btn" data-filter="matched">
                    সম্পূর্ণ মিল ({{ $matchedCount }})
                </button>
                <button class="btn btn-outline-primary filter-tab-btn" data-filter="over">
                    অতিরিক্ত / Over ({{ $overCount }})
                </button>
                <button class="btn btn-outline-warning filter-tab-btn" data-filter="under">
                    ঘাটতি / Under ({{ $underCount - $zeroedCount }})
                </button>
                <button class="btn btn-outline-danger filter-tab-btn" data-filter="zeroed">
                    স্টক ০ করা হয়েছে ({{ $zeroedCount }})
                </button>
            </div>

            <!-- Detailed Stock Count Report Table -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold text-dark">
                        <i class="fa fa-table text-primary mr-1"></i> বিস্তারিত পণ্য ও গোনা তালিকা
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="stock-count-report-table" style="width: 100%;">
                            <thead class="bg-light text-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('file.Date') }}</th>
                                    <th>ID</th>
                                    <th>{{ trans('file.Warehouse') }}</th>
                                    <th>{{ trans('file.Brand') }}</th>
                                    <th>{{ trans('file.Product') }}</th>
                                    <th>{{ trans('file.item code') }}</th>
                                    <th>{{ trans('file.price') }}</th>
                                    <th>{{ trans('file.Current Quantity') }} (ছিল)</th>
                                    <th>{{ trans('Update Quantity') }} (পাওয়া গেছে)</th>
                                    <th>{{ trans('file.Difference') }} (তফাৎ)</th>
                                    <th>মূল্যের তফাৎ</th>
                                    <th>অবস্থা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockCountItems as $index => $item)
                                    <tr class="text-center align-middle row-status-{{ $item->status_type }}" data-status="{{ $item->status_type }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->count_date)) }}</td>
                                        <td><span class="badge badge-secondary">#{{ $item->stock_count_id }}</span></td>
                                        <td>{{ $item->warehouse_name }}</td>
                                        <td>{{ $item->brand_name }}</td>
                                        <td class="text-left font-weight-bold">
                                            {{ $item->product_name }}
                                            @if($item->status_type === 'zeroed')
                                                <span class="badge badge-danger ml-1" style="font-size: 10px;">হারানো / ০ করা</span>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-light border">{{ $item->item_code }}</span></td>
                                        <td>{{ number_format((float)$item->unit_price, 2, '.', '') }}</td>
                                        <td class="font-weight-bold text-muted">{{ number_format((float)$item->current_quantity, 0, '.', '') }}</td>
                                        <td class="font-weight-bold text-dark">
                                            {{ number_format((float)$item->updated_quantity, 0, '.', '') }}
                                        </td>
                                        <td>
                                            @if($item->status_type === 'matched')
                                                <span class="badge-diff-matched">0 (মিল)</span>
                                            @elseif($item->status_type === 'over')
                                                <span class="badge-diff-over">+{{ number_format((float)$item->diff_quantity, 0, '.', '') }} (উদ্বৃত্ত)</span>
                                            @elseif($item->status_type === 'zeroed')
                                                <span class="badge-diff-zeroed">{{ number_format((float)$item->diff_quantity, 0, '.', '') }} (স্টক ০)</span>
                                            @else
                                                <span class="badge-diff-under">{{ number_format((float)$item->diff_quantity, 0, '.', '') }} (ঘাটতি)</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold {{ $item->diff_price > 0 ? 'text-primary' : ($item->diff_price < 0 ? 'text-danger' : 'text-success') }}">
                                            {{ $item->diff_price > 0 ? '+' : '' }}{{ number_format((float)$item->diff_price, 2, '.', '') }} ৳
                                        </td>
                                        <td>
                                            @if($item->status_type === 'matched')
                                                <span class="badge badge-success">Matched</span>
                                            @elseif($item->status_type === 'over')
                                                <span class="badge badge-primary">Over Match</span>
                                            @elseif($item->status_type === 'zeroed')
                                                <span class="badge badge-danger">Zeroed Out</span>
                                            @else
                                                <span class="badge badge-warning text-white" style="background-color: #f59e0b;">Under Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold text-center">
                                <tr>
                                    <th colspan="7" class="text-right pr-3">{{ trans('file.Total') }}:</th>
                                    <th></th>
                                    <th>{{ number_format((float)$totalCurrentQty, 0, '.', '') }}</th>
                                    <th>{{ number_format((float)$totalUpdatedQty, 0, '.', '') }}</th>
                                    <th class="{{ $totalDiffQty > 0 ? 'text-primary' : ($totalDiffQty < 0 ? 'text-danger' : 'text-success') }}">
                                        {{ $totalDiffQty > 0 ? '+' : '' }}{{ number_format((float)$totalDiffQty, 0, '.', '') }}
                                    </th>
                                    <th class="{{ $totalDiffRevenue > 0 ? 'text-primary' : ($totalDiffRevenue < 0 ? 'text-danger' : 'text-success') }}">
                                        {{ $totalDiffRevenue > 0 ? '+' : '' }}{{ number_format((float)$totalDiffRevenue, 2, '.', '') }} ৳
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        var table = $('#stock-count-report-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{ trans("file.records per page") }}',
                "info": '<small>{{ trans("file.Showing") }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans("file.Search") }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            'columnDefs': [
                {
                    "orderable": false,
                    'targets': [0]
                }
            ],
            'select': { style: 'multi', selector: 'td:first-child'},
            'pageLength': 10,
            'lengthMenu': [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]],
            dom: '<"row align-items-center mb-2"<"col-md-3"l><"col-md-5"B><"col-md-4"f>><"row"<"col-md-12"tr>><"row mt-2"<"col-md-5"i><"col-md-7"p>>',
            buttons: [
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-excel"></i> CSV',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    exportOptions: {
                        columns: ':visible:not(.not-exported)',
                        rows: ':visible'
                    }
                }
            ]
        });

        // Quick Filter Tabs (All / Matched / Over / Under / Zeroed)
        $('.filter-tab-btn').on('click', function() {
            $('.filter-tab-btn').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');
            if (filter === 'all') {
                table.column(12).search('').draw();
            } else if (filter === 'matched') {
                table.column(12).search('Matched').draw();
            } else if (filter === 'over') {
                table.column(12).search('Over Match').draw();
            } else if (filter === 'under') {
                table.column(12).search('Under Stock').draw();
            } else if (filter === 'zeroed') {
                table.column(12).search('Zeroed Out').draw();
            }
        });

        $(".daterangepicker-field").daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $(".daterangepicker-field").on('apply.daterangepicker', function(ev, picker) {
            var start_date = picker.startDate.format('YYYY-MM-DD');
            var end_date = picker.endDate.format('YYYY-MM-DD');
            $(this).val(start_date + ' To ' + end_date);
            $('input[name="start_date"]').val(start_date);
            $('input[name="end_date"]').val(end_date);
        });

        $(".daterangepicker-field").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('input[name="start_date"]').val('');
            $('input[name="end_date"]').val('');
        });
    </script>
@endpush
