@extends('backend.layout.main')
@section('content')
    <div id="message"></div>
    <section>
        <div class="container-fluid">
            <div class="card">
                @if (!$retailStore)
                    <div class="card-header mt-2">
                        <h3 class="text-center"> API Connection Could Not Be Established </h3>
                    </div>
                @else
                    <div class="card-header mt-2">
                        <h3 class="text-center"> Assigned Products </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="customer-table" class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Shoe ID</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Color</th>
                                            <th>Status</th>
                                            <th>Request Quantity</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr class="text-center">
                                                <td>{{ $product['shoe']['id'] }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#productImage{{ $product['shoe']['id'] }}">
                                                        <img src="{{ $product['shoe']['image_url'] }}" alt="image"
                                                            style="width: 50px; height: 50px;">
                                                    </a>
                                                </td>
                                                <td>{{ $product['shoe']['category']['full_name'] }}</td>
                                                <td>{{ $product['shoe']['color']['name'] }}</td>
                                                <td>
                                                    @if ($product['is_approved'])
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>{{ $product['note'] ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                                        data-target="#productApprove{{ $product['shoe']['id'] }}">
                                                        Update
                                                    </a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="productImage{{ $product['shoe']['id'] }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ $product['shoe']['id'] . ' - ' . $product['shoe']['category']['full_name'] }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true" class="text-dark">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ $product['shoe']['image_url'] }}" alt="image"
                                                                style="width: 100%; height: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="productApprove{{ $product['shoe']['id'] }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ $product['shoe']['id'] . ' - ' . $product['shoe']['category']['full_name'] }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true" class="text-dark">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('product-approved') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $product['id'] }}">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="quantity">Quantity</label>
                                                                    <input type="number" name="quantity" id="quantity"
                                                                        required class="form-control" placeholder="Quantity"
                                                                        value="{{ $product['quantity'] }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="note">Note</label>
                                                                    <textarea name="note" id="note" class="form-control" placeholder="Note">{{ $product['note'] }}</textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="is_approved">Status</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_approved"
                                                                            id="is_approved{{ $key }}"
                                                                            value="1"
                                                                            {{ $product['is_approved'] == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check"
                                                                            for="is_approved{{ $key }}">
                                                                            Approved
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="is_approved"
                                                                            id="is_pending{{ $key }}"
                                                                            value="0"
                                                                            {{ $product['is_approved'] == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check"
                                                                            for="is_pending{{ $key }}">
                                                                            Pending
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
