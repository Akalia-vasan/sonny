@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">General Settings</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:(0)">Settings</a></li>
                    <li class="breadcrumb-item active">General Settings</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        
        <div class="col-12">
            

         <!-- General -->
            
         <div class="card">
            <div class="card-header">
                <h4 class="card-title">Website & App Settings</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.setting.appname') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>App Name </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $name->id}}" name="id"/>
                            <input type="hidden" value="{{ $name->key}}" name="key"/>
                            <input type="text" class="form-control" name="appname"  value="{{ $name->value}}" />
                            @if($errors->has('appname'))
                            <div class="error">{{ $errors->first('appname') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>
                <form action="{{ route('admin.setting.app_version') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>App Verison </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $app_version->id}}" name="id"/>
                            <input type="hidden" value="{{ $app_version->key}}" name="key"/>
                            <input type="text" class="form-control" name="app_version"  value="{{ $app_version->value}}" />
                            @if($errors->has('app_version'))
                            <div class="error">{{ $errors->first('app_version') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>
                <form action="{{ route('admin.setting.copyright') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>Copyright </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $copyright->id}}" name="id"/>
                            <input type="hidden" value="{{ $copyright->key}}" name="key"/>
                            <input type="text" class="form-control" name="copyright"  value="{{ $copyright->value}}" />
                            @if($errors->has('copyright'))
                            <div class="error">{{ $errors->first('copyright') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>
                <form action="{{ route('admin.setting.logo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>Logo </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $logo->id}}" name="id"/>
                            <input type="hidden" value="{{ $logo->key}}" name="key"/>
                            <input type="file" class="form-control" name="logo"  value="{{ $logo->value}}" />
                            @if($errors->has('logo'))
                            <div class="error">{{ $errors->first('logo') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                        </div>
                        <div class="col-sm-7 mb-2">
                            @if ($logo->value)
                            <img src="{{  URL::to('storage/'.$logo->value) }}" id="img-uploaded" height="120px" width="220px" class="avatar-xl me-3 rounded-circle" alt="Logo Image">
                        @else 
                            <img src="{{ asset('img/profile_small.jpg') }}" id="img-uploaded" height="120px" width="120px" class="avatar-xl me-3 rounded-circle" alt="Logo Image" />
                        @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                        </div>
                    </div>
                
                </form>
                
                
                <form action="{{ route('admin.setting.app_address') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>App Address  </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $app_address->id}}" name="id"/>
                            <input type="hidden" value="{{ $app_address->key}}" name="key"/>
                            <input type="text" class="form-control" name="app_address"  value="{{ $app_address->value}}" />
                            @if($errors->has('app_address'))
                                <div class="error">{{ $errors->first('app_address') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>
                <form action="{{ route('admin.setting.app_email') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>App Email  </span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $app_email->id}}" name="id"/>
                            <input type="hidden" value="{{ $app_email->key}}" name="key"/>
                            <input type="text" class="form-control" name="app_email"  value="{{ $app_email->value}}" />
                            @if($errors->has('app_email'))
                            <div class="error">{{ $errors->first('app_email') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>
                <form action="{{ route('admin.setting.app_mobile') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>App Contact</span></b>
                        </div>
                        <div class="col-sm-7 mb-2">
                            <input type="hidden" value="{{ $app_mobile->id}}" name="id"/>
                            <input type="hidden" value="{{ $app_mobile->key}}" name="key"/>
                            <input type="text" class="form-control" name="app_mobile"  value="{{ $app_mobile->value}}" />
                            @if($errors->has('app_mobile'))
                            <div class="error">{{ $errors->first('app_mobile') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                        </div>
                    </div>
                
                </form>

            </div>
        </div>
    
    <!-- /General -->
                
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