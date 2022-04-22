@extends('admin.layouts.admin')


@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-7 col-auto">
            <h3 class="page-title">Show Role & Permissions</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Role & Permissions</li>
            </ul>
        </div>
        <div class="col-sm-5 col">
            <a class="btn btn-primary float-right mt-2" href="{{ route('admin.roles.index') }}"> Back</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>Name </span></b>
                        </div>
                        <div class="col-sm-8 mb-2">
                            {{$role->name}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 col-sm-offset-2">
                            <b><span>Permission : </span></b>
                        </div>
                        <div class="col-sm-10 mb-2">
                            <div class="form-group row">
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $value)
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="permission[]" disabled id="" checked value="{{$value->id}}" class="name">
                                            <label>{{ $value->name }} </label>
                                            
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>
@endsection