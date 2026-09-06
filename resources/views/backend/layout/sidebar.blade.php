@php
    $userPerms = isset($role_has_permissions_list)
        ? $role_has_permissions_list->pluck('name')->flip()->toArray()
        : [];
    $hasPerm = fn($perm) => isset($userPerms[$perm]);
    $hasAny  = fn(...$perms) => (bool) array_intersect_key(array_flip($perms), $userPerms);
    $roleId  = Auth::user()->role_id ?? 0;

    $isManagement = false;
    if (Auth::check()) {
        $user_role = \App\Models\Roles::find($roleId);
        if ($user_role && (strtolower($user_role->name) === 'management' || $user_role->id == 8)) {
            $isManagement = true;
        }
    }
@endphp

<ul id="side-main-menu" class="side-menu list-unstyled">
    <li>
        <a href="{{ url('/dashboard') }}">
            <i class="dripicons-meter"></i><span>{{ __('file.dashboard') }}</span>
        </a>
    </li>

    {{-- Product Menu --}}
    @if ($hasAny('category-index', 'category', 'products-index', 'print_barcode', 'stock_count', 'adjustment', 'brand-index', 'brand', 'unit-index', 'unit', 'color-index'))
        <li>
            <a href="#product" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-list"></i><span>{{ __('file.product') }}</span>
            </a>
            <ul id="product" class="collapse list-unstyled ">
                @if ($hasPerm('brand-index') || $hasPerm('brand'))
                    <li id="brand-menu"><a href="{{ route('brand.index') }}">{{ trans('file.Brand') }}</a></li>
                @endif
                @if ($hasPerm('unit-index') || $hasPerm('unit'))
                    <li id="unit-menu"><a href="{{ route('unit.index') }}">{{ trans('file.Unit') }}</a></li>
                @endif
                @if ($hasPerm('color-index'))
                    <li id="color-menu"><a href="{{ route('color.index') }}">{{ __('file.color') }}</a></li>
                @endif
                @if ($hasPerm('category-index') || $hasPerm('category'))
                    <li id="category-menu"><a href="{{ route('category.index') }}">{{ __('file.category') }}</a></li>
                    <li id="parent-menu"><a href="{{ route('category.parent') }}">{{ __('file.Parent Category') }}</a></li>
                @endif
                @if ($hasPerm('products-index'))
                    <li id="product-list-menu"><a href="{{ route('products.index') }}">{{ __('file.product_list') }}</a></li>
                @endif
                @if ($hasPerm('print_barcode'))
                    <li id="printBarcode-menu"><a href="{{ route('product.printBarcode') }}">{{ __('file.print_barcode') }}</a></li>
                @endif
                @if ($hasPerm('stock_count'))
                    <li id="stock-count-menu"><a href="{{ route('stock-count.create') }}">{{ trans('file.Stock Count') }}</a></li>
                @endif
                {{-- Avijatry Product --}}
                <li id="product-import-menu"><a href="{{ route('get-products') }}">{{ trans('file.Avijatry Product') }}</a></li>
            </ul>
        </li>
    @endif

    {{-- Purchase Menu --}}
    @if ($hasPerm('purchases-index'))
        <li>
            <a href="#purchase" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-card"></i><span>{{ trans('file.Purchase') }}</span>
            </a>
            <ul id="purchase" class="collapse list-unstyled ">
                <li id="purchase-list-menu"><a href="{{ route('purchases.index') }}">{{ trans('file.Purchase List') }}</a></li>
                <li id="purchase-list-menu"><a href="{{ route('invoices.index') }}">{{ trans('file.Avijatry Purchase') }}</a></li>
            </ul>
        </li>
    @endif

    {{-- Sale Menu --}}
    @if ($hasAny('sales-index', 'gift_card', 'coupon', 'delivery', 'sales-add'))
        <li>
            <a href="#sale" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-cart"></i><span>{{ trans('file.Sale') }}</span>
            </a>
            <ul id="sale" class="collapse list-unstyled ">
                @if ($hasPerm('sales-add'))
                    <li id="sale-list-menu"><a href="{{ route('sales.index') }}">{{ trans('file.Sale List') }}</a></li>
                    <li><a href="{{ route('sale.pos') }}">POS</a></li>
                    <li id="sale-create-menu"><a href="{{ route('sales.create') }}">{{ trans('file.Add Sale') }}</a></li>
                @endif
                @if ($hasPerm('coupon'))
                    <li id="coupon-menu"><a href="{{ route('coupons.index') }}">{{ trans('file.Coupon List') }}</a></li>
                @endif
                <li id="courier-menu"><a href="{{ route('couriers.index') }}">{{ trans('file.Courier List') }}</a></li>
                @if ($hasPerm('delivery'))
                    <li id="delivery-menu"><a href="{{ route('delivery.index') }}">{{ trans('file.Delivery List') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- Waste Menu --}}
    @if ($hasPerm('waste-index') || $hasPerm('waste'))
        <li id="waste-menu">
            <a href="{{ route('waste.index') }}">
                <i class="dripicons-trash"></i><span>{{ trans('file.Waste') }}</span>
            </a>
        </li>
    @endif

    {{-- Expense Menu --}}
    @if ($hasPerm('expenses-index'))
        <li>
            <a href="#expense" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-wallet"></i><span>{{ trans('file.Expense') }}</span>
            </a>
            <ul id="expense" class="collapse list-unstyled ">
                <li id="exp-cat-menu"><a href="{{ route('expense_categories.index') }}">{{ trans('file.Expense Category') }}</a></li>
                <li id="exp-list-menu"><a href="{{ route('expenses.index') }}">{{ trans('file.Expense List') }}</a></li>
            </ul>
        </li>
    @endif

    {{-- Quotation Menu --}}
    @if ($hasPerm('quotes-index'))
        <li>
            <a href="#quotation" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-document"></i><span>{{ trans('file.Quotation') }}</span>
            </a>
            <ul id="quotation" class="collapse list-unstyled ">
                <li id="quotation-list-menu"><a href="{{ route('quotations.index') }}">{{ trans('file.Quotation List') }}</a></li>
            </ul>
        </li>
    @endif

    {{-- Transfer Menu --}}
    @if ($hasPerm('transfers-index'))
        <li>
            <a href="#transfer" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-export"></i><span>{{ trans('file.Transfer') }}</span>
            </a>
            <ul id="transfer" class="collapse list-unstyled ">
                <li id="transfer-list-menu"><a href="{{ route('transfers.index') }}">{{ trans('file.Transfer List') }}</a></li>
            </ul>
        </li>
    @endif

    {{-- Return Menu --}}
    @if ($hasPerm('returns-index') || $hasPerm('purchase-return-index'))
        <li>
            <a href="#return" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-return"></i><span>{{ trans('file.return') }}</span>
            </a>
            <ul id="return" class="collapse list-unstyled ">
                @if ($hasPerm('returns-index'))
                    <li id="sale-return-menu"><a href="{{ route('return-sale.index') }}">{{ trans('file.Sale') }}</a></li>
                @endif
                @if ($hasPerm('purchase-return-index'))
                    <li id="purchase-return-menu"><a href="{{ route('return-purchase.index') }}">{{ trans('file.Purchase') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- Accounting Menu --}}
    @if ($hasAny('account-index', 'balance-sheet', 'account-statement', 'money-transfer'))
        <li>
            <a href="#account" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-briefcase"></i><span>{{ trans('file.Accounting') }}</span>
            </a>
            <ul id="account" class="collapse list-unstyled ">
                @if ($hasPerm('account-index'))
                    <li id="account-list-menu"><a href="{{ route('accounts.index') }}">{{ trans('file.Account List') }}</a></li>
                @endif
                @if ($hasPerm('money-transfer'))
                    <li id="money-transfer-menu"><a href="{{ route('money-transfers.index') }}">{{ trans('file.Money Transfer') }}</a></li>
                @endif
                @if ($hasPerm('balance-sheet'))
                    <li id="balance-sheet-menu"><a href="{{ route('accounts.balancesheet') }}">{{ trans('file.Balance Sheet') }}</a></li>
                @endif
                @if ($hasPerm('account-statement'))
                    <li id="account-statement-menu"><a id="account-statement" href="">{{ trans('file.Account Statement') }}</a></li>
                @endif
                <li id="payment">
                    <a id="account-payment" href="{{ route('account.payment') }}">Payment</a>
                </li>
            </ul>
        </li>
    @endif

    {{-- HRM Menu --}}
    @if ($hasAny('department-index', 'department', 'employees-index', 'attendance', 'payroll-index', 'payroll', 'payroll-type-index', 'holiday'))
        <li>
            <a href="#hrm" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-user-group"></i><span>HRM</span>
            </a>
            <ul id="hrm" class="collapse list-unstyled ">
                @if ($hasPerm('department-index') || $hasPerm('department'))
                    <li id="dept-menu"><a href="{{ route('departments.index') }}">{{ trans('file.Department') }}</a></li>
                @endif
                @if ($hasPerm('employees-index'))
                    <li id="employee-menu"><a href="{{ route('employees.index') }}">{{ trans('file.Employee') }}</a></li>
                @endif
                @if ($hasPerm('payroll-index') || $hasPerm('payroll'))
                    <li id="payroll-menu"><a href="{{ route('payroll.index') }}">{{ trans('file.Payroll') }}</a></li>
                @endif
                @if ($hasPerm('payroll-type-index') || $hasPerm('payroll'))
                    <li id="payroll-type-menu"><a href="{{ route('payroll-types.index') }}">{{ trans('file.Payroll Type') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- People / User Menu --}}
    @if ($hasAny('users-index', 'customers-index', 'billers-index', 'suppliers-index', 'role-permission') || $isManagement || $roleId <= 2)
        <li>
            <a href="#people" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-user"></i><span>{{ trans('file.User') }}</span>
            </a>
            <ul id="people" class="collapse list-unstyled ">
                @if ($hasPerm('users-index'))
                    <li id="user-list-menu"><a href="{{ route('user.index') }}">{{ trans('file.User List') }}</a></li>
                @endif

                @if ($roleId <= 2 || $hasPerm('role-permission') || $isManagement)
                    <li id="role-permission-menu"><a href="{{ route('role.index') }}">{{ trans('file.Role Permission') }}</a></li>
                @endif

                @if ($hasPerm('customers-index'))
                    <li id="customer-list-menu"><a href="{{ route('customer.index') }}">{{ trans('file.Customer List') }}</a></li>
                @endif

                @if ($hasPerm('billers-index'))
                    <li id="biller-list-menu"><a href="{{ route('biller.index') }}">{{ trans('file.Biller List') }}</a></li>
                @endif

                @if ($hasPerm('suppliers-index'))
                    <li id="supplier-list-menu"><a href="{{ route('supplier.index') }}">{{ trans('file.Supplier List') }}</a></li>
                @endif
            </ul>
        </li>
    @endif

    {{-- Reports Menu --}}
    @if ($hasAny('profit-loss', 'best-seller', 'warehouse-report', 'warehouse-stock-report', 'product-report', 'daily-sale', 'monthly-sale', 'daily-purchase', 'monthly-purchase', 'purchase-report', 'sale-report', 'sale-report-chart', 'payment-report', 'product-expiry-report', 'product-qty-alert', 'dso-report', 'user-report', 'customer-report', 'supplier-report', 'due-report', 'supplier-due-report', 'salary-report', 'stock-count-report'))
        <li>
            <a href="#report" aria-expanded="false" data-toggle="collapse">
                <i class="dripicons-document-remove"></i><span>{{ trans('file.Reports') }}</span>
            </a>
            <ul id="report" class="collapse list-unstyled ">
                <li id="profit-loss-report-menu">
                    {!! Form::open(['route' => 'report.cashInHand', 'method' => 'post', 'id' => 'profitLoss-report-form']) !!}
                    <input type="hidden" name="start_date" value="{{ date('Y-m') . '-01' }}" />
                    <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                    <a id="profitLoss-link" href="">{{ trans('file.Cash in Hand') }}</a>
                    {!! Form::close() !!}
                </li>
                @if ($hasPerm('product-report'))
                    <li id="product-report-menu">
                        {!! Form::open(['route' => 'report.product', 'method' => 'get', 'id' => 'product-report-form']) !!}
                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                        <input type="hidden" name="warehouse_id" value="0" />
                        <a id="report-link" href="">{{ trans('file.Product Report') }}</a>
                        {!! Form::close() !!}
                    </li>
                @endif
                @if ($hasPerm('daily-sale'))
                    <li id="daily-sale-report-menu">
                        <a href="{{ url('report/daily_sale/' . date('Y') . '/' . date('m')) }}">{{ trans('file.Daily Sale') }}</a>
                    </li>
                @endif
                @if ($hasPerm('monthly-sale'))
                    <li id="monthly-sale-report-menu">
                        <a href="{{ url('report/monthly_sale/' . date('Y')) }}">{{ trans('file.Monthly Sale') }}</a>
                    </li>
                @endif
                @if ($hasPerm('daily-purchase'))
                    <li id="daily-purchase-report-menu">
                        <a href="{{ url('report/daily_purchase/' . date('Y') . '/' . date('m')) }}">{{ trans('file.Daily Purchase') }}</a>
                    </li>
                @endif
                @if ($hasPerm('monthly-purchase'))
                    <li id="monthly-purchase-report-menu">
                        <a href="{{ url('report/monthly_purchase/' . date('Y')) }}">{{ trans('file.Monthly Purchase') }}</a>
                    </li>
                @endif
                <li id="exp-report-menu">
                    <a href="{{ route('report.expense') }}">{{ trans('file.Expense Report') }}</a>
                </li>
                @if ($hasPerm('salary-report'))
                    <li id="salary-report-menu">
                        <a href="{{ route('report.salary') }}">Salary Report</a>
                    </li>
                @endif
                @if ($hasPerm('payment-report'))
                    <li id="payment-report-menu">
                        {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post', 'id' => 'payment-report-form']) !!}
                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                        <a id="payment-report-link" href="">{{ trans('file.Payment Report') }}</a>
                        {!! Form::close() !!}
                    </li>
                @endif
                @if ($hasPerm('purchase-report'))
                    <li id="purchase-report-menu">
                        {!! Form::open(['route' => 'report.purchase', 'method' => 'post', 'id' => 'purchase-report-form']) !!}
                        <input type="hidden" name="start_date" value="{{ date('Y-m') . '-01' }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                        <input type="hidden" name="warehouse_id" value="0" />
                        <a id="purchase-report-link" href="">{{ trans('file.Purchase Report') }}</a>
                        {!! Form::close() !!}
                    </li>
                @endif
                @if ($hasPerm('due-report'))
                    <li id="due-report-menu">
                        {!! Form::open(['route' => 'report.customerDueByDate', 'method' => 'post', 'id' => 'customer-due-report-form']) !!}
                        <input type="hidden" name="start_date" value="{{ date('Y-m-d', strtotime('-1 year')) }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                        <a id="due-report-link" href="">{{ trans('file.Customer Due Report') }}</a>
                        {!! Form::close() !!}
                    </li>
                @endif
                @if ($hasPerm('supplier-report'))
                    <li id="supplier-report-menu">
                        <a id="supplier-report-link" href="">{{ trans('file.Supplier Report') }}</a>
                    </li>
                @endif
                @if ($hasPerm('supplier-due-report'))
                    <li id="supplier-due-report-menu">
                        {!! Form::open(['route' => 'report.supplierDueByDate', 'method' => 'post', 'id' => 'supplier-due-report-form']) !!}
                        <input type="hidden" name="start_date" value="{{ date('Y-m-d', strtotime('-1 year')) }}" />
                        <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}" />
                        <a id="supplier-due-report-link" href="">{{ trans('file.Supplier Due Report') }}</a>
                        {!! Form::close() !!}
                    </li>
                @endif
                @if ($hasPerm('product-qty-alert'))
                    <li id="qtyAlert-report-menu">
                        <a href="{{ route('report.qtyAlert') }}">{{ trans('file.Product Quantity Alert') }}</a>
                    </li>
                @endif
                @if ($hasPerm('stock-count-report'))
                    <li id="stock-count-report-menu">
                        <a href="{{ route('report.stockCount') }}">{{ trans('file.Stock Count Report') }}</a>
                    </li>
                @endif
                @if ($roleId <= 2 || $hasPerm('overview-report'))
                    <li id="overview-report-menu">
                        <a href="{{ route('report.overview') }}">{{ trans('file.Overview Report') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    {{-- Settings Menu --}}
    <li>
        <a href="#setting" aria-expanded="false" data-toggle="collapse">
            <i class="dripicons-gear"></i><span>{{ trans('file.settings') }}</span>
        </a>
        <ul id="setting" class="collapse list-unstyled ">
            @if ($roleId <= 2 || $hasPerm('role-permission') || $isManagement)
                <li id="role-menu"><a href="{{ route('role.index') }}">{{ trans('file.Role Permission') }}</a></li>
            @endif
            @if ($hasPerm('discount_plan'))
                <li id="discount-plan-list-menu"><a href="{{ route('discount-plans.index') }}">{{ trans('file.Discount Plan') }}</a></li>
            @endif
            @if ($hasPerm('discount'))
                <li id="discount-list-menu"><a href="{{ route('discounts.index') }}">{{ trans('file.Discount') }}</a></li>
            @endif
            @if ($hasPerm('warehouse-index') || $hasPerm('warehouse'))
                <li id="warehouse-menu"><a href="{{ route('warehouse.index') }}">{{ trans('file.Warehouse') }}</a></li>
            @endif
            @if ($hasPerm('customer_group'))
                <li id="customer-group-menu"><a href="{{ route('customer_group.index') }}">{{ trans('file.Customer Group') }}</a></li>
            @endif
            @if ($hasPerm('tax'))
                <li id="tax-menu"><a href="{{ route('tax.index') }}">{{ trans('file.Tax') }}</a></li>
            @endif
            <li id="user-menu">
                <a href="{{ route('user.profile', ['id' => Auth::id()]) }}">{{ trans('file.User Profile') }}</a>
            </li>
            @if ($hasPerm('general_setting'))
                <li id="general-setting-menu"><a href="{{ route('setting.general') }}">{{ trans('file.General Setting') }}</a></li>
            @endif
            @if ($hasPerm('pos_setting'))
                <li id="pos-setting-menu"><a href="{{ route('setting.pos') }}">POS {{ trans('file.settings') }}</a></li>
            @endif
        </ul>
    </li>
</ul>
