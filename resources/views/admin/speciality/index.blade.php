@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Specialities</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Specialities</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.speciality.create')}}" class="btn btn-primary float-right mt-2">Add</a>
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
                                    <th>Code</th>
                                    <th>Image</th>
                                    <th>Specialities</th>
                                    <th>Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($speciality as $speciality1)
                                    <tr>
                                        <td>{{ $speciality1->sp_code}}</td>
										<td>
                                            <h2 class="table-avatar">
                                                <a href="javascript:void(0);" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img" src="{{$speciality1->sp_image}}" alt="Speciality">
                                                </a>
                                            </h2>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar"><a href="javascript:void(0);">{{ $speciality1->sp_name}}</a></h2>
                                        </td>
                                        
                                        <td>
                                            <div class="actions">
                            
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.speciality.edit',$speciality1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-danger-light demotest1" href="{{ route('admin.speciality.delete',$speciality1->id)}}">
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
            $('.doctor-datatable').dataTable( {
                "columnDefs": [{ "orderable": false, "targets": 1 }]
            });
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