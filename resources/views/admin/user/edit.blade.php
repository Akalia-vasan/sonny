@extends('admin.layouts.admin')

@section('content')


<div class="page-header">
    <div class="row">
        <div class="col-sm-10 col-auto">
            <h3 class="page-title">Edit User</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ul>
        </div>
        <div class="col-sm-2 col-auto">v</div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit User</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.user.update',$user->id) }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Name </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="hidden" class="form-control" name="id" value="{{ $user->id}}" />
                                    <input type="text" class="form-control" name="name" value="{{ $user->name}}" />
                                    @if($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Email </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="text" class="form-control" name="email" value="{{ $user->email}}" />
                                    @if($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Mobile </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="text" class="form-control" pattern="[6789][0-9]{9}" name="mobile" value="{{ $user->mobile}}" />
                                    @if($errors->has('mobile'))
                                    <div class="error">{{ $errors->first('mobile') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>password </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <div class="input-group">
                                        <span class="input-group-prepend"> 
                                            <button onclick="myFunction3('password')" type="button" class="btn btn-primary"><i id="conpass" class="fa fa-eye-slash"></i></button>
                                        </span>
                                        <input id="password" type="password" class="form-control" min="6" name="password" placeholder="Enter Password if you want to update Or Leave Blank"/>
                                        @if($errors->has('password'))
                                        <div class="error">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Status </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="checkbox" name="status" class="js-switch" @if($user->active == '1') checked @endif />
                                    @if($errors->has('status'))
                                    <div class="error">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button class="btn btn-primary btn-md" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#007BFF' });
        function myFunction3(id)
        {
            let el = $('#password');

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
