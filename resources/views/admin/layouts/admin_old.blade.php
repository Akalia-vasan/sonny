<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('setting.AppTitle') }}</title>

    <link type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" rel="icon">
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/feathericon.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css')}}">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/animate.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    <script src="{{  URL::asset('ckeditor/ckeditor.js') }}"></script>
    <!-- Toastar-->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
      <!-- Sweet Alert -->
      <link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet"> 
      <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">

      <link href="{{ asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
      <link href="{{ asset('css/plugins/clockpicker/clockpicker.css')}}" rel="stylesheet">
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    @stack('style')

</head>

<body>
<style>
    .error{
        color:red;
    }
</style>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        
                        <div class="logo text-center">
                            @if($settings->logo !=null)
                                <img src="{{ url('storage').'/'.$settings->logo }}">
                            @else
                                <img height="100px" width="100px" src="{{ asset('img/kc-logo.png') }}">
                            @endif
                        </div>
                    </li>
                    <li class="@if(Request::is('admin/home*')) active @endif">
                        <a href="{{ route('admin.home') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    <li class="@if(Request::is('admin/user*')) active @endif">
                        <a href="{{ route('admin.user.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Manage Users</span></a>
                    </li>
                    <li class="@if(Request::is('admin/doctor*')) active @endif">
                        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Manage Doctor </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="@if(Request::is('admin/doctor*')) active @endif">
                                <a href="{{ route('admin.doctor') }}"><i class="fa fa-users"></i> <span class="nav-label">Manage Doctor</span></a>
                            </li>
                        </ul> 
                    </li>

                    <li class="@if(Request::is('admin/product*')) active @endif">
                        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Manage All Product </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="@if(Request::is('admin/product/category*')) active @endif"><a href="{{ route('admin.category.index') }}"> <span class="nav-label">Product Category List </span></a></li>
                            <li class="@if(Request::is('admin/product*')) active @endif"><a href="{{ route('admin.product.index') }}"> <span class="nav-label">All Product List</span></a><li>
                        </ul>
                    </li>

                    <li class="@if(Request::is('admin/content*')) active @endif">
                        <a href="#"><i class="fa fa-mobile"></i> <span class="nav-label">Manage Content Screen</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="@if(Request::is('admin/content/appcontent*')) active @endif"><a href="{{ route('admin.appcontent') }}"> <span class="nav-label">App Content</span></a></li>
                            <li class="@if(Request::is('admin/content/faqcategory*')) active @endif"><a href="{{ route('admin.faqcategory.index') }}"> <span class="nav-label">FAQ Category</span></a></li>
                            <li class="@if(Request::is('admin/content/faq*')) active @endif"><a href="{{ route('admin.faq.index') }}"> <span class="nav-label">FAQ</span></a></li>
                        </ul>
                    </li>
                    <li class="@if(Request::is('admin/enquiry*')) active @endif">
                        <a href="{{ route('admin.enquiry') }}"><i class="fa fa-question-circle"></i> <span class="nav-label">Manage Enquiry</span></a>
                    </li>
                    <li class="@if(Request::is('admin/setting*')) active @endif">
                        <a href="{{ route('admin.setting') }}"><i class="fa fa-cogs"></i> <span class="nav-label">Manage Settings</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li style="padding: 20px">
                        <span class="m-r-sm text-muted welcome-message">Welcome to {{ __('setting.AppName') }}</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  
                            <span class="label label-primary">
                                 @if(isset($notifications))
                                    {{ $notifications }}
                                @else
                                    0
                                @endif
                            </span>
                        </a>
                        @if(isset($notify))
                            @if($notifications>0)
                                <ul class="dropdown-menu dropdown-alerts">
                                    @foreach ($notify as $notify1)
                                        <li>
                                            <a href="{{ route('admin.user.get.devices', $notify1->id)}}" class="dropdown-item">
                                                <div>
                                                    <i class="fa fa-circle fa-fw"></i> {{$notify1->user_name}} 
                                                    <span class="float-right text-muted small">Device-{{($notify1->name)}} Lost Report </span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="dropdown-divider"></li>
                                    @endforeach
                                </ul>
                                @else 
                                    <ul class="dropdown-menu dropdown-alerts">
                                            <li>
                                                <a href="javascript:void(0)" class="dropdown-item">
                                                    <div>
                                                        Notification Not Available  
                                                    </div>
                                                </a>
                                            </li>
                                    </ul>
                                @endif
                        @endif
                         
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>

                </nav>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
            <div class="footer">
              
                <div class="float-right">
                    {!! $settings->copyright ?? "<strong>Copyright</strong> " . __('setting.AppName') . ' &copy; ' . now()->year !!}
                </div>
                <div>
                    {{-- $settings->copyright <strong>Copyright</strong> {{{ __('setting.AppName') }}} &copy; {{ now()->year }} --}}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
     <!-- Peity -->
     <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>

     <!-- Peity -->
     <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

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
