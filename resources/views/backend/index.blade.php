@extends('backend.layout.main')
@section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
      @php
        if($general_setting->theme == 'default.css') {
          $color = '#733686';
          $color_rgba = 'rgba(115, 54, 134, 0.8)';
        }
        elseif($general_setting->theme == 'green.css') {
            $color = '#2ecc71';
            $color_rgba = 'rgba(46, 204, 113, 0.8)';
        }
        elseif($general_setting->theme == 'blue.css') {
            $color = '#3498db';
            $color_rgba = 'rgba(52, 152, 219, 0.8)';
        }
        elseif($general_setting->theme == 'dark.css'){
            $color = '#34495e';
            $color_rgba = 'rgba(52, 73, 94, 0.8)';
        }
      @endphp

<style>
  .best-seller-scroll {
    max-height: 440px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
  }
  .best-seller-scroll::-webkit-scrollbar {
    width: 6px;
  }
  .best-seller-scroll::-webkit-scrollbar-track {
    background: transparent;
  }
  .best-seller-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
  }
  .best-seller-scroll table thead th {
    position: sticky;
    top: 0;
    z-index: 2;
    background-color: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
  }

  /* Comprehensive Dark Mode Typography & Styling */
  @if($general_setting->theme == 'dark.css')
  body, .page, .dashboard-counts, .card, .card-header, .card-body,
  .brand-text h3, .brand-text span, h1, h2, h3, h4, h5, h6,
  table, thead th, tbody td, tfoot th, tfoot td,
  .count-title .name strong, .count-number,
  .nav-tabs .nav-link, .nav-tabs .nav-link.active,
  .badge, .table-responsive, p, span, strong {
    color: #ffffff;
  }

  .card {
    background-color: #1e2430 !important;
    border: 1px solid #2d3748 !important;
  }

  .card-header {
    background-color: #1e2430 !important;
    border-bottom: 1px solid #2d3748 !important;
  }

  .card-header h4 {
    color: #ffffff !important;
    font-weight: 600;
  }

  .table thead th {
    background-color: #262e3d !important;
    color: #ffffff !important;
    border-color: #334155 !important;
  }

  .table td, .table th {
    color: #e2e8f0 !important;
    border-color: #2d3748 !important;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.02) !important;
  }

  .table-hover tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
  }

  .best-seller-scroll table thead th {
    background-color: #262e3d !important;
    color: #ffffff !important;
  }

  .best-seller-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
  }

  .nav-tabs {
    border-bottom: 1px solid #334155 !important;
  }

  .nav-tabs .nav-link {
    color: #94a3b8 !important;
    background: transparent !important;
    border: 1px solid transparent !important;
  }

  .nav-tabs .nav-link.active {
    color: #ffffff !important;
    background-color: #262e3d !important;
    border-color: #334155 #334155 #262e3d !important;
    font-weight: 600;
  }

  .nav-tabs .nav-link:hover:not(.active) {
    color: #ffffff !important;
    border-color: transparent !important;
  }

  .badge-light {
    background-color: #334155 !important;
    color: #ffffff !important;
    border: 1px solid #475569 !important;
  }

  .count-title .name strong {
    filter: brightness(1.2);
  }
  @endif

  /* Dark mode class fallback */
  .dark-mode .card,
  .dark-mode .card-header,
  .dark-mode .card-body,
  .dark-mode table,
  .dark-mode thead th,
  .dark-mode tbody td,
  .dark-mode .card-header h4 {
    color: #ffffff !important;
  }

  .dark-mode .card {
    background-color: #1e2430 !important;
    border-color: #2d3748 !important;
  }

  .dark-mode .table thead th {
    background-color: #262e3d !important;
    color: #ffffff !important;
  }

  .dark-mode .table td {
    color: #e2e8f0 !important;
  }

  .dark-mode .nav-tabs .nav-link {
    color: #94a3b8 !important;
  }

  .dark-mode .nav-tabs .nav-link.active {
    color: #ffffff !important;
    background-color: #262e3d !important;
  }
