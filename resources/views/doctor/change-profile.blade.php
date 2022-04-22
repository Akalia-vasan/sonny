@extends('doctor.layouts.doctorlayout')

@section('content')
<form action="{{route('doctor.update_profile')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Basic Information -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Basic Information</h4>
           
                <div class="row form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="change-avatar">
                                <div class="profile-img">
                                    @if(Auth::user()->profile_image!= null)
                                        <img src="{{Auth::user()->profile_image}}" alt="User Image">
                                    @else
                                        <img src="{{asset('assets/img/profiles/avatar-01.jpg')}}" alt="User Image">
                                    @endif
                                </div>
                                <div class="upload-img">
                                    <div class="change-photo-btn">
                                        <span><i class="fa fa-upload"></i> Upload Photo</span>
                                        <input type="file" name="profile_image" accept="image/*" class="upload">
                                    </div>
                                    <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                    @if($errors->has('profile_image'))  
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('profile_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" readonly>
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control floating @error('name') is-invalid @enderror" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="l_name" value="{{Auth::user()->l_name}}" class="form-control floating @error('l_name') is-invalid @enderror">
                            @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" value="{{Auth::user()->mobile}}" class="form-control floating @error('mobile') is-invalid @enderror">
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control select floating @error('gender') is-invalid @enderror">
                                <option {{Auth::user()->gender=='Male'?'selected':''}} value="Male">Male</option>
                                <option {{Auth::user()->gender=='Female'?'selected':''}} value="Female">Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <input type="text" name="dob" value="{{Auth::user()->dob}}" class="form-control datetimepicker floating @error('dob') is-invalid @enderror">
                            @error('dob')
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
    
    <!-- About Me -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">About Me </h4>
            <div class="form-group mb-0">
                <label>Biography <span class="text-danger">*</span></label>
                <textarea class="form-control floating @error('about') is-invalid @enderror" name="about" rows="5">{{Auth::user()->about}}</textarea>
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
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Clinic Info</h4>
            <div class="row form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Clinic Name</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Clinic Address</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Clinic Images</label>
                        <form action="#" class="dropzone"></form>
                    </div>
                    <div class="upload-wrap">
                        <div class="upload-images">
                            <img src="assets/img/features/feature-01.jpg" alt="Upload Image">
                            <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </div>
                        <div class="upload-images">
                            <img src="assets/img/features/feature-02.jpg" alt="Upload Image">
                            <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- /Clinic Info -->

    <!-- Contact Details -->
    <div class="card contact-card">
        <div class="card-body">
            <h4 class="card-title">Contact Details</h4>
            <div class="row form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line1" value="{{Auth::user()->address_line1}}" class="form-control floating @error('address_line1') is-invalid @enderror">
                        @error('address_line1')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Address Line 2 <span class="text-danger">*</span></label>
                        <input type="text" name="address_line2" value="{{Auth::user()->address_line2}}" class="form-control floating @error('address_line2') is-invalid @enderror">
                        @error('address_line2')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Area</label>
                        <select class="form-control select floating @error('area') is-invalid @enderror"  type="text" name="area" required>
                            <option value="0">-- Select Area --</option>
                            @foreach ($areas as $area)
                                <option  {{ Auth::user()->area_id == $area->id ? "selected" : "" }} value="{{$area->id}}">{{$area->area}}</option>
                            @endforeach
                        </select>
                        @error('area')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">State / Province <span class="text-danger">*</span></label>
                        <select class="form-control select floating @error('state') is-invalid @enderror"  name="state" id="select_state">
                            <option value="0" >--Select State--</option>
                            @foreach ($state as $states)
                                <option {{Auth::user()->state_id==$states->id?'selected':''}} value="{{$states->id}}">{{$states->name}}</option>   
                            @endforeach   
                        </select>
                        @error('state')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">City <span class="text-danger">*</span></label>
                        <select class="form-control select floating @error('city') is-invalid @enderror" name="city" id="select_city">
                            <option value="0">--Select City--</option>
                                @foreach ($city as $cities)
                                    <option {{Auth::user()->city_id==$cities->id?'selected':''}} value="{{$cities->id}}">{{$cities->name}}</option>   
                                @endforeach
                        </select>
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Postal Code <span class="text-danger">*</span></label>
                        <input type="text" name="pin_code" value="{{Auth::user()->pin_code}}" class="form-control floating @error('pin_code') is-invalid @enderror">
                        @error('pin_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- /Contact Details -->
    
    <!-- Pricing -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pricing</h4>
            
            <div class="form-group mb-0">
                <div id="pricing_select">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="price_free" name="rating_option" class="custom-control-input" value="price_free" checked>
                        <label class="custom-control-label" for="price_free">Free</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="price_custom" name="rating_option" value="custom_price" class="custom-control-input">
                        <label class="custom-control-label" for="price_custom">Custom Price (per hour)</label>
                    </div>
                </div>

            </div>
            
            <div class="row custom_price_cont" id="custom_price_cont" style="display: none;">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="custom_rating_input" name="custom_rating_count" value="" placeholder="20">
                    <small class="form-text text-muted">Custom price you can add</small>
                </div>
            </div>
            
        </div>
    </div> --}}
    <!-- /Pricing -->
    
    <!-- Services and Specialization -->
    <div class="card services-card">
        <div class="card-body">
            <h4 class="card-title">Services and Specialization <span class="text-danger">*</span></h4>
            <div class="form-group">
                <label>Services</label>
                <input type="text" data-role="tagsinput" class="input-tags form-control floating @error('services') is-invalid @enderror" placeholder="Enter Services" name="services" value="{{Auth::user()->services}}" id="services">
                <small class="form-text text-muted">Note : Type & Press enter to add new services</small>
                @error('services')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
            <div class="form-group mb-0">
                <label>Specialization  <span class="text-danger">*</span></label>
                <input class="input-tags form-control floating @error('specialist') is-invalid @enderror" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialist" value="{{Auth::user()->specialisations}}" id="specialist">
                <small class="form-text text-muted">Note : Type & Press  enter to add new specialization</small>
                @error('specialist')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
        </div>              
    </div>
    <!-- /Services and Specialization -->
 
    <!-- Education -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Education</h4>
            <div class="education-info">
                <div class="row form-row education-cont">
                    <div class="col-12 col-md-10 col-lg-11">
                        <div class="row form-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Degree</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>College/Institute</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Year of Completion</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-more">
                <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
        </div>
    </div> --}}
    <!-- /Education -->

    <!-- Experience -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Experience</h4>
            <div class="experience-info">
                <div class="row form-row experience-cont">
                    <div class="col-12 col-md-10 col-lg-11">
                        <div class="row form-row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Hospital Name</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control">
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-more">
                <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
        </div>
    </div> --}}
    <!-- /Experience -->
    
    <!-- Awards -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Awards</h4>
            <div class="awards-info">
                <div class="row form-row awards-cont">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label>Awards</label>
                            <input type="text" class="form-control">
                        </div> 
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label>Year</label>
                            <input type="text" class="form-control">
                        </div> 
                    </div>
                </div>
            </div>
            <div class="add-more">
                <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
        </div>
    </div> --}}
    <!-- /Awards -->
    
    <!-- Memberships -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Memberships</h4>
            <div class="membership-info">
                <div class="row form-row membership-cont">
                    <div class="col-12 col-md-10 col-lg-5">
                        <div class="form-group">
                            <label>Memberships</label>
                            <input type="text" class="form-control">
                        </div> 
                    </div>
                </div>
            </div>
            <div class="add-more">
                <a href="javascript:void(0);" class="add-membership"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
        </div>
    </div> --}}
    <!-- /Memberships -->
    
    <!-- Registrations -->
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">Registrations</h4>
            <div class="registrations-info">
                <div class="row form-row reg-cont">
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label>Registrations</label>
                            <input type="text" class="form-control">
                        </div> 
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label>Year</label>
                            <input type="text" class="form-control">
                        </div> 
                    </div>
                </div>
            </div>
            <div class="add-more">
                <a href="javascript:void(0);" class="add-reg"><i class="fa fa-plus-circle"></i> Add More</a>
            </div>
        </div>
    </div> --}}
    <!-- /Registrations -->
    
    <div class="submit-section submit-btn-bottom">
        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
    </div>
</form>

@endsection
@push('script')

    <script>
        $(document).ready(function()
        {
            $('#select_state').change(function()
            {
                var id = $(this).val();
                if(id>0)
                {
                    $.ajax({
                        url : "{{ route( 'doctor.getcity' ) }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            state_id: id,
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response)
                        {
                            if(response.cities && response.cities.length>0)
                            { 
                                $("#select_city").html(''); 
                                $("#select_city").append('<option value="0">-- Select City --</option>');
                                for(var i=0; i<response.cities.length; i++)
                                {
                                    console.log( response.cities[i].name);
                                        var id = response.cities[i].id;
                                        var name =response.cities[i].name;
                                    $("#select_city").append('<option value='+id+'>'+name+'</option>'); 
                                }
                                // $("#select_city").trigger('change');
                                // $('#select_city').val(null).trigger('change');
                            }

                        },
                        error: (err) => {
                            console.log(err);
                            swal("Error!", "", "error");
                        },
                    });
                }
            });
        });

    </script>

@endpush