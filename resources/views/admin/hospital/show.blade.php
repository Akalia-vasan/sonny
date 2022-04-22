@extends('admin.layouts.admin')

@push('style')
	<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">
	{{-- <link rel="stylesheet" href="{{ asset('assets1/plugins/fancybox/jquery.fancybox.min.css') }}"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Hospital Details</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hospital Details</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <!-- Page Content -->
			<div class="content">
				<div class="container">

					<!-- Doctor Widget -->
					<div class="card">
						<div class="card-body">
							<div class="doctor-widget">
								<div class="doc-info-left">
									
									<div class="doc-info-cont">
										<h4 class="doc-name">{{$hospital->hospital_name}}</h4>
										<p class="doc-speciality">{{$hospital->type}}</p>

										<div class="rating">
											@for($i=0;$i<$hospital->rating;$i++)
												<i class="fas fa-star filled"></i>
											@endfor
											@for($i=$hospital->rating;$i<5;$i++)
												<i class="fas fa-star"></i>
											@endfor
											<span class="d-inline-block average-rating">({{$hospital->rating}})</span>
										</div>


                                        <p class="doc-speciality">{{$hospital->hospital_email}}</p>
                                        <p class="doc-speciality">{{$hospital->hospital_number}}</p>
                                        <p class="doc-speciality"><b>About Hospital</b> {{$hospital->about}}</p>


										<div class="clinic-details">
											<ul class="clinic-gallery">
												@php
													$clinicimg = json_decode($hospital->images,true);
													$clinicimg = is_array($clinicimg)?$clinicimg:[];
												@endphp
												@foreach ($clinicimg as $clinicimg1)
											    		@php $imgname = 'storage/HospitalImages/'.$clinicimg1; @endphp
													{{-- <li> --}}
														<a href="{{url($imgname)}}" data-fancybox="gallery">
															<img src="{{url($imgname)}}" height="100px"  width="150px" alt="Feature">
														</a>
													{{-- </li> --}}

												@endforeach
				
											</ul>
										</div>
									</div>
								</div>
								<div class="doc-info-right">
									<div class="clini-infos">
										<ul>
											<li><i class="fa fa-user"></i> {{$hospital->contact_person}} </li>
											<li><i class="fa fa-mobile"></i> {{$hospital->person_number}} </li>
											<li><i class="fa fa-circle"></i> {{$hospital->person_designation}}</li>
									
										</ul>
									</div>
								
								</div>
							</div>
						</div>
					</div>
					<!-- /Doctor Widget -->
					

				</div>
			</div>		
			<!-- /Page Content -->

@endsection
@push('script')
	<script src="{{asset('assets1/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
@endpush