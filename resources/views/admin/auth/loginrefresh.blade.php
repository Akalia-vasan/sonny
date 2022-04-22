@extends('admin.auth.layouts.auth')

@section('content')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name"><img height="130px" width="130px" src="{{ asset('img/kc-2.png') }}"></h1>
        </div>
        @error('login')
        <div class="alert alert-danger text-left alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            {{ $message }}
        </div>
        @enderror
        <h3>Session Expired! Re-enter Password.</h3>
        <p></p>
        <p></p>
        <form class="m-t text-left" role="form" method="POST" action="{{ route('admin.validate_time') }}">
            @csrf

            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
                    <span class="input-group-append"> 
                        <button onclick="showPassword('password')" type="button" class="btn btn-primary">
                            <i id="showPasswordIcon" class="fa fa-eye-slash"></i>
                        </button> 
                    </span>
                </div>
                    @error('password')
                        *<small class="text-danger">{{ $message }}</small>
                    @enderror
                
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            {{-- <a href="#" class="pull-right"><small>Forgot password?</small></a> --}}
            <br>
            <br>
            <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
        </form>
        <p class="m-t"> <small> {!! $settings->copyright ?? "<strong>Copyright</strong> " . __('setting.AppName') . ' &copy; ' . now()->year !!}</small> </p>
   
    </div>
</div>

@endsection
