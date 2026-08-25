@extends('backend.layout.main') 
@section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session()->get('not_permitted') }}
  </div>
@endif

<style>
/* Best Seller Styles for Light & Dark Mode */
.best-seller-page .card {
    border-radius: 8px;
    transition: all 0.2s ease;
}

.best-seller-page .card-header {
    background-color: transparent !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.best-seller-page .filter-label {
    font-weight: 600;
    font-size: 13px;
    color: #495057;
    margin-bottom: 4px;
}

.best-seller-page .kpi-card {
    border-radius: 8px;
    transition: transform 0.15s ease;
}

.best-seller-page .kpi-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.best-seller-page .kpi-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
}

.best-seller-page .kpi-sub {
    font-size: 12px;
    color: #6c757d;
}

.best-seller-page .header-title {
    font-weight: 700;
    color: #212529;
}

/* Dark Mode Specific Overrides */
.dark-mode .best-seller-page .card {
    background-color: #212837 !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
}

.dark-mode .best-seller-page .card-header {
    background-color: transparent !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
}

.dark-mode .best-seller-page .header-title,
.dark-mode .best-seller-page h4,
.dark-mode .best-seller-page h5,
.dark-mode .best-seller-page h6,
.dark-mode .best-seller-page .kpi-value,
.dark-mode .best-seller-page strong,
.dark-mode .best-seller-page .text-dark {
    color: #ffffff !important;
}

.dark-mode .best-seller-page .filter-label,
.dark-mode .best-seller-page .kpi-label,
.dark-mode .best-seller-page .kpi-sub,
.dark-mode .best-seller-page .text-muted,
.dark-mode .best-seller-page label {
    color: #cbd5e1 !important;
}

.dark-mode .best-seller-page .badge-light {
    background-color: #2d3748 !important;
    color: #e2e8f0 !important;
    border: 1px solid #4a5568 !important;
}

.dark-mode .best-seller-page .brand-cell {
    background-color: #2d3748 !important;
    color: #ffffff !important;
    border: 1px solid #4a5568 !important;
}

.dark-mode .best-seller-page .form-control,
.dark-mode .best-seller-page .daterangepicker-field,
.dark-mode .best-seller-page .input-group-text,
.dark-mode .best-seller-page .bootstrap-select > .btn {
    background-color: #1a202c !important;
    color: #ffffff !important;
    border-color: #3b4758 !important;
}

.dark-mode .best-seller-page .table thead th {
    background-color: #1a202c !important;
    color: #ffffff !important;
    border-bottom: 2px solid #374151 !important;
    border-top: none !important;
}

.dark-mode .best-seller-page .table td {
    color: #e2e8f0 !important;
    border-color: #2d3748 !important;
}

.dark-mode .best-seller-page .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.02) !important;
}

.dark-mode .best-seller-page .table-hover tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.06) !important;
}

.dark-mode .best-seller-page .dataTables_wrapper .dataTables_length,
.dark-mode .best-seller-page .dataTables_wrapper .dataTables_filter,
.dark-mode .best-seller-page .dataTables_wrapper .dataTables_info,
.dark-mode .best-seller-page .dataTables_wrapper .dataTables_paginate {
    color: #cbd5e1 !important;
}

.dark-mode .best-seller-page .dataTables_wrapper .dataTables_filter input,
.dark-mode .best-seller-page .dataTables_wrapper .dataTables_length select {
    background-color: #1a202c !important;
    color: #ffffff !important;
    border: 1px solid #3b4758 !important;
}

.dark-mode .best-seller-page .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #cbd5e1 !important;
}

.dark-mode .best-seller-page .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #6f42c1 !important;
    color: #ffffff !important;
    border-color: #6f42c1 !important;
}

.dark-mode .best-seller-page .dropdown-menu {
    background-color: #212837 !important;
    border: 1px solid #3b4758 !important;
}

.dark-mode .best-seller-page .dropdown-menu .dropdown-item {
    color: #e2e8f0 !important;
}

.dark-mode .best-seller-page .dropdown-menu .dropdown-item:hover,
.dark-mode .best-seller-page .dropdown-menu .dropdown-item.active {
    background-color: #2d3748 !important;
    color: #ffffff !important;
}

.dark-mode .best-seller-page .bs-searchbox input {
    background-color: #1a202c !important;
    color: #ffffff !important;
    border: 1px solid #3b4758 !important;
}
</style>

<section class="forms best-seller-page">
    <div class="container-fluid">
        <!-- Filter Card -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0 header-title"><i class="dripicons-trophy text-warning mr-2"></i> {{trans('file.Best Seller')}} {{trans('file.Reports')}}</h4>
                <div>
                    <span class="badge badge-light border px-2 py-1">{{$start_date}} &rarr; {{$end_date}}</span>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'report.bestSeller', 'method' => 'get', 'id' => 'report-form']) !!}
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="form-group mb-0">
                            <label class="filter-label">{{trans('file.Choose Your Date')}}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                </div>
                                <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                                <input type="hidden" name="start_date" value="{{$start_date}}" />
                                <input type="hidden" name="end_date" value="{{$end_date}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="form-group mb-0">
                            <label class="filter-label">{{trans('file.Choose Warehouse')}}</label>
                            <select name="warehouse_id" id="warehouse_id" class="selectpicker form-control" data-live-search="true">
                                <option value="0">{{trans('file.All Warehouse')}}</option>
                                @foreach($lims_warehouse_list as $warehouse)
                                    <option value="{{$warehouse->id}}" {{ $warehouse_id == $warehouse->id ? 'selected' : '' }}>{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="form-group mb-0">
                            <label class="filter-label">{{trans('file.Brand')}}</label>
                            <select name="brand_id" id="brand_id" class="selectpicker form-control" data-live-search="true">
                                <option value="0">{{trans('file.All Brand') ?? (trans('file.All Brands') ?? 'All Brands')}}</option>
                                @foreach($lims_brand_list as $brand)
                                    <option value="{{$brand->id}}" {{ (isset($brand_id) && $brand_id == $brand->id) ? 'selected' : '' }}>{{$brand->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2 d-flex align-items-end">
                        <button class="btn btn-primary btn-block font-weight-bold" type="submit" style="height: 38px;">
                            <i class="dripicons-search mr-1"></i> {{trans('file.submit')}}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        @php
            $total_sold_qty = $best_sellers->sum('sold_qty');
            $total_sold_amount = $best_sellers->sum('sold_amount');
            $top_product = $best_sellers->first();
            $top_brand = $brand_sales->first();
        @endphp

        <!-- Summary KPI Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card kpi-card h-100 border-0 shadow-sm" style="border-left: 4px solid #28a745 !important;">
                    <div class="card-body py-3">
                        <div class="kpi-label">{{trans('file.top')}} {{trans('file.product')}}</div>
                        <div class="h6 font-weight-bold text-truncate mt-2 mb-0" title="{{$top_product ? $top_product->product_name : 'N/A'}}">
                            {{$top_product ? $top_product->product_name : (trans('file.No Data') ?? 'No Data')}}
                        </div>
                        <small class="text-success font-weight-bold">
                            @if($top_product)
                                [{{$top_product->product_code}}] - {{number_format($top_product->sold_qty)}} {{trans('file.qty')}}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card kpi-card h-100 border-0 shadow-sm" style="border-left: 4px solid #17a2b8 !important;">
                    <div class="card-body py-3">
                        <div class="kpi-label">{{trans('file.Total')}} {{trans('file.Sold')}} ({{trans('file.qty')}})</div>
                        <div class="kpi-value text-info mt-2 mb-0">
                            {{number_format($total_sold_qty)}}
                        </div>
                        <div class="kpi-sub">{{trans('file.Items Sold') ?? 'Total Quantity'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card kpi-card h-100 border-0 shadow-sm" style="border-left: 4px solid #ffc107 !important;">
                    <div class="card-body py-3">
                        <div class="kpi-label">{{trans('file.Total')}} {{trans('file.grand total')}}</div>
                        <div class="kpi-value mt-2 mb-0">
                            {{number_format((float)$total_sold_amount, (int)($general_setting->decimal ?? 2), '.', '')}}
                        </div>
                        <div class="kpi-sub">{{trans('file.Total Revenue') ?? 'Total Sales Value'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card kpi-card h-100 border-0 shadow-sm" style="border-left: 4px solid #6f42c1 !important;">
                    <div class="card-body py-3">
                        <div class="kpi-label">{{trans('file.top')}} {{trans('file.Brand')}}</div>
                        <div class="h6 font-weight-bold text-primary mt-2 mb-0">
                            {{$top_brand ? $top_brand->brand_name : (trans('file.No Data') ?? 'N/A')}}
                        </div>
                        <div class="kpi-sub">
                            @if($top_brand)
                                {{number_format($top_brand->sold_qty)}} {{trans('file.qty')}} ({{$best_sellers->count()}} Products)
                            @else
                                {{trans('file.No Data') ?? 'N/A'}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section (Product Bar Chart + Brand Doughnut Chart) -->
        <div class="row mb-4">
            @if(count($product_chart_labels) > 0)
            <div class="col-lg-7 col-md-12 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 header-title"><i class="dripicons-graph-bar mr-2 text-primary"></i> {{trans('file.top')}} 10 {{trans('file.Best Seller')}} ({{trans('file.qty')}})</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 330px; position: relative;">
                            <canvas id="bestSellerReportChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(count($brand_chart_labels) > 0)
            <div class="{{ count($product_chart_labels) > 0 ? 'col-lg-5 col-md-12' : 'col-12' }} mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 header-title"><i class="dripicons-pie-chart mr-2 text-danger"></i> {{trans('file.Brand')}} Wise Sales Share</h5>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <div style="height: 310px; width: 100%; position: relative;">
                            <canvas id="brandDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Detailed Best Seller Data Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0 header-title mr-3"><i class="dripicons-list mr-2 text-primary"></i> {{trans('file.Product Details') ?? 'Product Details'}}</h5>
                <div class="d-flex align-items-center flex-nowrap mt-2 mt-sm-0">
                    <span class="mr-2 text-nowrap small font-weight-bold filter-label"><i class="dripicons-filter"></i> Quick Filter:</span>
                    <div style="min-width: 180px;">
                        <select id="table-brand-filter" class="form-control form-control-sm selectpicker" data-live-search="true">
                            <option value="">All Brands in Table</option>
                            @foreach($lims_brand_list as $brand)
                                <option value="{{$brand->title}}">{{$brand->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body px-3 py-3">
                <div class="table-responsive">
                    <table id="best-seller-table" class="table table-striped table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="not-exported" style="width: 30px;">#</th>
                                <th class="not-exported">{{trans('file.Image')}}</th>
                                <th>{{trans('file.name')}}</th>
                                <th>{{trans('file.Code')}}</th>
                                <th>{{trans('file.Brand')}}</th>
                                <th>{{trans('file.category')}}</th>
                                <th class="text-right">{{trans('file.Price')}}</th>
                                <th class="text-right">{{trans('file.Sold')}} {{trans('file.qty')}}</th>
                                <th class="text-right">{{trans('file.grand total')}}</th>
                                <th class="text-right">{{trans('file.In Stock')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($best_sellers as $key => $product)
                            @php
                                if(!empty($product->product_images)) {
                                    $images = explode('|', $product->product_images);
                                    $img_src = url('public/images/product', $images[0]);
                                } else {
                                    $img_src = url('public/images/product/zummXD2dvAtI.png');
                                }
                            @endphp
                            <tr>
                                <td>
                                    @if($key == 0)
                                        <span class="badge badge-warning text-white font-weight-bold" style="font-size: 12px;">🥇 1</span>
                                    @elseif($key == 1)
                                        <span class="badge badge-secondary text-white font-weight-bold" style="font-size: 12px;">🥈 2</span>
                                    @elseif($key == 2)
                                        <span class="badge badge-info text-white font-weight-bold" style="font-size: 12px;">🥉 3</span>
                                    @else
                                        <span class="badge badge-light border">{{$key + 1}}</span>
                                    @endif
                                </td>
                                <td>
                                    <img src="{{$img_src}}" height="35" width="35" class="rounded border" style="object-fit: cover;" loading="lazy" decoding="async">
                                </td>
                                <td class="font-weight-bold">
                                    {{$product->product_name}}
                                </td>
                                <td>
                                    <span class="badge badge-light border font-weight-normal">[{{$product->product_code}}]</span>
                                </td>
                                <td>
                                    <span class="badge badge-light border brand-cell">{{$product->brand_name ?? 'No Brand'}}</span>
                                </td>
                                <td>
                                    {{$product->category_name ?? 'N/A'}}
                                </td>
                                <td class="text-right">
                                    {{number_format((float)$product->product_price, (int)($general_setting->decimal ?? 2), '.', '')}}
                                </td>
                                <td class="text-right font-weight-bold text-primary">
                                    {{number_format($product->sold_qty)}}
                                </td>
                                <td class="text-right font-weight-bold text-success">
                                    {{number_format((float)$product->sold_amount, (int)($general_setting->decimal ?? 2), '.', '')}}
                                </td>
                                <td class="text-right">
                                    @if($product->in_stock > 10)
                                        <span class="badge badge-success">{{number_format($product->in_stock)}}</span>
                                    @elseif($product->in_stock > 0)
                                        <span class="badge badge-warning">{{number_format($product->in_stock)}}</span>
                                    @else
                                        <span class="badge badge-danger">{{number_format($product->in_stock)}}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="tfoot active font-weight-bold">
                            <tr>
                                <th></th>
                                <th></th>
                                <th>{{trans('file.Total')}}</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-right text-primary"></th>
                                <th class="text-right text-success"></th>
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
$(document).ready(function() {
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #best-seller-report-menu").addClass("active");

    var isDarkMode = $('body').hasClass('dark-mode');
    var chartTextColor = isDarkMode ? '#cbd5e1' : '#495057';
    var chartGridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)';

    if ($(".daterangepicker-field").length > 0) {
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
    }

    @if(count($product_chart_labels) > 0)
    // Product Bar Chart
    var ctxProduct = document.getElementById('bestSellerReportChart');
    if (ctxProduct) {
        var chartLabels = {!! json_encode($product_chart_labels) !!};
        var chartData = {!! json_encode($product_chart_qty) !!};

        new Chart(ctxProduct, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: "{{trans('file.Sold')}} {{trans('file.qty')}}",
                    data: chartData,
                    backgroundColor: 'rgba(115, 54, 134, 0.85)',
                    borderColor: '#733686',
                    borderWidth: 1,
                    hoverBackgroundColor: '#9247a8'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    labels: {
                        fontColor: chartTextColor
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1,
                            fontColor: chartTextColor
                        },
                        gridLines: {
                            color: chartGridColor,
                            zeroLineColor: chartGridColor
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 0,
                            fontColor: chartTextColor
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "{{trans('file.Sold')}} {{trans('file.qty')}}: " + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    }
    @endif

    @if(count($brand_chart_labels) > 0)
    // Brand Doughnut Chart
    var ctxBrand = document.getElementById('brandDoughnutChart');
    if (ctxBrand) {
        var brandLabels = {!! json_encode($brand_chart_labels) !!};
        var brandQty = {!! json_encode($brand_chart_qty) !!};
        var brandColors = [
            '#673ab7', // Rich Purple
            '#ff7043', // Coral Orange
            '#78867a', // Slate Grey
            '#20c997', // Teal
            '#3498db', // Blue
            '#ffc107', // Amber
            '#e83e8c', // Pink
            '#6c757d'  // Grey
        ];

        var totalBrandUnits = brandQty.reduce(function(a, b) { return a + b; }, 0);

        new Chart(ctxBrand, {
            type: 'doughnut',
            data: {
                labels: brandLabels,
                datasets: [{
                    data: brandQty,
                    backgroundColor: brandColors.slice(0, brandLabels.length),
                    borderColor: isDarkMode ? '#212837' : '#ffffff',
                    borderWidth: 2,
                    hoverBorderColor: isDarkMode ? '#212837' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 55,
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 12,
                        fontSize: 11,
                        fontColor: chartTextColor
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var currentValue = dataset.data[tooltipItem.index];
                            var currentLabel = data.labels[tooltipItem.index];
                            var percentage = totalBrandUnits > 0 ? ((currentValue / totalBrandUnits) * 100).toFixed(1) : 0;
                            return currentLabel + ': ' + currentValue + ' units (' + percentage + '%)';
                        }
                    }
                }
            }
        });
    }
    @endif

    // DataTable setup
    var table = $('#best-seller-table').DataTable({
        order: [],
        deferRender: true,
        orderClasses: false,
        pageLength: 25,
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
            "info": '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search": '{{trans("file.Search")}}',
            'paginate': {
                'previous': '<i class="dripicons-chevron-left"></i>',
                'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'excel',
                text: '<i title="export to excel" class="dripicons-document-new"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            }
        ]
    });

    // Instant Brand Filter for DataTable
    $('#table-brand-filter').on('change', function() {
        var selectedBrand = $(this).val();
        table.column(4).search(selectedBrand ? '^' + selectedBrand + '$' : '', true, false).draw();
    });
});
</script>
@endpush
