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
                            <h4>{{ trans('file.Count Stock') }}</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open([
                                'route' => ['stock-count.update', $lims_stock_count->id],
                                'method' => 'put',
                                'files' => true,
                                'id' => 'stock-count-form',
                            ]) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Date') }}</label>
                                                <input type="text" name="created_at" class="form-control date"
                                                    value="{{ date('m/d/Y', strtotime($lims_stock_count->created_at)) }}"
                                                    placeholder="Choose date" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Warehouse') }} *</label>
                                                <select required name="warehouse_id" class="selectpicker form-control"
                                                    data-live-search="true" title="Select warehouse...">
                                                    @foreach ($lims_warehouse_list as $warehouse)
                                                        <option value="{{ $warehouse->id }}"
                                                            {{ $warehouse->id == $lims_stock_count->warehouse_id ? 'selected' : '' }}>
                                                            {{ $warehouse->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Attach Document') }}</label> <i
                                                    class="dripicons-question" data-toggle="tooltip"
                                                    title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                <input type="file" name="document" class="form-control">
                                                @if ($errors->has('extension'))
                                                    <span>
                                                        <strong>{{ $errors->first('extension') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5>Product Table</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            <th>Current Quantity</th>
                                                            <th>{{ trans('file.Quantity') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($lims_stock_count->items as $key => $stock_count_product)
                                                        <input type="hidden" name="product_id[]" value="{{ $stock_count_product->product_id }}" />
                                                            <tr>
                                                                <td>
                                                                    {{ $stock_count_product->product->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $stock_count_product->item_code }}
                                                                    <input type="hidden" name="product_code[]"
                                                                        value="{{ $stock_count_product->item_code }}" />
                                                                </td>
                                                                <td>
                                                                    {{ $stock_count_product->current_quantity }}
                                                                    <input type="hidden" name="current_qty[]"
                                                                        value="{{ $stock_count_product->current_quantity }}" />
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="qty[]"
                                                                        class="form-control"
                                                                        value="{{ $stock_count_product->updated_quantity }}"
                                                                        required />
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('file.Note') }}</label>
                                                <textarea rows="5" class="form-control" name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"
                                            id="submit-btn">{{ trans('file.submit') }}</button>
                                    </div>
                                </div>
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

        $('#stock-count-form').on('submit', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
                e.preventDefault();
            } else {
                $("#submit-btn").prop('disabled', true);
            }
        });
    </script>
@endpush
