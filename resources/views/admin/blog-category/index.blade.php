@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Blog Category</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Blog Category</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.b_category.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="doctor-datatable text-center table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allcategory as $allcategory1)
                                    <tr>
                                        <td>{{ $allcategory1->category_name}}</td>
                                        <td>
                                            <div class="actions">
                            
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.b_category.edit',$allcategory1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>

                                                <a class="btn btn-sm bg-danger-light demotest1" href="javascript:;">
                                                    <i class="fe fe-trash"></i> 
                                                </a>

                                                <form action="{{ route('admin.b_category.destroy',$allcategory1->id) }}" method="post" id="form_submit_destroy" >
                                                    @csrf	
                                                    @method('DELETE')
                                                    
                                                </form>
                                            </div>
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
    

@endsection
@push('script')
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

        $(document).ready(function(){
            $('.doctor-datatable').DataTable();
        });

        $(document).on('click', '.demotest1', function() {
                event.preventDefault();
                const url = $(this).attr('href');
                console.log(url);
                    swal({
                        title: "Are you sure?",
                        text: "Your will not be able to recover this record!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('#form_submit_destroy').submit();
                            swal("Deleted!", "Your record has been deleted.", "success");
                        } else {
                            swal("Cancelled", "Your record is safe.", "error");
                        }
                    });
            });

    </script>
@endpush