@extends('doctor.layouts.doctorlayout')
@section('content')

    <div class="appointments">
		@foreach ($slots as $slots1)			
            <!-- Appointment List -->
            <div class="appointment-list">
                <div class="profile-info-widget">
                    <a href="javascript:void(0)" class="booking-doc-img">
                        @if($slots1->getuserbooked->profile_image!=null)
                            <img src="{{url($slots1->getuserbooked->profile_image)}}" alt="User Image">
                        @else
                            <img src="{{asset('assets/img/patients/patient.jpg')}}" alt="User Image">
                        @endif                      
                    </a>
                    <div class="profile-det-info">
                        <h3><a href="javascript:void(0)">{{$slots1->getuserbooked->name}} {{$slots1->getuserbooked->lname}}</a></h3>
                        <div class="patient-details">
                            <h5><i class="far fa-clock"></i> {{Carbon\Carbon::parse($slots1->getslotbooked->booking_date)->format('d M Y')}}, {{Carbon\Carbon::parse($slots1->getslotbooked->start_time)->format('H:i A')}}</h5>
                            <h5><i class="fas fa-map-marker-alt"></i> Japan</h5>
                            <h5><i class="fas fa-envelope"></i> {{$slots1->getuserbooked->email}}</h5>
                            <h5 class="mb-0"><i class="fas fa-phone"></i>+81 {{$slots1->getuserbooked->mobile}}</h5>
                        </div>
                    </div>
                </div>
                <div class="appointment-action">
                    <a href="#" class="btn btn-sm bg-info-light" onclick="showModelWithData({{$slots1->id}},'{{$slots1->booking_status}}','{{$slots1->price}}','{{Carbon\Carbon::parse($slots1->getslotbooked->booking_date)->format('d M Y')}}','{{Carbon\Carbon::parse($slots1->start_time)->format('H:i A')}}')" >
                        <i class="far fa-eye"></i> View
                    </a>
                    @if($slots1->booking_status=='Pending')
                    <a href="{{route('doctor.appointment.accept',$slots1->id)}}" class="btn btn-sm bg-success-light">
                        <i class="fas fa-check"></i> Accept
                    </a>
                    <a href="{{route('doctor.appointment.cancel',$slots1->id)}}" class="btn btn-sm bg-danger-light">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    @endif
                    @if($slots1->booking_status=='Confirm')
                    <a href="{{route('doctor.appointment.cancelAccepted',$slots1->id)}}" class="btn btn-sm bg-danger-light">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    @endif
                </div>
            </div>
            <!-- /Appointment List -->
        @endforeach		
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
            $('#appt_price').text('¥ ' + price);
            $('#topup_status').text(booking_status);
            $('#appt_details').modal('show');   
        }
    </script>
@endpush