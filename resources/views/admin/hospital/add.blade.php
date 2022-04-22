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
                <h3 class="page-title">Hospital Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hospital Add</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row" style="display:block;">
        <form action="{{ route('admin.hospital.store') }}" method="post" enctype="multipart/form-data">
                @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Hospital Name <span class="text-danger">*</span></label>
                                    <input type="text" name="hospital_name" value="{{old('hospital_name')}}" class="form-control floating @error('hospital_name') is-invalid @enderror" required>
                                    @error('hospital_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hospital Type <span class="text-danger">*</span></label>
                                    <select class="form-control select floating @error('type') is-invalid @enderror" name="type" required>
                                        <option value="0">-- Select Hospital Type --</option>
                                        <option {{ old('type') == 'Private Hospital' ? "selected" : "" }} value="Private Hospital">Private Hospital</option>
                                        <option {{ old('type') == 'Covid Care Center' ? "selected" : "" }} value="Covid Care Center">Covid Care Center</option>
                                        <option {{ old('type') == 'Complete Covid Hospital' ? "selected" : "" }} value="Complete Covid Hospital">Complete Covid Hospital</option>
                                        <option {{ old('type') == 'Multispeciality Hospital' ? "selected" : "" }} value="Multispeciality Hospital">Multispeciality Hospital</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Hospital Number <span class="text-danger">*</span></label>
                                    <input type="text" name="hospital_number" value="{{old('hospital_number')}}"  class="form-control floating @error('hospital_number') is-invalid @enderror" required>
                                    @error('hospital_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Hospital Email <span class="text-danger">*</span></label>
                                    <input type="text" name="hospital_email" value="{{old('hospital_email')}}" class="form-control floating @error('hospital_email') is-invalid @enderror" required>
                                    @error('hospital_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Hospital Rating <span class="text-danger">*</span></label>
                                    <input type="number" name="rating" max="5"  min="1" value="{{old('rating')}}"  class="form-control floating @error('rating') is-invalid @enderror" required>
                                    @error('rating')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Hospital Address <span class="text-danger">*</span></label>
                                    <input type="text" name="hospital_address" value="{{old('hospital_address')}}" class="form-control floating @error('hospital_address') is-invalid @enderror" required>
                                    @error('hospital_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Google Address <span class="text-danger">*</span></label>
                                    <input type="text" id="address-input"  name="google_address" value="{{old('google_address')}}" class="map-input form-control floating @error('google_address') is-invalid @enderror" required>
                                    @error('google_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                    
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Hospital Latitude <span class="text-danger">*</span></label>
                                    <input type="text" readonly  name="address_latitude"  id="address-latitude" value="{{old('address_latitude')}}"  class="form-control floating @error('address_latitude') is-invalid @enderror" required>
                                    @error('address_latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Hospital Longitude <span class="text-danger">*</span></label>
                                    <input type="text" readonly  name="address_longitude" id="address-longitude"  value="{{old('address_longitude')}}"  class="form-control floating @error('address_longitude') is-invalid @enderror" required>
                                    @error('address_longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div style="width: 100%; height: 100%" id="address-map"></div>
                                </div>  
                            </div>            
                
                       
                        </div>
                    </div>
                </div>
                <!-- /Basic Information -->

                  <!-- About Me -->
                  <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">About Hospital</h4>
                        <div class="form-group mb-0">
                            <label>Biography</label>
                            <textarea class="form-control floating @error('about') is-invalid @enderror" name="about" rows="5" required> {{old('about')}}</textarea>
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- /About Me -->
                 <!-- Clinic Info -->
                 <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Images</h4>
                        <div class="row form-row">
                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hospital Images</label>
                                    <input type="file" name="images[]" id="clinic_images" accept="image/*" multiple class="form-control floating @error('images') is-invalid @enderror" >
                                    @error('images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="upload-wrap" id="imgdiv">
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Clinic Info -->

                 <!-- Contact Details -->
                 <div class="card contact-card">
                    <div class="card-body">
                        <h4 class="card-title">Contact Person</h4>
                        <div class="row form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Person Name</label>
                                    <input type="text" name="contact_person" value="{{old('contact_person')}}" class="form-control floating @error('contact_person') is-invalid @enderror" required>
                                    @error('contact_person')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Person Number</label>
                                    <input type="text" name="person_number" value="{{old('person_number')}}" class="form-control floating @error('person_number') is-invalid @enderror" required>
                                    @error('person_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Person Designation</label>
                                    <input type="text" name="person_designation" value="{{old('person_designation')}}" class="form-control floating @error('person_designation') is-invalid @enderror" required>
                                    @error('person_designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- /Contact Details -->
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
    <script src="{{ asset('js/mapInput.js') }}"></script>

    <script>
    
    </script>
@endpush