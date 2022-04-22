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
                <h3 class="page-title">Coupon Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Coupon Add</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row" style="display:block;">
        <form action="{{ route('admin.coupon.store') }}" method="post" >
                @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Coupon Code <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{old('code')}}" placeholder="Enter Coupon Code (min 8)" class="form-control text-uppercase floating @error('code') is-invalid @enderror" required>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-12 col-md-12" hidden>
                                <div class="form-group">
                                    <label>Coupon Type <span class="text-danger">*</span></label>
                                    <input type="text" name="type" value="fixed" class="form-control floating @error('type') is-invalid @enderror" required>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group ">
                                    <label>Valid From<span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" name="valid_from" placeholder="Enter Start Date" value="{{old('valid_from')}}" class="form-control floating @error('valid_from') is-invalid @enderror datetimepicker" required>
                                    
                                        @error('valid_from')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group ">
                                    <label>Valid To<span class="text-danger">*</span></label>
                                    <div class="cal-icon">
                                        <input type="text" name="valid_to"  placeholder="Enter End Date" value="{{old('valid_to')}}" class="form-control floating @error('valid_to') is-invalid @enderror datetimepicker" required>
                                    
                                        @error('valid_to')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Value<span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="value" placeholder="Enter Amount" value="{{old('value')}}" class="form-control floating @error('value') is-invalid @enderror" required>
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Max Uses<span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="max_uses" value="{{old('max_uses')}}" placeholder="Enter total no. uses this coupon" value="{{old('code')}}" class="form-control floating @error('max_uses') is-invalid @enderror" required>
                                    @error('max_uses')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control floating @error('description') is-invalid @enderror" required id="" rows="5">{{old('description')}}</textarea>
                                    @error('description')
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