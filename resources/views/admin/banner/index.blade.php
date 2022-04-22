@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Banner</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Banner</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.banner.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="doctor-datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Banner Name</th>
                                    <th>Banner Image </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banner as $banner1)
                                
                                    <tr>
                                        <td>{{ $banner1->title }}</small></td>
                                        <td><img  height="50px" width="50px" src="{{ $banner1->image }}" /></td>
                                        <td>{{ $banner1->active == 1 ? 'Active' : 'Inactive' }}</small></td>
                                        <td>
                                            <div class="actions">
                                               
                                                    <a class="btn btn-sm bg-success-light"  href="{{ route('admin.banner.edit',$banner1->id)}}">
                                                        <i class="fe fe-pencil"></i> 
                                                    </a>
                                                    <a class="btn btn-sm bg-danger-light demotest1"  href="{{ route('admin.banner.delete',$banner1->id)}}">
                                                        <i class="fe fe-trash"></i> 
                                                    </a>
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
                            window.location.href = url;
                            swal("Deleted!", "Your record has been deleted.", "success");
                        } else {
                            swal("Cancelled", "Your record is safe.", "error");
                        }
                    });
            });

    </script>
@endpush