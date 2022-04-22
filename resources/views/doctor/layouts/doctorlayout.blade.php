<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('setting.AppTitle') }}</title>
        <link type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">
		<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('assets1/css/bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/select2/css/select2.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/dropzone/dropzone.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/css/style.css')}}">
		

        @stack('style')

    </head>

    <body>  
	<style> .header-nav { background-color: #20c0f3; } </style>
        <!-- Main Wrapper -->
        <div class="main-wrapper">
               
            <!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="{{route('doctor.home')}}" class="navbar-brand logo">
                            @if($settings->logo !=null)
                                <img src="{{ url('storage').'/'.$settings->logo }}" class="img-fluid" alt="Logo">
                            @else
                                <img  src="{{ asset('assets1/img/logo.png')}}" class="img-fluid" alt="Logo">
                            @endif
						</a>
					</div>
							 
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header">@if($settings->app_mobile !=null) {{$settings->app_mobile}} @endif</p>
							</div>
						</li>
						
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									@if(Auth::user()->profile_image!= null)
										<img src="{{Auth::user()->profile_image}}" alt="Doctor Image"  width="31" class="rounded-circle">
									@else
										<img src="{{asset('assets/img/profiles/avatar-01.jpg')}}" alt="Doctor Image"  width="31" class=" rounded-circle">
									@endif
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										@if(Auth::user()->profile_image!= null)
                                        	<img src="{{Auth::user()->profile_image}}" alt="Doctor Image" class="avatar-img rounded-circle">
										@else
											<img src="{{asset('assets/img/profiles/avatar-01.jpg')}}" alt="Doctor Image" class="avatar-img rounded-circle">
										@endif
									</div>
									<div class="user-text">
										<h6>{{Auth::user()->name}}</h6>
										<p class="text-muted mb-0">Doctor</p>
									</div>
								</div>
								<a class="dropdown-item" href="{{ route('doctor.home') }}">Dashboard</a>
								<a class="dropdown-item" href="{{ route('doctor.change_profile') }}">Profile Settings</a>
                                <a class="dropdown-item" href="{{ route('doctor.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
							</div>
						</li>
						<!-- /User Menu -->
						
					</ul>
				</nav>
			</header>
			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('doctor.home')}}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">@if(isset($breadcrumb)) {{$breadcrumb}} @else Dashboard @endif</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">@if(isset($breadcrumb)) {{$breadcrumb}} @else Dashboard @endif</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
            
            <!-- Page Content -->
			<div class="content">
				<div class="container-fluid">

                    <div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
							
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											@if (Auth::user()->profile_image)
												<img src="{{Auth::user()->profile_image}}" alt="User Image">
											@else
												<img src="{{asset('assets1/img/doctors/doctor-thumb-02.jpg')}}" alt="User Image">
											@endif
										</a>
										<div class="profile-det-info">
											<h3>Dr. {{ Auth::user()->name }} {{ Auth::user()->l_name }}</h3>
											
											<div class="patient-details">
												<h5 class="mb-0">{{ Auth::user()->specialisations }}</h5>
											</div>
											{{-- <div class="patient-details">
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> @if(Auth::user()->city_id != null) {{Auth::user()->getcity->name.' , ' }} @endif @if(Auth::user()->state_id != null) {{ Auth::user()->getstate->name.' , ' }} @endif  {{Auth::user()->getcountry->name}} </h5>
											</div> --}}
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li class="@if(Request::is('doctor/home*')) active @endif">
												<a href="{{ route('doctor.home')}}">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/appointment*')) active @endif">
												<a href="{{ route('doctor.appointment')}}">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/patient*')) active @endif">
												<a href="{{ route('doctor.patient')}}">
													<i class="fas fa-user-injured"></i>
													<span>My Patients</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/blogs*')) active @endif">
												<a href="{{ route('doctor.blog.index')}}">
													<i class="fa fa-file"></i>
													<span>My Blogs</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/profile/schedule-timing*')) active @endif">
												<a href="{{ route('doctor.schedule-timing')}}">
													<i class="fas fa-hourglass-start"></i>
													<span>Schedule Timings</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/profile/slot-timing*')) active @endif">
												<a href="{{ route('doctor.slot-timing')}}">
													<i class="fas fa-clock"></i>
													<span>Available Timings</span>
												</a>
											</li>
											{{-- <li>
												<a href="javascript:void(0);">
													<i class="fas fa-file-invoice"></i>
													<span>Invoices</span>
												</a>
											</li> --}}
											<li class="@if(Request::is('doctor/account*')) active @endif">
												<a href="{{ route('doctor.account')}}">
													<i class="fas fa-file-invoice-dollar"></i>
													<span>Accounts</span>
												</a>
											</li>
											<li class="@if(Request::is('doctor/profile/view-review*')) active @endif">
												<a href="{{ route('doctor.view-review')}}">
													<i class="fas fa-star"></i>
													<span>Reviews</span>
												</a>
											</li>
											{{-- <li>
												<a href="javascript:void(0);">
													<i class="fas fa-comments"></i>
													<span>Message</span>
													<small class="unread-msg">23</small>
												</a>
											</li> --}}
											<li class="@if(Request::is('doctor/profile/change-profile-setting*')) active @endif">
												<a href="{{ route('doctor.change_profile') }}">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											{{-- <li class="@if(Request::is('doctor/profile/change-social-link*')) active @endif">
												<a href="{{ route('doctor.change_social_link') }}">
													<i class="fas fa-share-alt"></i>
													<span>Social Media</span>
												</a>
											</li> --}}
											<li class="@if(Request::is('doctor/profile/change-password*')) active @endif">
												<a href="{{ route('doctor.change_password') }}">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="{{ route('doctor.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-md-7 col-lg-8 col-xl-9">
                    
                            @yield('content')

                        </div>
					</div>

                    
                </div>
			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				{{-- <div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img src="{{asset('assets1/img/footer-logo.png')}}" alt="logo">
									</div>
									<div class="footer-about-content">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
										<div class="social-icon">
											<ul>
												<li>
													<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
												</li>
												<li>
													<a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Patients</h2>
									<ul>
										<li><a href="javascript:void(0);">Search for Doctors</a></li>
										<li><a href="javascript:void(0);">Login</a></li>
										<li><a href="javascript:void(0);">Register</a></li>
										<li><a href="javascript:void(0);">Booking</a></li>
										<li><a href="javascript:void(0);">Patient Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-menu">
									<h2 class="footer-title">For Doctors</h2>
									<ul>
										<li><a href="javascript:void(0);">Appointments</a></li>
										<li><a href="javascript:void(0);">Chat</a></li>
										<li><a href="javascript:void(0);">Login</a></li>
										<li><a href="javascript:void(0);">Register</a></li>
										<li><a href="javascript:void(0);">Doctor Dashboard</a></li>
									</ul>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-contact">
									<h2 class="footer-title">Contact Us</h2>
									<div class="footer-contact-info">
										<div class="footer-address">
											<span><i class="fas fa-map-marker-alt"></i></span>
											<p> @if($settings->app_mobile !=null) {{$settings->app_address}} @endif </p>
										</div>
										<p>
											<i class="fas fa-phone-alt"></i>
											@if($settings->app_mobile !=null) {{$settings->app_mobile}} @endif
										</p>
										<p class="mb-0">
											<i class="fas fa-envelope"></i>
											@if($settings->app_mobile !=null) {{$settings->app_email}} @endif
										</p>
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div> --}}
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom">
					<div class="container-fluid">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0">{!! $settings->copyright ?? "<strong>Copyright</strong> " . __('setting.AppName') . ' &copy; ' . now()->year !!}</p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="javascript:void(0);">Terms and Conditions</a></li>
											<li><a href="javascript:void(0);">Policy</a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>
						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->

        </div>
        <!-- /Main Wrapper -->

		@stack('customportion')

        <!-- jQuery -->
        <script src="{{ asset('assets1/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets1/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets1/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets1/plugins/select2/js/select2.min.js')}}"></script>
		<script src="{{ asset('assets1/js/moment.min.js')}}"></script>
		<script src="{{ asset('assets1/js/bootstrap-datetimepicker.min.js')}}"></script>
        <script src="{{ asset('assets1/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
        <script src="{{ asset('assets1/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
        <script src="{{ asset('assets1/js/circle-progress.min.js') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    	<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>	
		<script src="{{ asset('assets1/plugins/dropzone/dropzone.min.js') }}"></script>
		<script src="{{ asset('assets1/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
		<script src="{{ asset('assets1/js/script.js') }}"></script>
		

        <script>      
            $(document).ready(function() {
                @if(Session::has('success'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 14000,
                        
                    };
                    toastr.success('{{ Session::get('success') }}');

                }, 1100);
                @endif
                @if(Session::has('failed'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 14000,
                        
                    };
                    toastr.danger('{{ Session::get('failed') }}');

                }, 1100);
                @endif

				@if(Session::has('error'))
                    Swal.fire({
						icon: 'error',
						title: '{{ Session::get('error') }}',
						text: 'Something went wrong!',			
						})
                @endif
            });
        </script>

        @stack('script')

    </body>
</html>
