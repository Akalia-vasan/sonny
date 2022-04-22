<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('setting.AppTitle') }}</title>
        <link type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" rel="icon">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('assets/css/feathericon.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/feathericon.min.css')}}">
        
        <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
        <link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet"> 
        <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap-datetimepicker.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets1/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets1/plugins/fancybox/jquery.fancybox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" /> --}}
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">z
        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    </head>

    <body>  
        <style>
            .sidebar-menu ul ul a.active {
                text-decoration: none;
                background: #fff;
                color: #00d0f1;
                font-weight: bold;
            }
            .fas.fa-star.filled {
                color: #d29d1e;
            }
            .swal2-title {
                padding: .1em .1em 0;
            }
            .swal2-icon {
                margin: 1.0em auto .6em;
            }
        </style>
        @stack('style')
        <!-- Main Wrapper -->
        <div class="main-wrapper">
                
            <!-- Header -->
            <div class="header">
            
                <!-- Logo -->
                <div class="header-left" style="background: #00d0f1;">
                    <a href="{{ route('admin.home') }}" class="logo">
                        @if($settings->logo !=null)
                            <img src="{{ url('storage').'/'.$settings->logo }}">
                        @else
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        @endif
                    </a>
                    <a href="{{ route('admin.home') }}" class="logo logo-small">
                        {{-- @if($settings->logo !=null)
                            <img src="{{ url('storage').'/'.$settings->logo }}">
                        @else --}}
                            <img src="{{ asset('assets/img/favicon.png')}}" alt="Logo" width="30" height="30">
                        {{-- @endif --}}
                    </a>
                </div>
                <!-- /Logo -->
                
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fe fe-text-align-left"></i>
                </a>
                
                {{-- <div class="top-nav-search">
                    <form>
                        <input type="text" class="form-control" placeholder="Search here">
                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div> --}}
                
                <!-- Mobile Menu Toggle -->
                <a class="mobile_btn" id="mobile_btn">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- /Mobile Menu Toggle -->
                
                <!-- Header Right Menu -->
                <ul class="nav user-menu">

                    <!-- Notifications -->
                    <li class="nav-item dropdown noti-dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Notifications</span>
                                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar avatar-sm">
                                                    <img class="avatar-img rounded-circle" alt="User Image" src="{{ asset('img/profile_small.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                                    <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar avatar-sm">
                                                    <img class="avatar-img rounded-circle" alt="User Image" src="{{ asset('img/profile_small.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                                    <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar avatar-sm">
                                                    <img class="avatar-img rounded-circle" alt="User Image" src="{{ asset('img/profile_small.jpg')}}">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Charlene Reed</span> has booked her appointment to <span class="noti-title">Dr. Ruby Perrin</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                            {{-- <div class="topnav-dropdown-footer">
                                <a href="#">View all Notifications</a>
                            </div> --}}
                        </div>
                    </li>
                    <!-- /Notifications -->
                    
                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img class="rounded-circle" src="{{ asset('assets/img/profiles/avatar-01.jpg')}}" width="31" alt="Ryan Taylor"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('assets/img/profiles/avatar-01.jpg')}}" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="user-text">
                                    <h6>{{Auth::user()->name}}</h6>
                                    <p class="text-muted mb-0">Administrator</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('admin.setting') }}">Settings</a>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> &nbsp Log out
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <!-- /User Menu -->
                    
                </ul>
                <!-- /Header Right Menu -->
                
            </div>
            <!-- /Header -->
            
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
                    <div id="sidebar-menu" class="sidebar-menu">
                        <ul>
                            {{-- <li class="menu-title"> 
                                <span>Main</span>
                            </li> --}}
                            <li class="@if(Request::is('admin/home*')) active @endif"> 
                                <a href="{{ route('admin.home') }}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                            </li>
                            @can('appointment-list','appointment-create','appointment-update','appointment-delete')
                                <li class="@if(Request::is('admin/appointment*')) active @endif"> 
                                    <a href="{{ route('admin.appointment.index') }}"><i class="fe fe-layout"></i> <span>Appointments</span></a>
                                </li>
                            @endcan
                            @can('subadmin-list','subadmin-create','subadmin-update','subadmin-delete')
                                <li class="@if(Request::is('admin/subadmin*')) active @endif"> 
                                    <a href="{{ route('admin.subadmin.index') }}"><i class="fe fe-users"></i> <span>SubAdmin</span></a>
                                </li>
                            @endcan
                            <li class="submenu @if (Request::is('admin/speciality*')  || Request::is('admin/service*') || Request::is('admin/lab_test*') || Request::is('admin/area*')) active @endif ">
                                <a href="#"><i class="fe fe-document"></i> <span> Master Data</span> 
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    @can('speciality-list','speciality-create','speciality-update','speciality-delete')
                                        <li><a class="@if(Request::is('admin/speciality*')) active @endif" href="{{ route('admin.speciality.index') }}"> Specialities</a></li>
                                    @endcan
                                    @can('service-list','service-create','service-update','service-delete')
                                        <li><a class="@if(Request::is('admin/service*')) active @endif" href="{{ route('admin.service.index') }}"> <span class="nav-label">Beauty Clinic Services</span></a></li>
                                    @endcan
                                    @can('area-list','area-create','area-update','area-delete')
                                        <li><a class="@if(Request::is('admin/area*')) active @endif" href="{{ route('admin.area.index') }}"> <span class="nav-label">Areas</span></a><li>
                                    @endcan
                                    @can('labtest-list','labtest-create','labtest-update','labtest-delete')
                                        <li><a class="@if(Request::is('admin/lab_test*')) active @endif" href="{{ route('admin.lab_test.index') }}"> <span class="nav-label">Lab Tests</span></a></li>
                                    @endcan

                                    {{-- <li class="@if(Request::is('admin/nurse_booking*')) active @endif"> 
                                        <a href="{{ route('admin.nurse_booking') }}"><i class="fe fe-user-plus"></i> <span>Nurse Booking</span></a>
                                    </li>
                                    <li class="@if(Request::is('admin/nurse_booking*')) active @endif"> 
                                        <a href="{{ route('admin.nurse_booking') }}"><i class="fe fe-user-plus"></i> <span>Nurse Booking</span></a>
                                    </li>
                                    <li class="@if(Request::is('admin/nurse_booking*')) active @endif"> 
                                        <a href="{{ route('admin.nurse_booking') }}"><i class="fe fe-user-plus"></i> <span>Nurse Booking</span></a>
                                    </li> --}}
                                </ul>
                            </li>
                            {{-- <li class="@if(Request::is('admin/nurse_booking*')) active @endif"> 
                                <a href="{{ route('admin.nurse_booking') }}"><i class="fe fe-user-plus"></i> <span>Nurse Booking</span></a>
                            </li> --}}
                            @can('entity-list','entity-create','entity-update','entity-delete')
                                <li class="@if(Request::is('admin/entity*')) active @endif">
                                    <a href="{{ route('admin.entity') }}"><i class="fa fa-hospital-o" ></i> <span class="nav-label">  Manage Entities</span></a>
                                </li>
                            @endcan
                            
                            @can('doctor-list','doctor-create','doctor-update','doctor-delete')
                                <li class="@if(Request::is('admin/doctor*')) active @endif"> 
                                    <a href="{{ route('admin.doctor') }}"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
                                </li>
                            @endcan
                            
                            @can('patient-list')
                                <li class="@if(Request::is('admin/patient*')) active @endif">  
                                    <a href="{{ route('admin.patient.index') }}"><i class="fe fe-user"></i> <span>Patients</span></a>
                                </li>
                            @endcan
                            
                            @can('user-list','user-create','user-update','user-delete')
                                <li class="@if(Request::is('admin/user*')) active @endif">  
                                    <a href="{{ route('admin.user.index') }}"><i class="fe fe-user"></i> <span>Users</span></a>
                                </li>
                            @endcan
                            
                            @can('coupon-list','coupon-create','coupon-update','coupon-delete')
                                <li class="@if(Request::is('admin/coupon*')) active @endif"> 
                                    <a href="{{ route('admin.coupon.index') }}"><i class="fe fe-star-o"></i> <span>Coupon</span></a>
                                </li>
                            @endcan
                            
                            {{-- <li> 
                                <a href="javascript:void(0);"><i class="fe fe-star-o"></i> <span>Reviews</span></a>
                            </li>
                            <li> 
                                <a href="javascript:void(0);"><i class="fe fe-activity"></i> <span>Transactions</span></a>
                            </li> --}}
                           

                            {{-- <li class="submenu">
                                <a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="javascript:void(0);">Invoice Reports</a></li>
                                </ul>
                            </li> --}}
                            @can('blog-list','blog-create','blog-update','blog-delete')
                                <li class="submenu @if (Request::is('admin/b_category*')  || Request::is('admin/blog*')) active @endif ">
                                    <a href="#"><i class="fe fe-document"></i> <span> Blog </span> <span class="menu-arrow"></span></a>
                                    <ul style="display: none;"> 
                                        @can('blogtype-list','blogtype-create','blogtype-update','blogtype-delete')
                                            <li><a class="@if(Request::is('admin/b_category*')) active @endif" href="{{ route('admin.b_category.index') }}"> Blog Category</a></li>
                                        @endcan
                                        @can('blog-list','blog-create','blog-update','blog-delete')
                                            <li><a class="@if(Request::is('admin/blog')) active @endif" href="{{ route('admin.blog.index') }}"> Blogs </a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            
                            <li class="@if(Request::is('admin/profile')) active @endif"> 
                                <a href="{{ route('admin.profile') }}"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
                            </li>
                           
                            @can('role-list','role-create','role-update','role-delete')
                                <li class="@if(Request::is('admin/roles*')) active @endif"> 
                                    <a href="{{ route('admin.roles.index') }}"><i class="fe fe-lock"></i> <span>Roles And Permission</span></a>
                                </li>
                            @endcan
                            @can('setting-list','setting-update')
                                <li class="@if(Request::is('admin/setting*')) active @endif"> 
                                    <a href="{{ route('admin.setting') }}"><i class="fe fe-vector"></i> <span>Settings</span></a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Sidebar -->
            
            <!-- Page Wrapper -->
            <div class="page-wrapper">
            
                <div class="content container-fluid">
                    
                    @yield('content')
                    
                </div>			
            </div>
            <!-- /Page Wrapper -->

        </div>
        <!-- /Main Wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets1/plugins/select2/js/select2.min.js')}}"></script>
        <script src="{{ asset('assets1/js/moment.min.js')}}"></script>
        <script src="{{ asset('assets1/js/bootstrap-datetimepicker.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>    
        
        <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>  
        <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    	<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

        <script  src="{{ asset('assets/js/script.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>      
            $(document).ready(function() {
                @if(Session::has('success'))
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        width: 400,
                        title: '{{ Session::get('success') }}',
                        showConfirmButton: false,
                        timer: 6000,
                        timerProgressBar: true, 
                    })
                @endif
                @if(Session::has('failed'))
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        width: 400,
                        title: '{{ Session::get('failed') }}',
                        showConfirmButton: false,
                        timer: 6000,
                        timerProgressBar: true, 
                    })
                @endif
            });
        </script>

        @stack('script')

    </body>
</html>
