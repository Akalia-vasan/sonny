@extends('doctor.layouts.layout2')

@section('content')

<div class="card">
    <div class="card-body pt-0">
        <div class="user-tabs">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                <li class="nav-item">
                    <a class="nav-link active" href="#pat_appointments" data-toggle="tab">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pres" data-toggle="tab"><span>Prescription</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#medical" data-toggle="tab"><span class="med-records">Medical Records</span></a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#billing" data-toggle="tab"><span>Billing</span></a>
                </li>  --}}
            </ul>
        </div>
        <div class="tab-content">
            
            <!-- Appointment Tab -->
            <div id="pat_appointments" class="tab-pane fade show active">
                <div class="card card-table mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Doctor</th>
                                        <th>Appt Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slots as $slots1)	
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="{{route('doctor.home')}}" class="avatar avatar-sm mr-2">
                                                        @if($slots1->getdoctorbooked->profile_image!=null)
                                                            <img class="avatar-img rounded-circle"  src="{{url($slots1->getdoctorbooked->profile_image)}}" alt="User Image">
                                                        @else
                                                            <img class="avatar-img rounded-circle"  src="{{asset('assets/img/patients/patient.jpg')}}" alt="User Image">
                                                        @endif
                                                    </a>
                                                    <a href="{{route('doctor.home')}}">Dr. {{$slots1->getdoctorbooked->name}}  {{$slots1->getdoctorbooked->l_name}} <span>{{$slots1->getdoctorbooked->getspeciality->sp_name}}</span></a>
                                                </h2>
                                            </td>
                                            <td>{{Carbon\Carbon::parse($slots1->getslotbooked->booking_date)->format('d M Y')}}
                                                <span class="d-block text-info">{{Carbon\Carbon::parse($slots1->getslotbooked->start_time)->format('H:i A')}}</span></td>
                            
                                            <td>¥ {{$slots1->price}}</td>
                                            @if($slots1->booking_status=='Declined')
                                                <td><span class="badge badge-pill bg-danger-light">{{$slots1->booking_status}}</span></td>
                                            @elseif($slots1->booking_status=='Confirm')
                                                <td><span class="badge badge-pill bg-success-light">{{$slots1->booking_status}}</span></td>
                                            @elseif($slots1->booking_status=='Pending')
                                                <td><span class="badge badge-pill bg-warning-light">{{$slots1->booking_status}}</span></td>
                                            @elseif($slots1->booking_status=='Completed')
                                                <td><span class="badge badge-pill bg-info-light">{{$slots1->booking_status}}</span></td>
                                            @endif
                                           
                                        </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Appointment Tab -->
            
            <!-- Prescription Tab -->
            <div class="tab-pane fade" id="pres">
                <div class="text-right">
                    <a href="{{route('doctor.patient.prescription',$patient_id)}}" class="add-new-btn">Add Prescription</a>
                </div>
                <div class="card card-table mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Date </th>
                                        <th>Name</th>									
                                        <th>Created by </th>
                                        <th class="text-center">Action</th>
                                    </tr>     
                                </thead>
                                <tbody>
                                    @foreach ($prescriptions as $prescription)
                                        <tr>
                                            <td>{{\Carbon\Carbon::parse($prescription->date)->format('d M Y')}}</td>
                                            <td>{{$prescription->getuser->name}}</td>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="javascript:;" class="avatar avatar-sm mr-2">
                                                        @if ($prescription->getdoctor->profile_image)
                                                        <img class="avatar-img rounded-circle" src="{{$prescription->getdoctor->profile_image}}" alt="User Image">
                                                        @else   
                                                            <img class="avatar-img rounded-circle" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="User Image">
                                                        @endif
                                                    </a>
                                                    <a href="javascript:;">Dr. {{$prescription->getdoctor->name}} <span>{{$prescription->getdoctor->getspeciality->sp_name}}</span></a>
                                                </h2>
                                            </td>
                                            <td class="text-right">
                                                <div class="table-action">
                                                    {{-- <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                        <i class="fas fa-print"></i> Print
                                                    </a> --}}
                                                    <a href="{{route('doctor.patient.prescription.show',$prescription->id)}}" class="btn btn-sm bg-info-light">
                                                        <i class="far fa-eye"></i> View
                                                    </a>
                                                    <a href="{{route('doctor.edit.prescription',$prescription->id)}}" class="btn btn-sm bg-info-light">
                                                        <i class="far fa-edit"></i> Edit
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
            <!-- /Prescription Tab -->

            <!-- Medical Records Tab -->
            <div class="tab-pane fade" id="medical">
                <div class="text-right">		
                    <a href="javascript:;" class="add-new-btn" data-toggle="modal" data-target="#add_medical_records">Add Medical Records</a>
                </div>
                <div class="card card-table mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Attachment</th>
                                        {{-- <th>Orderd By</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($record as $row)
                                        <tr>
                                            
                                            <td>@if ($row->title) {{$row->title}} @else Nan   @endif</td>
                                            <td>{{Carbon\Carbon::parse($row->date)->format('d M Y')}}<span class="d-block text-info">{{Carbon\Carbon::parse($row->date)->format('h:i A')}}</span></td>
                                            <td>{{$row->description}}</td>
                                            <td>
                                                <a href="{{url('storage').'/'.$row->attachment}}" target="blank" title="Download attachment" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i></a>
                                            </td>
                                            {{-- <td>Your Self</td> --}}
                                            {{-- <td>
                                                <a href="javascript:void(0);" onclick="mydeleteproductcategory({{$row->id}})" class="btn btn-sm bg-danger-light">
                                                    <i class="far fa-trash-alt"></i> 
                                                </a>
                                            </td> --}}
                                        </tr>  
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Medical Records Tab -->
            
            <!-- Billing Tab -->
            <div class="tab-pane" id="billing">
                <div class="text-right">
                    <a class="add-new-btn" href="{{route('doctor.patient.billing',$patient_id)}}">Add Billing</a>
                </div>
                <div class="card card-table mb-0">
                    <div class="card-body">
                        <div class="table-responsive">
                        
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Doctor</th>
                                        <th>Amount</th>
                                        <th>Paid On</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0010</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Ruby Perrin <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>$450</td>
                                        <td>14 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0009</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Darren Elder <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>$300</td>
                                        <td>13 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                                <a href="edit-billing.html" class="btn btn-sm bg-success-light">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0008</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-03.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Deborah Angel <span>Cardiology</span></a>
                                            </h2>
                                        </td>
                                        <td>$150</td>
                                        <td>12 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0007</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-04.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Sofia Brient <span>Urology</span></a>
                                            </h2>
                                        </td>
                                        <td>$50</td>
                                        <td>11 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0006</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-05.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Marvin Campbell <span>Ophthalmology</span></a>
                                            </h2>
                                        </td>
                                        <td>$600</td>
                                        <td>10 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0005</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-06.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Katharine Berthold <span>Orthopaedics</span></a>
                                            </h2>
                                        </td>
                                        <td>$200</td>
                                        <td>9 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0004</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-07.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Linda Tobin <span>Neurology</span></a>
                                            </h2>
                                        </td>
                                        <td>$100</td>
                                        <td>8 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0003</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-08.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Paul Richard <span>Dermatology</span></a>
                                            </h2>
                                        </td>
                                        <td>$250</td>
                                        <td>7 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0002</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-09.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. John Gibbs <span>Dental</span></a>
                                            </h2>
                                        </td>
                                        <td>$175</td>
                                        <td>6 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="invoice-view.html">#INV-0001</a>
                                        </td>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                    <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-10.jpg" alt="User Image">
                                                </a>
                                                <a href="doctor-profile.html">Dr. Olga Barlow <span>#0010</span></a>
                                            </h2>
                                        </td>
                                        <td>$550</td>
                                        <td>5 Nov 2019</td>
                                        <td class="text-right">
                                            <div class="table-action">
                                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light">
                                                    <i class="fas fa-print"></i> Print
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                    <i class="far fa-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Billing Tab -->
                    
        </div>
    </div>
</div>

@endsection

@push('script')
    <!-- Add Medical Records Modal -->
		<div class="modal fade custom-modal" id="add_medical_records">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Medical Records</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="{{ route('doctor.store.medical.record') }}"  enctype="multipart/form-data" autocomplete="off" method="post">					
						@csrf
                        <input type="hidden" name="user_id" value="{{$patient_id}}">
                        <div class="modal-body">
							<div class="form-group">
								<label>Date</label>
								<input type="text" class="form-control datetimepicker" readonly value="{{\Carbon\Carbon::now()->format('d-m-Y')}}">
							</div>
							<div class="form-group">
								<label>Description ( Optional )</label>
								<textarea name="description" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<label>Upload File</label> 
								<input type="file" name="attachment" class="form-control">
							</div>	
							<div class="submit-section text-center">
								<button type="submit" class="btn btn-primary submit-btn">Submit</button>
								<button type="button" class="btn btn-secondary submit-btn" data-dismiss="modal">Cancel</button>							
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Medical Records Modal -->
@endpush