@extends('backend.layout.main')
@section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            Add List
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'route' => ['stock-count.update', $lims_stock_count->id],
                                'method' => 'put',
                                'files' => true,
                                'id' => 'stock-count-form',
                            ]) !!}
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('file.name') }}</th>
                                            <th>{{ trans('file.Code') }}</th>
                                            <th>Current Quantity</th>
                                            <th>Quantity Find</th>
                                            <th>Remarks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lims_stock_count->items as $items)
                                            @php
                                                $item = $items[0];
                                            @endphp
                                            <tr>
                                                <td>{{ $item->product->name }}</td>
                                                <td>{{ $item->product->code }}</td>
                                                <td>{{ $item->current_quantity }}</td>
                                                <td>
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($items as $item)
                                                        {{ $item->updated_quantity }}
                                                        @if (!$loop->last)
                                                            +
                                                        @endif
                                                        @php
                                                            $total += $item->updated_quantity;
                                                        @endphp
                                                    @endforeach
                                                    = {{ $total }}
                                                </td>
                                                <td>
                                                    @if ($total > $item->current_quantity)
                                                        Over Stock ({{ $total - $item->current_quantity }})
                                                    @elseif($total < $item->current_quantity)
                                                        Under Stock ({{ $item->current_quantity - $total }})
                                                    @else
                                                        Stock Matched
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="resolved[{{ $item->id }}]"
                                                            id="add_stock-{{ $item->id }}" value="add_stock">
                                                        <label class="form-check label" for="add_stock-{{ $item->id }}"
                                                            style="margin-right: 10px;">
                                                            Add Stock
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="resolved[{{ $item->id }}]"
                                                            id="cancel-{{ $item->id }}" value="cancel">
                                                        <label class="form-check label" for="cancel-{{ $item->id }}"
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

                            <input type="hidden" name="status" value="resolved">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submit-btn">Resolved</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #stock-count-menu").addClass("active");
    </script>
@endpush
