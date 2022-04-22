@extends('admin.layouts.admin')

@push('style')
	<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">
	{{-- <link rel="stylesheet" href="{{ asset('assets1/plugins/fancybox/jquery.fancybox.min.css') }}"> --}}
@endpush
@section('content')

	<div class="content container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-sm-7 col-auto">
					<h3 class="page-title">Profile</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">User Profile</li>
					</ul>
				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="col-md-12">
				<div class="profile-header">
					<div class="row align-items-center">
						<div class="col-auto profile-image">
							<a href="#">
								@if ($userdata->profile_image)
									<img class="rounded-circle" alt="User Image" src="{{$userdata->profile_image}}">	
								@else
									<img class="rounded-circle" alt="User Image" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}">
								@endif
							</a>
						</div>
						<div class="col ml-md-n2 profile-user-info">
							<h4 class="user-name mb-0">{{$userdata->name}}</h4>
							<h6 class="text-muted">{{$userdata->email}}</h6>
							<div class="user-Location"><i class="fa fa-map-marker"></i> {{$userdata->name}}</div>
							<div class="about-text">{{$userdata->address}}</div>
						</div>
						
					</div>
				</div>
				<div class="profile-menu">
					<ul class="nav nav-tabs nav-tabs-solid">
						<li class="nav-item">
							<a class="nav-link active" data-bs-toggle="tab" >About</a>
						</li>
					</ul>
				</div>
				<div class="tab-content profile-tab-cont">
					<div class="tab-pane fade show active" id="per_details_tab">
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title d-flex justify-content-between">
											<span>Personal Details</span>
											{{-- <a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit me-1"></i>Edit</a> --}}
										</h5>
										<div class="row">
											<p class="col-sm-2 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
											<p class="col-sm-10">{{$userdata->name}}</p>
										</div>
										<div class="row">
											<p class="col-sm-2 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
											<p class="col-sm-10">{{$userdata->dob}}</p>
										</div>
										<div class="row">
											<p class="col-sm-2 text-muted text-sm-end mb-0 mb-sm-3">Email ID</p>
											<p class="col-sm-10">{{$userdata->email}}</p>
										</div>
										<div class="row">
											<p class="col-sm-2 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
											<p class="col-sm-10">{{$userdata->mobile}}</p>
										</div>
										<div class="row">
											<p class="col-sm-2 text-muted text-sm-end mb-0">Address</p>
											<p class="col-sm-10 mb-0">
												{{$userdata->address}}
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
@push('script')
	<script src="{{asset('assets1/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
@endpush