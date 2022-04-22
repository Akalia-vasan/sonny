@extends('doctor.auth.layouts.auth')

@section('content')

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        @if(isset($settings) && $settings->logo !=null)
                            <h1 class="img-fluid"> <img src="{{ url('storage').'/'.$settings->logo }}" style="max-width:250px;" alt="Logo"></h1>
                        @else
                            <h1 class="img-fluid"><img src="{{ asset('assets/img/logo-white.png') }}" style="max-width:250px;" alt="Logo"></h1>
                        @endif
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            @error('login')
                                <div class="alert alert-danger text-left alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    {{ $message }}
                                </div>
                            @enderror
                            <h1>{{ __('setting.DoctorLogin') }}</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            
                            <!-- Form -->
                            <form method="POST" action="{{ route('doctor.login.submit') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        *<small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="password" required autofocus>
                                    @error('password')
                                        *<small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>
                            <!-- /Form -->
                            <p class="text-center"> <small> {!! $settings->copyright ?? "<strong>Copyright</strong> " . __('setting.AppName') . ' &copy; ' . now()->year !!}</small> </p>
        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->
@endsection
