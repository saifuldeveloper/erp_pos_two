@extends('backend.layout.main')
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center"> Assigned Products </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table id="customer-table" class="table">
                                <thead>
                                    <tr>
                                        <th>Approval</th>
                                        <th>Shoe ID</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Color</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="approval"
                                                    data-id="{{ $product['shoe']['id'] }}"
                                                    @if ($product['is_approved']) checked @endif>
                                            </td>
                                            <td>{{ $product['shoe']['id'] }}</td>
                                            <td>
                                                <img src="{{ $product['shoe']['image_url'] }}" alt="image"
                                                    style="width: 50px; height: 50px;">
                                            </td>
                                            <td>{{ $product['shoe']['category']['full_name'] }}</td>
                                            <td>{{ $product['shoe']['color']['name'] }}</td>
                                            <td>
                                                @if ($product['is_approved'])
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
    <script>
        $(document).ready(function() {
            $('.approval').change(function() {
                var id = $(this).data('id');
                var isApproved = $(this).is(':checked');
                $.ajax({
                    url: "{{ route('product-approved') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        is_approved: isApproved,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush
