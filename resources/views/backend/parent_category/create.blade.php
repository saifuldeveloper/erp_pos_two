@extends('backend.layout.main') @section('content')
@if($errors->has('title'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('title') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <div class="container-fluid">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"><i class="dripicons-plus"></i> {{trans('file.Add Parent Category')}} </button>&nbsp;
        {{-- <button class="btn btn-info" data-toggle="modal" data-target="#importBrand"><i class="dripicons-copy"></i> {{trans('file.Import Brand')}}</button> --}}
    </div>
    <div class="table-responsive">
        <table id="parent-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Parent Category')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parents as $key=> $parent)
                <tr data-id="{{$parent->id}}">
                    <td>{{$key + 1}}</td>
                    <td>{{ $parent->name }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li><button type="button" data-id="{{$parent->id}}" class="open-EditparentCategoryDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</button></li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['category.destroy', $parent->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure want to delete?')"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'category.store', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Parent Category')}}</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
            <div class="form-group">
                <label>{{trans('file.name')}} *</label>
                {{Form::text('name',null,array('required' => 'required', 'class' => 'form-control', 'placeholder' => 'Type parent category...'))}}
            </div>
            <div class="form-group">
              <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
            </div>
        </div>
        {{ Form::close() }}
      </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            {!! Form::open(['route' => 'category.import', 'method' => 'post', 'files' => true]) !!}
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Import Category') }}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                        aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <p class="italic">
                    <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                </p>
                <p>{{ trans('file.The correct column order is') }} (name*, parent_category)
                    {{ trans('file.and you must follow this') }}.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ trans('file.Upload CSV File') }} *</label>
                            {{ Form::file('file', ['class' => 'form-control', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> {{ trans('file.Sample File') }}</label>
                            <a href="sample_file/sample_category.csv" class="btn btn-info btn-block btn-md"><i
                                    class="dripicons-download"></i> {{ trans('file.Download') }}</a>
                        </div>
                    </div>
                </div>
                <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

 <!-- Edit Modal -->
 <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
 class="modal fade text-left">
 <div role="document" class="modal-dialog">
     <div class="modal-content">
         {{ Form::open(['route' => ['category.update', 1], 'method' => 'PUT', 'files' => true]) }}
         <div class="modal-header">
             <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Update Category') }}</h5>
             <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                     aria-hidden="true"><i class="dripicons-cross"></i></span></button>
         </div>
         <div class="modal-body">
             <div class="row">
                 <div class="col-md-6 form-group">
                     <label>{{ trans('file.name') }} *</label>
                     {{ Form::text('name', null, ['required' => 'required', 'class' => 'form-control']) }}
                 </div>
                 <input type="hidden" name="category_id">
                 {{-- <div class="col-md-6 form-group">
                     <label>{{ trans('file.Image') }}</label>
                     <input type="file" name="image" class="form-control">
                 </div> --}}
                 {{-- <div class="col-md-6 form-group">
                     <label>{{ trans('file.Parent Category') }}</label>
                     <select name="parent_id" class="form-control selectpicker" id="parent">
                         <option value="">No {{ trans('file.parent') }}</option>
                         @foreach ($categories_list as $category)
                             <option value="{{ $category->id }}">{{ $category->name }}</option>
                         @endforeach
                     </select>
                 </div> --}}

             </div>

             <div class="form-group">
                 <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary">
             </div>
         </div>
         {{ Form::close() }}
     </div>
 </div>
</div>



@endsection

@push('scripts')
<script type="text/javascript">

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product #parent-menu").addClass("active");

    var category_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#select_all" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        }
        else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });

    $("#export").on("click", function(e){
        e.preventDefault();
        var brand = [];
        $(':checkbox:checked').each(function(i){
          brand[i] = $(this).val();
        });
        $.ajax({
           type:'POST',
           url:'/exportbrand',
           data:{

                brandArray: brand
            },
           success:function(data){
            alert('Exported to CSV file successfully! Click Ok to download file');
            window.location.href = data;
           }
        });
    });

    $(document).ready(function() {
        $(document).on('click', '.open-EditparentCategoryDialog', function() {
            var url = "category/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");

            $.get(url, function(data) {
                $("input[name='name']").val(data['name']);
                $("input[name='category_id']").val(data['id']);

            });
        });
    });

    $(document).ready(function() {
    // DataTable initialization
    $('#parent-table').DataTable({
        // Export buttons configuration
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                text: 'Copy',
                exportOptions: {
                    columns: ':not(.not-exported)' // এক্সপোর্টে .not-exported ক্লাসের কলাম বাদ দেয়া হবে
                }
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: ':not(.not-exported)'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    columns: ':not(.not-exported)'
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: ':not(.not-exported)'
                }
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':not(.not-exported)'
                }
            }
        ],
        // Ordering and other configurations
        "order": [],
        "columnDefs": [
            { "orderable": false, "targets": [0, 2] }, // প্রথম ও তৃতীয় কলামে অর্ডারিং নিষ্ক্রিয়
            { "searchable": false, "targets": [0, 2] } // প্রথম ও তৃতীয় কলামে সার্চ নিষ্ক্রিয়
        ],
        // Language configuration (optional)
        "language": {
            "lengthMenu": "_MENU_ records per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "search": "Search:",
            "paginate": {
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});




</script>
@endpush
