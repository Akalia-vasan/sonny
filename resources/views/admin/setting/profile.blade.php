@extends('admin.layouts.admin')

@push('style')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Profile Settings</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:(0)">Profile</a></li>
                    <li class="breadcrumb-item active">Profile Settings</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        
        <div class="col-12">
            

         <!-- Profile -->
            
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Profile</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.setting.email') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-2 col-sm-offset-2">
                                <label>Admin Email </label>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <input type="hidden" value="{{ $admin_data->id}}" name="id"/>
                                <input type="text" class="form-control" name="email"  value="{{ $admin_data->email}}" />
                                @if($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-sm-3 col-sm-offset-2">
                                <button class="btn btn-primary btn-md" type="submit">Save</button>
                            </div>
                        </div>
                    
                    </form>
                    <form action="{{ route('admin.setting.password') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-2 col-sm-offset-2">
                                <label>Admin Password </label>
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="input-group">
                                    <input type="hidden" value="{{ $admin_data->id}}" name="id"/>
                                    <span class="input-group-prepend"> 
                                        <button onclick="myFunction1('old_password')" type="button" class="btn btn-primary"><i id="oldpass" class="fa fa-eye-slash"></i></button>
                                    </span>
                                    <input type="password" class="form-control" name="old_password" id="old_password"  placeholder="Old Password" />
                                    
                                </div>
                                @if($errors->has('old_password'))
                                <div class="error">{{ $errors->first('old_password') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-2 col-sm-offset-2">
                                
                            </div>
                            
                            <div class="col-sm-7 mb-2">
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
                            <div class="col-sm-2 col-sm-offset-2">
                            
                            </div>
                            <div class="col-sm-7 mb-2">
                                <div class="input-group">
                                    <span class="input-group-prepend"> 
                                        <button onclick="myFunction3('password-confirm')" type="button" class="btn btn-primary"><i id="conpass" class="fa fa-eye-slash"></i></button>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control form-control-lg round-40"
                                    name="password_confirmation" placeholder="Confirm Password">
                                    
                                </div>
                            </div>
                        
                            <div class="col-sm-3 col-sm-offset-2">
                                <button class="btn btn-primary btn-md" type="submit">Save</button>
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        
        <!-- /Profile -->
                
        </div>
    </div>
    
@endsection

@push('script')
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script>
function myFunction1(id)
{
    let el = $('#oldpass');

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
@endpush