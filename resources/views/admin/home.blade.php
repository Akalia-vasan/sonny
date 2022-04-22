@extends('admin.layouts.admin')

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-users"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_doctor}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted"># of Doctors</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary " style="width:{{Change($total_doctor)}}% !important;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success">
                            <i class="fe fe-credit-card"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{$total_user}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted"># of Patients</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success " style="width:{{Change($total_user)}}% !important;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-money"></i>
                        </span>
                        <div class="dash-count">
                            <h3>485</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted"># of Appointment</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width:{{Change(485)}}% !important;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-folder"></i>
                        </span>
                        <div class="dash-count">
                            <h3>¥ 6523</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        
                        <h6 class="text-muted">Total Revenue</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" style="width:{{Change(6523)}}% !important;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-5">
        
            <!-- Sales Chart -->
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Revenue</h4>
                </div>
                <div class="card-body">
                    <div id="morrisArea"></div>
                </div>
            </div>
            <!-- /Sales Chart -->
            
        </div>
        <div class="col-md-12 col-lg-7">
        
            <!-- Invoice Chart -->
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">New Users/Doctors</h4>
                </div>
                <div class="card-body">
                    <div id="morrisLine"></div>
                </div>
            </div>
            <!-- /Invoice Chart -->
            
        </div>	
    </div>
    <div class="row">
        <div class="col-md-6 d-flex">
        
            <!-- Recent Orders -->
            <div class="card card-table flex-fill">
                <div class="card-header">
                    <h4 class="card-title">Doctors List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Date Created</th>
                                    <th>Speciality</th>
                                    <th># of Appointments</th>
                                    <th>Revenue Earned</th>
                                    <th>Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alldoctor as $alldoctor1)
                                
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            @if ($alldoctor1->profile_image != null)
                                                <a href="{{route('admin.doctor.show',$alldoctor1->id)}}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $alldoctor1->profile_image }}" alt="Doctor Image"></a>
                                            @else
                                                <a href="{{route('admin.doctor.show',$alldoctor1->id)}}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                            @endif
                                            <a href="{{route('admin.doctor.show',$alldoctor1->id)}}">Dr. {{$alldoctor1->name}} {{$alldoctor1->l_name}}</a>
                                        </h2>
                                    </td>
                                    <td>{{$alldoctor1->created_at }}</td>
                                    <td>{{$alldoctor1->getspeciality->sp_name }}</td>
                                    <td>{{getAppointments($alldoctor1->id) }}</td>
                                    <td>¥ {{$alldoctor1->getearning->sum('amount') }}</td>
                                    <td><div class="rating">
                                            @for($i=0;$i<round($alldoctor1->getRating->avg('rating'),0);$i++)
                                            <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for($i=round($alldoctor1->getRating->avg('rating'),0);$i<5;$i++)
                                            <i class="fas fa-star"></i>
                                            @endfor
                                            <span class="d-inline-block average-rating">({{$alldoctor1->getRating->count()}})</span>
                                        </div>
                                    </td>
                                    
                                    {{-- <td>{{$alldoctor1->created_at}}<br><small>{{\Carbon\Carbon::parse($alldoctor1->created_at)->format('h:i A')}}</small></td> --}}
                                </tr>
                                @endforeach
                                {{-- <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="javascript:void(0);" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="User Image"></a>
                                            <a href="javascript:void(0);">Dr. Ruby Perrin</a>
                                        </h2>
                                    </td>
                                    <td>Dental</td>
                                    <td>$3200.00</td>
                                    <td>
                                        <i class="fe fe-star text-warning"></i>
                                        <i class="fe fe-star text-warning"></i>
                                        <i class="fe fe-star text-warning"></i>
                                        <i class="fe fe-star text-warning"></i>
                                        <i class="fe fe-star-o text-secondary"></i>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Recent Orders -->
            
        </div>
        <div class="col-md-6 d-flex">
        
            <!-- Feed Activity -->
            <div class="card  card-table flex-fill">
                <div class="card-header">
                    <h4 class="card-title">Patients List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>													
                                    <th>Patient Name</th>
                                    <th>Date Created</th>
                                    <th>Phone</th>
                                    <th>Last Visit</th>
                                    <th>Total Paid</th>													
                                </tr>
                            </thead>
                            <tbody> 
                                @foreach ($alluser as $alluser1)  
                                    @if ($alluser1->getslots->count()>0)
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
                                            <td>{{ $alluser1->created_at }}</td>
                                            <td>+81 {{ $alluser1->mobile }}</td>
                                            <td>{{ $alluser1->getslots[0]->created_at ? \Carbon\Carbon::parse($alluser1->getslots[0]->created_at)->format('d M Y'): null; }}</small></td>
                                            <td>¥ {{ $alluser1->getslots->sum('price')}}</small></td>
                                        </tr>
                                    @endif
                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Feed Activity -->
            
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-header">
                    <h4 class="card-title">Appointment List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Patient Name</th>
                                    <th>Apointment Time</th>
                                    <th>Status</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointment as $allslot1)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($allslot1->getdoctorbooked->profile_image != null)
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $allslot1->getdoctorbooked->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="javascript:;">{{$allslot1->getdoctorbooked->name}} {{$allslot1->getdoctorbooked->l_name}}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $allslot1->getdoctorbooked->getspeciality->sp_name }}</small></td>
                                        <td>
                                            <h2 class="table-avatar">
                                                @if ($allslot1->getuserbooked->profile_image != null)
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ $allslot1->getuserbooked->profile_image }}" alt="Doctor Image"></a>
                                                @else
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image"></a>
                                                @endif
                                                <a href="javascript:;">{{$allslot1->getuserbooked->name}} {{$allslot1->getuserbooked->lname}}</a>
                                            </h2>
                                        </td>
                                        
                                        <td>{{Carbon\Carbon::parse($allslot1->getslotbooked->booking_date)->format('d M Y')}}
                                            <span class="d-block text-info">{{Carbon\Carbon::parse($allslot1->getslotbooked->start_time)->format('h:i A')}}</span>
                                        </td>
                                        
                                        <td>₹ {{ $allslot1->price }}</small></td>
                                        
                                        <td>{{ $allslot1->booking_status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>
    </div> --}}
@push('script')
<script src="{{ asset('assets/js/chart.morris.js') }}"></script>
<script>

</script>


@endpush
@endsection
