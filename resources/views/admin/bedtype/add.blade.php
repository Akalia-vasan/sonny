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
                <h3 class="page-title">Bed Category Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Bed Category Add</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row" style="display:block;">
        <form action="{{ route('admin.bedtype.store') }}" method="post" enctype="multipart/form-data">
                @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Bed Type Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{old('name')}}" class="form-control floating @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Booking Percentage <span class="text-danger">*</span></label>
                                    <input type="number" name="booking_percentage" value="{{old('booking_percentage')}}" class="form-control floating @error('booking_percentage') is-invalid @enderror" required>
                                    @error('booking_percentage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Information -->
                <div class="submit-section submit-btn-bottom">
                    <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('script')
    <script src="{{ asset('assets1/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets1/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets1/js/profile-settings.js')}}"></script>
    <script>
    
    </script>
@endpush