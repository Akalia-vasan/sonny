@extends('doctor.layouts.doctorlayout')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card dash-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="dash-widget dct-border-rht">
                            <div class="circle-bar circle-bar1">
                                <div class="circle-graph1" data-percent="75">
                                    <img src="{{ asset('assets1/img/icon-01.png')}}" class="img-fluid" alt="patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6>Total Patients</h6>
                                <h3>{{$total_patient}}</h3>
                                <p class="text-muted">Last 6 months</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-lg-6">
                        <div class="dash-widget dct-border-rht">
                            <div class="circle-bar circle-bar2">
                                <div class="circle-graph2" data-percent="65">
                                    <img src="{{ asset('assets1/img/icon-02.png')}}" class="img-fluid" alt="Patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6># Patients (Today)</h6>
                                <h3>{{$today_patient}}</h3>
                                <p class="text-muted">{{\Carbon\Carbon::now()->format('d, M Y')}}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="col-md-12 col-lg-4">
                        <div class="dash-widget">
                            <div class="circle-bar circle-bar3">
                                <div class="circle-graph3" data-percent="50">
                                    <img src="{{ asset('assets1/img/icon-03.png')}}" class="img-fluid" alt="Patient">
                                </div>
                            </div>
                            <div class="dash-widget-info">
                                <h6># Users (Today)</h6>
                                <h3>{{count($today_appontments)}}</h3>
                                <p class="text-muted">{{\Carbon\Carbon::now()->format('d, M Y')}}</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4 class="mb-4">Patient Appoinment</h4>
        <div class="appointment-tab">
        
            <!-- Appointment Tab -->
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                <li class="nav-item">
                    <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Upcoming</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#today-appointments" data-toggle="tab">Today</a>
                </li> 
            </ul>
            <!-- /Appointment Tab -->
            
            <div class="tab-content">
            
                <!-- Upcoming Appointment Tab -->
                <div class="tab-pane show active" id="upcoming-appointments">
                    <div class="card card-table mb-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            {{-- <th>Purpose</th> --}}
                                            <th>Type</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($slots as $slot)
                                          {{-- @if ($slot->getslotbooked->booking_date>now()) --}}
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="javascript:void(0);" class="avatar avatar-sm mr-2">
                                                                @if($slot->getuserbooked->profile_image!=null)
                                                                    <img class="avatar-img rounded-circle" src="{{url($slot->getuserbooked->profile_image)}}" alt="User Image">
                                                                @else
                                                                    <img class="avatar-img rounded-circle" src="{{asset('assets1/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image">
                                                                @endif
                                                            </a>
                                                        </h2>
                                                    </td>

                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="javascript:void(0);">{{$slot->getuserbooked->name}}  {{$slot->getuserbooked->l_name}}<span></span></a>
                                                        </h2>
                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($slot->getslotbooked->booking_date)->format('d M Y')}}
                                                        <span class="d-block text-info">{{Carbon\Carbon::parse($slot->getslotbooked->start_time)->format('H:i A')}}</span>
                                                    </td>
                                                    {{-- <td>General</td> --}}
                                                    <td>New Patient</td>
                                                    <td class="text-center">¥ {{$slot->price}}</td>
                                                    <td class="text-center">{{getRemark($slot->s_id)}}</td>
                                                    <td class="text-right">
                                                        <div class="table-action">
                                                            <a href="javascript:void(0);" onclick="showModelWithData({{$slot->s_id}},'{{$slot->booking_status}}','{{$slot->price}}','{{Carbon\Carbon::parse($slot->getslotbooked->booking_date)->format('d M Y')}}','{{Carbon\Carbon::parse($slot->start_time)->format('H:i A')}}')" class="btn btn-sm bg-info-light">
                                                                <i class="far fa-eye"></i> View
                                                            </a>
                                                            
                                                            @if($slot->booking_status=='Pending')
                                                            <a href="{{route('doctor.appointment.accept',$slot->s_id)}}" class="btn btn-sm bg-success-light">
                                                                <i class="fas fa-check"></i> Accept
                                                            </a>
                                                            <a href="{{route('doctor.appointment.cancel',$slot->s_id)}}" class="btn btn-sm bg-danger-light">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </a>
                                                            @endif
                                                            @if($slot->booking_status=='Confirm')
                                                            <a href="{{route('doctor.appointment.cancelAccepted',$slot->s_id)}}" class="btn btn-sm bg-danger-light">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>  
                                            {{-- @endif                                           --}}
                                        @endforeach
                                                                   
                                    </tbody>
                                </table>		
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Upcoming Appointment Tab -->
           
                <!-- Today Appointment Tab -->
                <div class="tab-pane" id="today-appointments">
                    <div class="card card-table mb-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Patient Name</th>
                                            <th>Appointment Date</th>
                                            
                                            <th>Type</th>
                                            <th class="text-center">Paid Amount</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($today_appontments as $slot)
                                          
                                                <tr>
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <a href="javascript:void(0);" class="avatar avatar-sm mr-2">
                                                                @if($slot->getuserbooked->profile_image!=null)
                                                                    <img class="avatar-img rounded-circle" src="{{url($slot->getuserbooked->profile_image)}}" alt="User Image">
                                                                @else
                                                                    <img class="avatar-img rounded-circle" src="{{asset('assets1/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image">
                                                                @endif
                                                            </a>
                                                        </h2>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);">{{$slot->getuserbooked->name}}  {{$slot->getuserbooked->l_name}}<span></span></a>
                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($slot->getslotbooked->booking_date)->format('d M Y')}}
                                                        <span class="d-block text-info">{{Carbon\Carbon::parse($slot->getslotbooked->start_time)->format('H:i A')}}</span>
                                                    </td>
                                                   
                                                    <td>New Patient</td>
                                                    <td class="text-center">¥ {{$slot->price}}</td>
                                                    <td class="text-center">{{getRemark($slot->id)}}</td>
                                                    
                                                    <td class="text-right">
                                                        <div class="table-action">
                                                            <a href="javascript:void(0); " onclick="showModelWithData({{$slot->id}},'{{$slot->booking_status}}','{{$slot->price}}','{{Carbon\Carbon::parse($slot->getslotbooked->booking_date)->format('d M Y')}}','{{Carbon\Carbon::parse($slot->start_time)->format('H:i A')}}')" class="btn btn-sm bg-info-light">
                                                                <i class="far fa-eye"></i> View
                                                            </a>
                                                            
                                                            @if($slot->booking_status=='Pending')
                                                            <a href="{{route('doctor.appointment.accept',$slot->id)}}" class="btn btn-sm bg-success-light">
                                                                <i class="fas fa-check"></i> Accept
                                                            </a>
                                                            <a href="{{route('doctor.appointment.cancel',$slot->id)}}" class="btn btn-sm bg-danger-light">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </a>
                                                            @endif
                                                            @if($slot->booking_status=='Confirm')
                                                            <a href="{{route('doctor.appointment.cancelAccepted',$slot->id)}}" class="btn btn-sm bg-danger-light">
                                                                <i class="fas fa-times"></i> Cancel
                                                            </a>
                                                            @endif
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
                <!-- /Today Appointment Tab -->
                
            </div>
        </div>
    </div>
</div>

@endsection
@push('customportion')
     <!-- Appointment Details Modal -->
     <div class="modal fade custom-modal" id="appt_details">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="info-details">
                        <li>
                            <div class="details-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span id="appt_id" class="title"></span>
                                        {{-- <span class="text">21 Oct 2019 10:00 AM</span> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button type="button" class="btn bg-success-light btn-sm" id="topup_status"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="title">Status:</span>
                            <span id="appt_status" class="text"></span>
                        </li>
                        <li>
                            <span class="title">Appointment Date:</span>
                            <span id="appt_date" class="text"></span>
                        </li>
                        <li>
                            <span class="title">Paid Amount</span>
                            <span id="appt_price" class="text"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Appointment Details Modal -->
@endpush
@push('script')
    <script>
        function showModelWithData(id,booking_status,price,book_date,book_time)
        {     
            $('#appt_id').text(id);
            $('#appt_status').text(booking_status);
            $('#appt_date').text(book_date + ' ' + book_time);
            $('#appt_price').text('₹ ' + price);
            $('#topup_status').text(booking_status);
            $('#appt_details').modal('show');   
        }
    </script>
@endpush