<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('setting.AppTitle') }}</title>
        <link type="image/x-icon" href="{{ asset('assets1/img/favicon.png')}}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}" >
        <link rel="stylesheet" href="{{ asset('assets1/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/swiper/css/swiper.min.css')}}">

        @stack('style')
    </head>
    <body>

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
						<a href="{{url('/')}}" class="navbar-brand logo">
							@if($settings->logo !=null)
                                <img src="{{ url('storage').'/'.$settings->logo }}" class="img-fluid" alt="Logo">
                            @else
                                <img  src="{{ asset('assets1/img/logo.png')}}" class="img-fluid" alt="Logo">
                            @endif
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="{{url('/')}}" class="menu-logo">
								@if($settings->logo !=null)
                                    <img src="{{ url('storage').'/'.$settings->logo }}" class="img-fluid" alt="Logo">
                                @else
                                    <img  src="{{ asset('assets1/img/logo.png')}}" class="img-fluid" alt="Logo">
                                @endif
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<ul class="main-nav">
							<li class="has-submenu @if(Request::is('/')) active @endif">
								<a href="{{url('/')}}">Home</a>
							</li>
							{{-- @if (Auth::user())
								<li class="has-submenu @if(Request::is('home')) active @endif">
									<a href="{{ route('patient.home') }}">Dashboard</a>
								</li>
							@endif --}}
							<li class="has-submenu @if(Request::is('blog*')) active @endif">
								<a href="{{url('blog')}}">Blog</a>
							</li>
							{{-- <li class="has-submenu @if(Request::is('available/bed')) active @endif">
								<a href="{{url('available/bed')}}">Book Bed</a>
							</li> --}}

							<li class="login-link">
								<a href="{{route('loginview')}}">Login / Signup</a>
							</li>
						</ul>		 
					</div>		 
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header"> @if($settings->app_mobile !=null) {{$settings->app_mobile}} @endif</p>
							</div>
						</li>
						@if (Auth::user())
								<li class="nav-item dropdown has-arrow logged-item">
									<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
										<span class="user-img">
											
											@if (Auth::user()->profile_image != null)
												<img class="rounded-circle" src="{{Auth::user()->profile_image}}" width="31" alt="User Image">	
											@else
												<img class="rounded-circle" src="{{asset('assets1/img/patients/patient.jpg')}}" width="31" alt="User Image">
											@endif	
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right">
										<div class="user-header">
											<div class="avatar avatar-sm">
												@if (Auth::user()->profile_image)
													<img src="{{Auth::user()->profile_image}}" alt="User Image" class="avatar-img rounded-circle">
												@else
													<img src="{{asset('assets1/img/patients/patient.jpg')}}" alt="User Image" class="avatar-img rounded-circle">
												@endif	
											</div>
											<div class="user-text">
												<h6>{{Auth::user()->name}}</h6>
												<p class="text-muted mb-0">Patient</p>
											</div>
										</div>
										<a class="dropdown-item" href="{{ route('patient.home') }}">Dashboard</a>
										<a class="dropdown-item" href="{{ route('patient.change_profile') }}">Profile Settings</a>
										<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
											<i class="fa fa-sign-out"></i> Logout
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</div>
							</li>
						@else
							<li class="nav-item">
								<a class="nav-link header-login" href="{{route('loginview')}}">login / Signup </a>
							</li>
						@endif
						
					</ul>
				</nav>
			</header>
			<!-- /Header -->
        {{-- <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div> --}}
        @yield('content')
        <!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										@if($settings->logo !=null)
											<img src="{{ url('storage').'/'.$settings->logo }}" style="max-width:250px;" class="img-fluid" alt="Logo">
										@else
											<img  src="{{ asset('assets1/img/logo.png')}}" style="max-width:250px;" class="img-fluid" alt="Logo">
										@endif
										
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
				</div>
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

        <!-- jQuery -->
        <script src="{{ asset('assets1/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets1/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets1/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets1/plugins/select2/js/select2.min.js')}}"></script>
        <script src="{{ asset('assets1/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
        <script src="{{ asset('assets1/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
        <script src="{{ asset('assets1/js/circle-progress.min.js') }}"></script>
		<script src="{{ asset('assets1/plugins/swiper/js/swiper.min.js') }}"></script>
		<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="{{ asset('assets1/js/slick.js') }}"></script>
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
            });
        </script>

        @stack('script')
    </body>
</html>