</style>

      <div class="row">
        <div class="container-fluid">
          <div class="col-md-12">
            <div class="brand-text float-left mt-4">
                <h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span></h3>
            </div>
            @php
              $revenue_profit_summary = $role_has_permissions_list->where('name', 'revenue_profit_summary')->first();
            @endphp
            @if($revenue_profit_summary)
            <div class="filter-toggle btn-group">
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" id="customDateDropdown" style="border-radius-top-right: 0; border-radius-bottom-right: 0; " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{trans('file.Select Custom Date')}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <input type="text" id="customStartDate" name="customStartDate" class="form-control date" value="{{date('01-m-Y')}}" placeholder="Choose start date"/>
                    <input type="text" id="customEndDate" name="customEndDate" class="form-control date mt-1" value="{{date('d-m-Y')}}" placeholder="Choose end date"/>
                  <div class="dropdown-divider"></div>
                  <button class="btn btn-primary" type="button"  id="customDateFilter">{{trans('file.submit')}}</button>
                </div>
              </div>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d')}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Today')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y-m-d', strtotime(' -7 day'))}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.Last 7 Days')}}</button>
              <button class="btn btn-secondary date-btn active" data-start_date="{{date('Y').'-'.date('m').'-'.'01'}}" data-end_date="{{date('Y-m-d')}}">{{trans('file.This Month')}}</button>
              <button class="btn btn-secondary date-btn" data-start_date="{{date('Y').'-01'.'-01'}}" data-end_date="{{date('Y').'-12'.'-31'}}">{{trans('file.This Year')}}</button>
            </div>
            <input type="text" id="custom-date-range" style="display: none;">
            @endif
          </div>
        </div>
      </div>
      <!-- Counts Section -->
      <section class="dashboard-counts">
        <div class="container-fluid">
          <div class="row">
            @if($revenue_profit_summary)
            <div class="col-md-12 form-group">
              <div class="row">
               <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-users" aria-hidden="true" style="color: #ff8040"></i></div>
                    <div>
                        <div class="count-number">{{ $customers}}</div>
                        <div class="name"><strong style="color: #ff8040">{{ trans('file.total Customer') }}</strong></div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-truck" aria-hidden="true" style="color: #008080"></i></div>
                    <div>
                        <div class="count-number">{{ $suppliers }}</div>
                        <div class="name"><strong style="color: #008080">{{ trans('file.total supplier') }}</strong></div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-signal" aria-hidden="true" style="color: #733686"></i></div>
                    <div>
                        <div class="count-number revenue-data">{{number_format((float)$revenue,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #733686">{{ trans('file.total sale') }}</strong></div>
                    </div>
                  </div>
                </div>

                 <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-undo" aria-hidden="true" style="color: #ff8952"></i></div>
                    <div>
                        <div class="count-number return-data">{{number_format((float)$return,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #ff8952">{{trans('file.Sale Return')}}</strong></div>
                    </div>
                  </div>
                </div>

                 <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-shopping-cart" aria-hidden="true" style="color: #8000ff"></i></div>
                    <div>
                        <div class="count-number purchase-data">{{number_format((float)$purchase,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #8000ff">{{ trans('file.total purchase') }}</strong></div>
                    </div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-repeat" aria-hidden="true" style="color: #00c689"></i></div>
                    <div>
                        <div class="count-number purchase_return-data">{{number_format((float)$purchase_return,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #00c689">{{trans('file.Purchase Return')}}</strong></div>
                    </div>
                  </div>
                </div>
                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-money" aria-hidden="true" style="color: #008000"></i></div>
                    <div>
                        <div class="count-number sale_paid-data">{{number_format((float)$sale_paid,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #008000">{{ trans('file.total paid') }}</strong></div>
                    </div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-money" aria-hidden="true" style="color: #ff0000"></i></div>
                    <div>
                        <div class="count-number sale_due-data">{{number_format((float)$sale_due,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #ff0000">{{ trans('file.total due') }}</strong></div>
                    </div>
                  </div>
                </div>
                 <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-money" aria-hidden="true" style="color: #0080c0"></i></div>
                    <div>
                        <div class="count-number due_payement_received">{{number_format((float)$due_payment_received,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #0080c0">{{ trans('file.total due rcv') }}</strong></div>
                    </div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-cart-plus" aria-hidden="true" style="color: #008000"></i></div>
                    <div>
                        <div class="count-number purchase_paid">{{number_format((float)$purchase_paid,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #008000">{{ trans('file.total purchase paid') }}</strong></div>
                    </div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-cart-arrow-down" aria-hidden="true" style="color: #800000"></i></div>
                    <div>
                        <div class="count-number purchase_due">{{number_format((float)$purchase_due,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #800000">{{ trans('file.total purchase due') }}</strong></div>
                    </div>
                  </div>
                </div>

                <!-- Count item widget-->
                <div class="col-sm-2">
                  <div class="wrapper count-title">
                    <div class="icon"><i class="fa fa-trophy" aria-hidden="true" style="color: #297ff9"></i></div>
                    <div>
                        <div class="count-number expense-data">{{number_format((float)$expense,$general_setting->decimal, '.', '')}}</div>
                        <div class="name"><strong style="color: #297ff9">{{trans('file.total expense')}}</strong></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4 mt-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.Assets')}}</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <th>{{trans('file.item stock value')}} ({{trans('file.Cost') ?? 'Cost'}})</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$assets['total_stock_value'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.item stock value')}} ({{trans('file.Price') ?? 'Price'}})</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$assets['total_stock_price'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.receiveable customer due')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$assets['total_due'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.total accounts balance')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$assets['total_current_balance'], 2, '.', '') }}</th>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>{{trans('file.total assets')}}</th>
                          <th>:</th>
                          <th class="text-right text-success">{{ number_format((float)($assets['total_stock_value'] + $assets['total_due'] + $assets['total_current_balance']), 2, '.', '') }}</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 mt-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.Liabilities')}}</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <th>{{trans('file.supplier due')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$liability['total_due'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.customer advance')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$liability['customer_advance'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>&nbsp;</th>
                          <th></th>
                          <th class="text-right"></th>
                        </tr>
                        <tr>
                          <th>&nbsp;</th>
                          <th></th>
                          <th class="text-right"></th>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>{{trans('file.total liabilities')}}</th>
                          <th>:</th>
                          <th class="text-right text-warning">{{ number_format((float)array_sum($liability->toArray()), 2, '.', '') }}</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4 mt-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>{{trans('file.Cash In/Out')}}</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <th>{{trans('file.total cashin')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$cash['in'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.total cashout')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)$cash['out'], 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>{{trans('file.Initial Balance')}}</th>
                          <th>:</th>
                          <th class="text-right">{{ number_format((float)($cash['initial_balance'] ?? 0), 2, '.', '') }}</th>
                        </tr>
                        <tr>
                          <th>&nbsp;</th>
                          <th></th>
                          <th class="text-right"></th>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>{{trans('file.Current Balance')}}</th>
                          <th>:</th>
                          <th class="text-right text-success">{{ number_format((float)($cash['balance'] ?? ($cash['in'] - $cash['out'])), 2, '.', '') }}</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
              </div>
            </div>
            @endif
            @php
              $cash_flow = $role_has_permissions_list->where('name', 'cash_flow')->first();
            @endphp
            @if($cash_flow)
            <div class="col-md-6 mt-4">
              <div class="card line-chart-example h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Cash Flow')}}</h4>
                  <div class="right-column">
                    <span id="cashFlowPeriod" class="badge badge-primary">{{trans('file.This Month')}}</span>
                  </div>
                </div>
                <div class="card-body">
                  <div style="height: 310px; position: relative;">
                    <canvas id="cashFlow" data-color="{{$color ?? '#733686'}}" data-color_rgba="{{$color_rgba ?? 'rgba(115, 54, 134, 0.8)'}}" data-recieved="{{json_encode($payment_recieved)}}" data-sent="{{json_encode($payment_sent)}}" data-month="{{json_encode($month)}}" data-label1="{{trans('file.Payment Received') ?? trans('file.Payment Recieved')}}" data-label2="{{trans('file.Payment Sent')}}"></canvas>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <div class="col-md-6 mt-4">
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Sales vs Purchase') ?? 'Sales vs Purchase'}}</h4>
                  <div class="right-column">
                    <span id="saleChartPeriod" class="badge badge-primary">{{date("Y")}}</span>
                  </div>
                </div>
                <div class="card-body">
                  <div style="height: 310px; position: relative;">
                    <canvas id="saleChart" data-sale_chart_value = "{{json_encode($yearly_sale_amount)}}" data-purchase_chart_value = "{{json_encode($yearly_purchase_amount)}}" data-chart_labels = "{{json_encode($sale_chart_labels)}}" data-label1="{{trans('file.Purchased Amount') ?? 'Purchased Amount'}}" data-label2="{{trans('file.Sold Amount') ?? 'Sold Amount'}}"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 mt-4">
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Recent Transaction')}}</h4>
                  <div class="right-column">
                    <div class="badge badge-primary">{{trans('file.latest')}} 5</div>
                  </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#purchase-latest" role="tab" data-toggle="tab">{{trans('file.Purchase')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#quotation-latest" role="tab" data-toggle="tab">{{trans('file.Quotation')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#payment-latest" role="tab" data-toggle="tab">{{trans('file.Payment')}}</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
                      <div class="table-responsive">
                        <table id="recent-sale" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="purchase-latest">
                      <div class="table-responsive">
                        <table id="recent-purchase" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Supplier')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="quotation-latest">
                      <div class="table-responsive">
                        <table id="recent-quotation" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.customer')}}</th>
                              <th>{{trans('file.status')}}</th>
                              <th>{{trans('file.grand total')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="payment-latest">
                      <div class="table-responsive">
                        <table id="recent-payment" class="table">
                          <thead>
                            <tr>
                              <th>{{trans('file.date')}}</th>
                              <th>{{trans('file.reference')}}</th>
                              <th>{{trans('file.Amount')}}</th>
                              <th>{{trans('file.Paid By')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 mt-4">
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>{{trans('file.Best Seller')}}</h4>
                  <div class="right-column d-flex align-items-center">
                    <div class="badge badge-primary mr-2">{{trans('file.top')}} 5</div>
                    <a href="{{url('report/best_seller')}}" class="btn btn-sm btn-outline-primary" style="font-size: 12px; padding: 2px 10px; border-radius: 4px; font-weight: 500;">
                      <i class="dripicons-list"></i> {{trans('file.View All') ?? 'View All'}}
                    </a>
                  </div>
                </div>
                <div class="table-responsive best-seller-scroll">
                  <table id="best-seller-table-single" class="table table-striped table-hover mb-0">
                    <thead>
                      <tr>
                        <th>{{trans('file.Product Details')}}</th>
                        <th class="text-right">{{trans('file.qty')}}</th>
                        <th class="text-right">{{trans('file.grand total')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


@endsection

@push('scripts')
<script type="text/javascript">
    window.saleChartInstance = null;
    window.cashFlowChartInstance = null;

    function isDarkThemeActive() {
        if ('{{$general_setting->theme}}' === 'dark.css') return true;
        if ($('body').hasClass('dark-mode') || $('body').hasClass('dark') || $('html').hasClass('dark-mode')) return true;
        var customHref = $('#custom-style').attr('href');
        if (customHref && customHref.indexOf('dark.css') !== -1) return true;
        var bg = window.getComputedStyle(document.body).backgroundColor;
        if (bg) {
            var rgb = bg.match(/\d+/g);
            if (rgb && rgb.length >= 3) {
                var lum = 0.2126 * rgb[0] + 0.7152 * rgb[1] + 0.0722 * rgb[2];
                if (lum < 140) return true;
            }
        }
        return false;
    }

    function renderCashFlowChart(labels, receivedData, sentData, label1, label2) {
        var canvas = document.getElementById('cashFlow');
        if (!canvas) return;

        var isDark = isDarkThemeActive();
        var tickColor = isDark ? '#ffffff' : '#64748b';
        var legendColor = isDark ? '#ffffff' : '#334155';
        var gridColor = isDark ? 'rgba(255, 255, 255, 0.12)' : 'rgba(0, 0, 0, 0.06)';
        var zeroLineColor = isDark ? 'rgba(255, 255, 255, 0.25)' : 'rgba(0, 0, 0, 0.2)';

        if (window.cashFlowChartInstance) {
            window.cashFlowChartInstance.data.labels = labels;
            window.cashFlowChartInstance.data.datasets[0].data = receivedData;
            window.cashFlowChartInstance.data.datasets[1].data = sentData;
            if (label1) window.cashFlowChartInstance.data.datasets[0].label = label1;
            if (label2) window.cashFlowChartInstance.data.datasets[1].label = label2;
            window.cashFlowChartInstance.options.legend.labels.fontColor = legendColor;
            window.cashFlowChartInstance.options.scales.xAxes[0].ticks.fontColor = tickColor;
            window.cashFlowChartInstance.options.scales.yAxes[0].ticks.fontColor = tickColor;
            window.cashFlowChartInstance.options.scales.xAxes[0].gridLines.color = gridColor;
            window.cashFlowChartInstance.options.scales.yAxes[0].gridLines.color = gridColor;
            window.cashFlowChartInstance.update();
            return;
        }

        var brandPrimary = isDark ? '#c084fc' : ('{{$color ?? "#733686"}}');
        var brandPrimaryRgba = isDark ? 'rgba(192, 132, 252, 0.8)' : ('{{$color_rgba ?? "rgba(115, 54, 134, 0.8)"}}');

        window.cashFlowChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: label1 || '{{trans("file.Payment Received") ?? trans("file.Payment Recieved") ?? "Payment Received"}}',
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: 'transparent',
                        borderColor: brandPrimary,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 3,
                        pointBorderColor: brandPrimary,
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 5,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: brandPrimary,
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: receivedData,
                        spanGaps: false
                    },
                    {
                        label: label2 || '{{trans("file.Payment Sent") ?? "Payment Sent"}}',
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: 'transparent',
                        borderColor: "rgba(255, 137, 82, 1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 3,
                        pointBorderColor: "#ff8952",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 5,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#ff8952",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: sentData,
                        spanGaps: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        fontSize: 12,
                        fontColor: legendColor
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: tickColor,
                            fontSize: 11
                        },
                        gridLines: {
                            display: false,
                            color: gridColor,
                            zeroLineColor: zeroLineColor
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: tickColor,
                            fontSize: 11
                        },
                        gridLines: {
                            color: gridColor,
                            zeroLineColor: zeroLineColor
                        }
                    }]
                }
            }
        });
    }

    function renderSaleChart(labels, purchaseData, saleData, label1, label2) {
        var canvas = document.getElementById('saleChart');
        if (!canvas) return;

        var isDark = isDarkThemeActive();
        var tickColor = isDark ? '#ffffff' : '#64748b';
        var legendColor = isDark ? '#ffffff' : '#334155';
        var gridColor = isDark ? 'rgba(255, 255, 255, 0.12)' : 'rgba(0, 0, 0, 0.06)';
        var zeroLineColor = isDark ? 'rgba(255, 255, 255, 0.25)' : 'rgba(0, 0, 0, 0.2)';

        if (window.saleChartInstance) {
            window.saleChartInstance.data.labels = labels;
            window.saleChartInstance.data.datasets[0].data = purchaseData;
            window.saleChartInstance.data.datasets[1].data = saleData;
            if (label1) window.saleChartInstance.data.datasets[0].label = label1;
            if (label2) window.saleChartInstance.data.datasets[1].label = label2;
            window.saleChartInstance.options.legend.labels.fontColor = legendColor;
            window.saleChartInstance.options.scales.xAxes[0].ticks.fontColor = tickColor;
            window.saleChartInstance.options.scales.yAxes[0].ticks.fontColor = tickColor;
            window.saleChartInstance.options.scales.xAxes[0].gridLines.color = gridColor;
            window.saleChartInstance.options.scales.yAxes[0].gridLines.color = gridColor;
            window.saleChartInstance.update();
            return;
        }

        var brandPrimary = isDark ? '#a855f7' : ('{{$color ?? "#733686"}}');
        var brandPrimaryRgba = isDark ? 'rgba(168, 85, 247, 0.85)' : ('{{$color_rgba ?? "rgba(115, 54, 134, 0.8)"}}');

        window.saleChartInstance = new Chart(canvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: label1 || '{{trans("file.Purchased Amount") ?? "Purchased Amount"}}',
                        backgroundColor: brandPrimaryRgba,
                        borderColor: brandPrimary,
                        borderWidth: 1,
                        data: purchaseData
                    },
                    {
                        label: label2 || '{{trans("file.Sold Amount") ?? "Sold Amount"}}',
                        backgroundColor: 'rgba(255, 137, 82, 0.85)',
                        borderColor: '#ff8952',
                        borderWidth: 1,
                        data: saleData
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        fontSize: 12,
                        fontColor: legendColor
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: tickColor,
                            fontSize: 11
                        },
                        gridLines: {
                            display: false,
                            color: gridColor,
                            zeroLineColor: zeroLineColor
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: tickColor,
                            fontSize: 11
                        },
                        gridLines: {
                            color: gridColor,
                            zeroLineColor: zeroLineColor
                        }
                    }]
                }
            }
        });
    }

    $(document).ready(function() {
        var $cfElem = $('#cashFlow');
        if ($cfElem.length > 0) {
            var rVal = $cfElem.data('recieved') || [];
            var sVal = $cfElem.data('sent') || [];
            var cfLabels = $cfElem.data('month') || [];
            var l1 = $cfElem.data('label1') || '{{trans("file.Payment Received") ?? trans("file.Payment Recieved") ?? "Payment Received"}}';
            var l2 = $cfElem.data('label2') || '{{trans("file.Payment Sent") ?? "Payment Sent"}}';
            renderCashFlowChart(cfLabels, rVal, sVal, l1, l2);
        }

        var $elem = $('#saleChart');
        if ($elem.length > 0) {
            var sVal = $elem.data('sale_chart_value') || [];
            var pVal = $elem.data('purchase_chart_value') || [];
            var cLabels = $elem.data('chart_labels') || ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var l1 = $elem.data('label1') || '{{trans("file.Purchased Amount") ?? "Purchased Amount"}}';
            var l2 = $elem.data('label2') || '{{trans("file.Sold Amount") ?? "Sold Amount"}}';
            renderSaleChart(cLabels, pVal, sVal, l1, l2);
        }

        $.ajax({
            url: '{{url("/dashboard-best-seller")}}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                renderBestSellerTable(data);
            }
        });
    });

    function renderBestSellerTable(data) {
        var url = '{{url("/public/images/product")}}';
        $('#best-seller-table-single tbody').empty();
        if(!data || data.length === 0){
          $('#best-seller-table-single tbody').append('<tr><td colspan="3" class="text-center text-muted py-3">No data available for selected period</td></tr>');
        } else {
          data.forEach(function(item){
            var images = item.product_images ? item.product_images.split('|') : ['zummXD2dvAtI.png'];
            var sold_qty = item.sold_qty !== undefined ? item.sold_qty : 0;
            var sold_amount = item.sold_amount !== undefined ? parseFloat(item.sold_amount).toFixed({{$general_setting->decimal}}) : '0.00';

            $('#best-seller-table-single tbody').append(
              '<tr>' +
                '<td><img src="'+url+'/'+images[0]+'" height="25" width="30" class="mr-2 rounded"> '+item.product_name+' <span class="badge badge-light border">['+item.product_code+']</span></td>' +
                '<td class="text-right font-weight-bold text-primary">'+sold_qty+'</td>' +
                '<td class="text-right font-weight-bold text-success">'+sold_amount+'</td>' +
              '</tr>'
            );
          });
        }
    }

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-sale")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var sale_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.sale_status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Completed")}}</div>';
              } else if(item.sale_status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Pending")}}</div>';
              } else {
                var status = '<div class="badge badge-warning">{{trans("file.Draft")}}</div>';
              }
              $('#recent-sale').find('tbody').append('<tr><td>'+sale_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>'+item.grand_total+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-purchase")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var payment_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.payment_status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Completed")}}</div>';
              } else if(item.payment_status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Pending")}}</div>';
              } else {
                var status = '<div class="badge badge-warning">{{trans("file.Draft")}}</div>';
              }
              $('#recent-purchase').find('tbody').append('<tr><td>'+payment_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>'+item.grand_total+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-quotation")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var quotation_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              if(item.quotation_status == 1){
                var status = '<div class="badge badge-success">{{trans("file.Completed")}}</div>';
              } else if(item.quotation_status == 2) {
                var status = '<div class="badge badge-danger">{{trans("file.Pending")}}</div>';
              } else {
                var status = '<div class="badge badge-warning">{{trans("file.Draft")}}</div>';
              }
              $('#recent-quotation').find('tbody').append('<tr><td>'+quotation_date+'</td><td>'+item.reference_no+'</td><td>'+item.name+'</td><td>'+status+'</td><td>'+item.grand_total+'</td></tr>');
            })
        }
      });
    });

    $(document).ready(function(){
      $.ajax({
        url: '{{url("/recent-payment")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            data.forEach(function(item){
              var payment_date = dateFormat(item.created_at.split('T')[0], '{{$general_setting->date_format}}')
              $('#recent-payment').find('tbody').append('<tr><td>'+payment_date+'</td><td>'+item.payment_reference+'</td><td>'+item.amount+'</td><td>'+item.paying_method+'</td></tr>');
            })
        }
      });
    });

    function dateFormat(inputDate, format) {
        const date = new Date(inputDate);
        //extract the parts of the date
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        //replace the month
        format = format.replace("m", month.toString().padStart(2,"0"));
        //replace the year
        format = format.replace("Y", year.toString());
        //replace the day
        format = format.replace("d", day.toString().padStart(2,"0"));
        return format;
    }


    $(document).ready(function(){
      $.ajax({
        url: '{{url("/")}}',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#userShowModal').modal('show');
            $('#user-id').text(data.id);
            $('#user-name').text(data.name);
            $('#user-email').text(data.email);
        }
      });
    })
    // Show and hide color-switcher
    $(".color-switcher .switcher-button").on('click', function() {
        $(".color-switcher").toggleClass("show-color-switcher", "hide-color-switcher", 300);
    });

    // Color Skins
    $('a.color').on('click', function() {
        var newColor = $(this).data('color');
        $.get('setting/general_setting/change-theme/' + newColor, function(data) {
        });
        var style_link= $('#custom-style').attr('href').replace(/([^-]*)$/, newColor );
        $('#custom-style').attr('href', style_link);

        setTimeout(function() {
            if (window.cashFlowChartInstance) {
                var cData = window.cashFlowChartInstance.data;
                window.cashFlowChartInstance.destroy();
                window.cashFlowChartInstance = null;
                renderCashFlowChart(cData.labels, cData.datasets[0].data, cData.datasets[1].data, cData.datasets[0].label, cData.datasets[1].label);
            }
            if (window.saleChartInstance) {
                var sData = window.saleChartInstance.data;
                window.saleChartInstance.destroy();
                window.saleChartInstance = null;
                renderSaleChart(sData.labels, sData.datasets[0].data, sData.datasets[1].data, sData.datasets[0].label, sData.datasets[1].label);
            }
        }, 150);
    });

    $(".date-btn").on("click", function() {
        $(".date-btn").removeClass("active");
        $("#customDateDropdown").removeClass("active");
        $("#customDateDropdown").text('{{trans("file.Select Custom Date")}}');
        $(this).addClass("active");
        var btnText = $(this).text().trim();
        $('#saleChartPeriod').text(btnText);
        $('#cashFlowPeriod').text(btnText);
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');
        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            dashboardFilter(data);
        });
    });

    $("#customDateFilter").on("click", function() {
        $(".date-btn").removeClass("active");
        $("#customDateDropdown").addClass("active");
        var input_start_date = $("#customStartDate").val().trim();
        var input_end_date = $("#customEndDate").val().trim();
        if(input_start_date && input_end_date) {
            $('#saleChartPeriod').text(input_start_date + ' ~ ' + input_end_date);
            $('#cashFlowPeriod').text(input_start_date + ' ~ ' + input_end_date);
            $("#customDateDropdown").text(input_start_date + ' ~ ' + input_end_date);
        }

        // Close dropdown
        $('.dropdown').find('.dropdown-menu').removeClass('show');

        function formatYMD(dStr) {
            if(!dStr) return '';
            var parts = dStr.split(/[-/]/);
            if(parts.length === 3) {
                if(parts[0].length === 4) return parts[0] + '-' + parts[1] + '-' + parts[2];
                return parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            return dStr;
        }

        var start_date = formatYMD(input_start_date);
        var end_date = formatYMD(input_end_date);

        $.get('dashboard-filter/' + start_date + '/' + end_date, function(data) {
            dashboardFilter(data);
        });
    });

    function dashboardFilter(data){
        $('.revenue-data').text(parseFloat(data[0] || 0).toFixed({{$general_setting->decimal}}));
        $('.return-data').text(parseFloat(data[1] || 0).toFixed({{$general_setting->decimal}}));
        $('.profit-data').text(parseFloat(data[2] || 0).toFixed({{$general_setting->decimal}}));
        $('.purchase_return-data').text(parseFloat(data[3] || 0).toFixed({{$general_setting->decimal}}));
        $('.expense-data').text(parseFloat(data[4] || 0).toFixed({{$general_setting->decimal}}));
        $('.salary-data').text(parseFloat(data[5] || 0).toFixed({{$general_setting->decimal}}));
        $('.purchase-data').text(parseFloat(data[6] || 0).toFixed({{$general_setting->decimal}}));
        $('.sale_due-data').text(parseFloat(data[7] || 0).toFixed({{$general_setting->decimal}}));
        $('.sale_paid-data').text(parseFloat(data[8] || 0).toFixed({{$general_setting->decimal}}));
        $('.due_payement_received').text(parseFloat(data[9] || 0).toFixed({{$general_setting->decimal}}));
        $('.purchase_due').text(parseFloat(data[10] || 0).toFixed({{$general_setting->decimal}}));
        $('.purchase_paid').text(parseFloat(data[11] || 0).toFixed({{$general_setting->decimal}}));

        // Update Best Seller single unified table
        if (data[12] !== undefined) {
            renderBestSellerTable(data[12]);
        }

        // Update Sales vs Purchase dynamic bar chart
        if (data[13] !== undefined) {
            renderSaleChart(data[13].labels, data[13].purchases, data[13].sales);
        }

        // Update Cash Flow dynamic line chart
        if (data[14] !== undefined) {
            renderCashFlowChart(data[14].labels, data[14].received, data[14].sent);
        }
    }
</script>
@endpush
