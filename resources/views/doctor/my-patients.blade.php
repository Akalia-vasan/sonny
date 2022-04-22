@extends('doctor.layouts.doctorlayout')

@section('content')

    <div class="row row-grid">
        @foreach ($patients as $patient)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card widget-profile pat-widget-profile">
                    <div class="card-body">
                        <div class="pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="{{ route('doctor.patient.profiledetail',$patient->getuserbooked->id)}}" class="booking-doc-img">
                                    @if ($patient->getuserbooked->profile_image)
                                        <img src="{{$patient->getuserbooked->profile_image}}" alt="User Image">  
                                    @else
                                        <img src="{{asset('assets/img/patients/patient.jpg')}}" alt="User Image">   
                                    @endif
                                </a>
                                <div class="profile-det-info">
                                    <h3><a href="{{ route('doctor.patient.profiledetail',$patient->getuserbooked->id)}}">{{$patient->getuserbooked->name}}</a></h3>
                                    
                                    <div class="patient-details">
                                        <h5><b>Patient ID :</b> {{$patient->getuserbooked->id}}</h5>
                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Japan</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="patient-info">
                            <ul>
                                <li>Phone <span>+81 {{$patient->getuserbooked->mobile}}</span></li>
                                <li>Age <span>{{\Carbon\Carbon::parse($patient->getuserbooked->dob)->age}} years, {{$patient->getuserbooked->gender}}</span></li>
                                <li>Blood Group <span>{{$patient->getuserbooked->blood_group}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>  
        @endforeach
    
    </div>
    
@endsection

@push('script')



@endpush