@extends('admin.layouts.admin')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Appointments</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Appointments</li>
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
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Patient Name</th>
                                    <th>Apointment Time</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointment as $allslot1)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($allslot1->getdoctorbooked->profile_image != null)
                                                    <a href="{{ route('admin.doctor.show',$allslot1->doctor_id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $allslot1->getdoctorbooked->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="{{ route('admin.doctor.show',$allslot1->doctor_id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="{{ route('admin.doctor.show',$allslot1->doctor_id) }}">{{$allslot1->getdoctorbooked->name}} {{$allslot1->getdoctorbooked->l_name}}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $allslot1->getdoctorbooked->getspeciality->sp_name }}</small></td> 
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($allslot1->getuserbooked->profile_image != null)
                                                    <a href="{{ route('admin.user.show',$allslot1->user_id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $allslot1->getuserbooked->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="{{ route('admin.user.show',$allslot1->user_id) }}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="{{ route('admin.user.show',$allslot1->user_id) }}">{{$allslot1->getuserbooked->name}} {{$allslot1->getuserbooked->lname}}</a>
                                            </h2>
                                        </td>
                                        
                                        <td>{{Carbon\Carbon::parse($allslot1->getslotbooked->booking_date)->format('d M Y')}}
                                            <span class="d-block text-info">{{Carbon\Carbon::parse($allslot1->getslotbooked->start_time)->format('h:i A')}}</span>
                                        </td>
                                        
                                        <td>¥ {{ $allslot1->price }}</small></td>
                                        
                                        <td>{{ $allslot1->booking_status }}</td>
                                        
                                        <td>
                                            @if($allslot1->booking_status=='Confirm')
                                                <a href="{{route('admin.appointment.cancelAccepted',$allslot1->id)}}" class="btn btn-sm bg-danger-light">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                            @endif
                                            @if($allslot1->booking_status=='Pending')
                                                <a href="{{route('admin.appointment.accept',$allslot1->id)}}" class="btn btn-sm bg-success-light">
                                                    <i class="fas fa-check"></i> Accept
                                                </a>
                                                <a href="{{route('admin.appointment.cancel',$allslot1->id)}}" class="btn btn-sm bg-danger-light">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
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
    

@endsection
@push('script')
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script>

        $(document).ready(function(){
            $('.doctor-datatable').DataTable({
                dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons:[
                            {
                                    extend: 'excel',
                                    footer: false,
                                    className: 'btn btn-primary',
                                    init: function(api, node, config) {
                                        $(node).removeClass('btn-default')
                                    },
                                    exportOptions: {
                                        columns: [0,1,2,3,4,5]
                                    } 
                            },
                            // {
                            //     extend: 'csv',
                            //     footer: false,
                            //     className: 'btn btn-success',
                            //         init: function(api, node, config) {
                            //         $(node).removeClass('btn-default')
                            //         },
                            //     exportOptions: {
                            //             columns: [1,2,3,4,5]
                            //         }
                            // }         
                        ]
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