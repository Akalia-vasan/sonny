@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Doctors</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctors</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.doctor.create')}}" class="btn btn-primary float-right mt-2">Add</a>
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
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Member Since</th>
                                    <th>Earned</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alldoctor as $alldoctor1)
                                
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($alldoctor1->profile_image != null)
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $alldoctor1->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="javascript:;">Dr. {{$alldoctor1->name}} {{$alldoctor1->l_name}}</a>
                                            </h2>
                                        </td>
                                        <td>{{$alldoctor1->getspeciality->sp_name }}</td>
                                        
                                        <td>{{$alldoctor1->created_at}}<br><small>{{\Carbon\Carbon::parse($alldoctor1->created_at)->format('h:i A')}}</small></td>
                                        
                                        <td>¥ {{$alldoctor1->getearning->sum('amount') }}</td>
                                        
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-sm bg-primary-light"  href="{{ route('admin.doctor.show',$alldoctor1->id)}}">
                                                    <i class="fe fe-eye"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.doctor.edit',$alldoctor1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-danger-light demotest1" href="{{ route('admin.doctor.delete',$alldoctor1->id)}}">
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