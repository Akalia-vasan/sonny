@extends('admin.layouts.admin')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets1/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/dropzone/dropzone.min.css')}}">
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Banner Edit</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Banner Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">
                   
                <!-- Add Blog -->
                <form method="post" enctype="multipart/form-data" autocomplete="off" id="update_service" action="{{ route('admin.banner.update',$banner->id)}}">
                    @csrf

                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Banner Title <span class="text-danger">*</span></label>
                                    <input class="form-control floating @error('title') is-invalid @enderror" type="text" name="title" id="banner_title" value="{{$banner->title}}">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Banner Image <span class="text-danger">*</span></label>
                                    <input class="form-control floating @error('image') is-invalid @enderror" type="file"  height="50px" width="50px" name="image" id="image" >
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <img  height="50px" width="50px" src="{{ $banner->image }}"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Status </label>
                                    <input type="checkbox" name="status" class="form-control js-switch" {{ $banner->active==1 ? 'checked' : '' }} />
                                    @if($errors->has('status'))
                                        <div class="error">{{ $errors->first('status') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
                    </div>
                </form>
                <!-- /Add Blog -->


                </div>
            </div>
        </div>			
    </div>
    
@endsection
@push('script')
    <script src="{{ asset('assets1/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets1/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets1/js/profile-settings.js')}}"></script>
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#00D0F1' });
    </script>
@endpush