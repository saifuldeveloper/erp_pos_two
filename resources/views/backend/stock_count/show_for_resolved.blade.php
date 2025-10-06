@extends('backend.layout.main')
@section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            {!! Form::open([
                'route' => ['stock-count.update', $lims_stock_count->id],
                'method' => 'put',
                'files' => true,
                'id' => 'stock-count-form',
            ]) !!}

            @if (count($lims_stock_count->items) > 0)
                <div class="row">
                    <div class="col-md-12">
                        @php
                            $stockMatched = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total == $items[0]->current_quantity;
                            });

                            $overStock = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total > $items[0]->current_quantity;
                            });

                            $underStock = $lims_stock_count->items->filter(function ($items) {
                                $total = $items->sum('updated_quantity');
                                return $total < $items[0]->current_quantity;
                            });

                            $stockCounts = [
                                ['title' => 'Stock Matched', 'data' => $stockMatched],
                                ['title' => 'Over Stock', 'data' => $overStock],
                                ['title' => 'Under Stock', 'data' => $underStock],
                            ];
                        @endphp
                        @foreach ($stockCounts as $stockCount)
                            @if ($stockCount['data']->count() > 0)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5>{{ $stockCount['title'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover stock-count-table">
                                                <thead>
                                                    <tr>
                                                        <th>{{ trans('file.name') }}</th>
                                                        <th>{{ trans('file.Code') }}</th>
                                                        <th>Current Quantity</th>
                                                        <th>Quantity Find</th>
                                                        <th>Remarks</th>
                                                        <th>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check
                                                                    input all" type="radio" name="resolved[all]"
                                                                    id="update_stock-all" value="update_stock">
                                                                    <label class="form-check label"
                                                                    for="update_stock-all" style="margin-right: 10px;">Update All</label>
                                                            </div>
                                                            <div class="form-check
                                                                form-check-inline">
                                                                <input class="form-check input all" type="radio" name="resolved[all]"
                                                                    id="cancel-all" value="cancel">
                                                                    <label class="form-check label"
                                                                    for="cancel-all" style="margin-right: 10px;">Cancel All</label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($stockCount['data'] as $items)
                                                        @php
                                                            $item = $items[0];
                                                            $total = $items->sum('updated_quantity');
                                                        @endphp
                                                        <tr>
                                                            <td>{{ @$item->product->name }}</td>
                                                            <td>{{ $item->item_code }}</td>
                                                            <td>{{ $item->current_quantity }}</td>
                                                            <td>
                                                                @foreach ($items as $item)
                                                                    {{ $item->updated_quantity }}
                                                                    @if (!$loop->last)
                                                                        +
                                                                    @endif
                                                                @endforeach
                                                                = {{ $total }}
                                                            </td>
                                                            <td>{{ $stockCount['title'] }}
                                                                @if ($stockCount['title'] != 'Stock Matched')
                                                                    ({{ abs($total - $item->current_quantity) }})
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="resolved[{{ $item->item_code }}]"
                                                                        id="update_stock-{{ $item->id }}"
                                                                        value="update_stock">
                                                                    <label class="form-check label"
                                                                        for="update_stock-{{ $item->id }}"
                                                                        style="margin-right: 10px;">
                                                                        Update Stock
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="resolved[{{ $item->item_code }}]"
                                                                        id="cancel-{{ $item->id }}" value="cancel">
                                                                    <label class="form-check label"
                                                                        for="cancel-{{ $item->id }}"
                                                                        style="margin-right: 10px;">
                                                                        Cancel
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            <input type="hidden" name="status" value="resolved">
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submit-btn">Resolved</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");

        $('.stock-count-table').DataTable({
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                "search": '{{ trans('file.Search') }}',
                'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
                }
            },
            dom: '<"row"lfB>rtip',
        });

        // Check all radio button
        $('.all').on('change', function() {
            var id = $(this).attr('id');
            var value = $(this).val();
            var checked = $(this).prop('checked');
            var radio = $('input[type="radio"][value="' + value + '"]');
            radio.prop('checked', checked);
        });
    </script>
@endpush
