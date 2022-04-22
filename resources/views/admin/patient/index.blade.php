@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Patient</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient</li>
                </ul>
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
                                    <th>Patient Name</th>
                                    <th>Created Date</th>
                                    <th>Email </th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alluser as $alluser1)
                                
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($alluser1->profile_image != null)
                                                    <a href="{{ route('admin.user.show',$alluser1->id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $alluser1->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="{{ route('admin.user.show',$alluser1->id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="{{ route('admin.user.show',$alluser1->id) }}">{{$alluser1->name}} {{$alluser1->lname}}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $alluser1->created_at }}</small></td>
                                        <td>{{ $alluser1->email }}</small></td>
                                        {{-- <td>{{\Carbon\Carbon::parse($alluser1->dob)->age }}</td> --}}
                                        <td>+81 {{ $alluser1->mobile }}</td>
                                        <td>{{ $alluser1->address }}</small></td>
                                        
        
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