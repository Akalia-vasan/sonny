<html>
    <head>
        <title>{{ __('setting.AppName') }}</title>
        <link rel="shortcut icon" href="{{ asset('img/kc-220.png') }}" type="image/x-icon"> 

         <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <style>
             .container{
                    margin-top:250px;
                } 
            @media only screen and (min-width: 600px) {  
                .container{
                    margin-top:650px;
                }
            }
            /* @media only screen and (max-width: 600px) {  
                .container{
                    margin-top:650px;
                }    
            } */
           
      

            @media only screen and (min-width: 1200px) {

                .container{
                    margin-top:250px;
               }
            }
            @media only screen and (orientation: landscape) {   
  
                .container{
                    margin-top:250px;
                }
            }
        </style>
    </head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="col-md-12 text-center">
            @if($settings->logo !=null)
                <h1 class="logo-name"> <img src="{{ url('storage').'/'.$settings->logo }}"></h1>
            @else
                <h1 class="logo-name"><img height="130px" width="130px" src="{{ asset('img/kc-2.png') }}"></h1>
            @endif
    </div><br/>
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold text-center">Reset password</h2>

                    <p class="text-center">
                        Enter your new password will be reset .
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="{{route('change.password',$token_data)}}">
                                @csrf
                                <div class="form-group row text-center">
                                    <div class="col-sm-12 mb-2">
                                        @if($errors->has('token'))
                                            <div class="text-danger error">{{ $errors->first('token') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-2">
                                       <div class="input-group">
                                            <span class="input-group-prepend"> 
                                                <button onclick="myFunction2('password')" type="button" class="btn btn-primary"><i id="pass" class="fa fa-eye-slash"></i></button>
                                            </span>
                                            <input type="password" class="form-control" name="password"  id="password" placeholder="New Password" /> 
                                           
                                        </div>
                                        @if($errors->has('password'))
                                            <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-prepend"> 
                                                <button onclick="myFunction3('password-confirm')" type="button" class="btn btn-primary"><i id="conpass" class="fa fa-eye-slash"></i></button>
                                            </span>
                                            <input id="password-confirm" type="password" class="form-control form-control-lg round-40"
                                            name="password_confirmation" placeholder="Confirm Password">
                                            
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Send new password</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                {!! $settings->copyright ?? "<strong>Copyright</strong> " . __('setting.AppName') . ' &copy; ' . now()->year !!}
            </div>
        </div>
    </div>
            <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script>
        function myFunction2(id)
        {
            let el = $('#pass');
        
            if(el.hasClass('fa-eye-slash'))
            {
                el.removeClass('fa-eye-slash');
                el.addClass('fa-eye');
                $('#'+id).attr('type', 'text');
            }
            else
            {
                el.removeClass('fa-eye');
                el.addClass('fa-eye-slash');
                $('#'+id).attr('type', 'password');
            }
        }
        function myFunction3(id)
        {
            let el = $('#conpass');
        
            if(el.hasClass('fa-eye-slash'))
            {
                el.removeClass('fa-eye-slash');
                el.addClass('fa-eye');
                $('#'+id).attr('type', 'text');
            }
            else
            {
                el.removeClass('fa-eye');
                el.addClass('fa-eye-slash');
                $('#'+id).attr('type', 'password');
            }
        }
        </script>
    </body>
</html>