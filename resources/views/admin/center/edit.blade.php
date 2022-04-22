@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit Center</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit Center</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit Center</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.center.update',$allcenter->id) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Center Name</span></b>
                                        </div>
                                        <div class="col-sm-9 mb-2">
                                            <input type="hidden" class="form-control" name="id" value="{{ $allcenter->id}}" />
                                            <input type="text" class="form-control map-input" id="address-input" name="center_name" value="{{ $allcenter->center_name}}"/>
                                            @if($errors->has('center_name'))
                                            <div class="error">{{ $errors->first('center_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Lattitude </span></b>
                                        </div>
                                        <div class="col-sm-9 mb-2">
                                            <input type="text" class="form-control" id="address-latitude" value="{{ $allcenter->lattitude}}" name="address_latitude" readonly />
                                            @if($errors->has('address_latitude'))
                                            <div class="error">{{ $errors->first('address_latitude') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Longitude </span></b>
                                        </div>
                                        <div class="col-sm-9 mb-2">
                                            <input type="text" class="form-control" id="address-longitude" value="{{ $allcenter->longitude}}" name="address_longitude" readonly />
                                            @if($errors->has('address_longitude'))
                                            <div class="error">{{ $errors->first('address_longitude') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Status </span></b>
                                        </div>
                                        <div class="col-sm-9 mb-2">
                                            <input type="checkbox" name="status" class="js-switch" @if($allcenter->active == '1') checked @endif />
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
                                </div>
                                <div class="col-md-5">
                                    <div id="address-map-container" style="width:100%;height:400px; ">
                                        <div style="width: 100%; height: 100%" id="address-map"></div>
                                    </div>
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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="{{ asset('js/mapInput.js') }}"></script>
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    </script>
@endpush
