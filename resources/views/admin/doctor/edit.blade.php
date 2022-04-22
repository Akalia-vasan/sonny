@extends('admin.layouts.admin')
@push('style')
    {{-- <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}"> --}}

    <link rel="stylesheet" href="{{ asset('assets1/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/dropzone/dropzone.min.css')}}">
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Doctors Edit</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctors Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <form action="{{ route('admin.doctor.update',$editdoctor->id) }}" method="post" enctype="multipart/form-data">
                @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic Information</h4>
                        <div class="row form-row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type <span class="text-danger">*</span></label>
                                    <select class="form-control select floating @error('type') is-invalid @enderror" name="type" id="select_type" required>
                                        <option value="0">-- Select Type --</option>
                                        <option  {{ $editdoctor->type == 'Individual' ? "selected" : "" }} value="Individual">Individual</option>
                                        <option  {{ $editdoctor->type == 'Hospital' ? "selected" : "" }} value="Hospital">Hospital</option>
                                        <option  {{ $editdoctor->type == 'Clinic' ? "selected" : "" }} value="Clinic">Clinic</option>
                                        <option  {{ $editdoctor->type == 'Lab' ? "selected" : "" }} value="Lab">Lab</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @if ($editdoctor->entity_id!=null)
                                <div class="col-md-6" id="divhid">
                                    <div class="form-group">
                                        <label>Entity <span class="text-danger">*</span></label>
                                        <select class="form-control select floating @error('entity_id') is-invalid @enderror" name="entity_id" id="entity_id" required>
                                            <option value="0">-- Select Entity --</option>
                                            @foreach ($selentity as $entity)
                                                <option {{ $editdoctor->entity_id == $entity->id ? "selected" : "" }}  value="{{$entity->id}}">{{$entity->name}}</option>   
                                            @endforeach
                                        </select>
                                        @error('entity_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                            @endif
                     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{$editdoctor->name}}" class="form-control floating @error("name") is-invalid @enderror" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="lname" value="{{$editdoctor->l_name}}" class="form-control floating @error('lname') is-invalid @enderror" required>
                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{$editdoctor->email}}" class="form-control floating @error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" value="{{$editdoctor->mobile}}"  class="form-control floating @error('mobile') is-invalid @enderror" required>
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
                                    <select class="form-control select floating @error('gender') is-invalid @enderror" name="gender" required>
                                        <option value="0">-- Select Gender --</option>
                                        <option {{ $editdoctor->gender == 'Male' ? "selected" : "" }} value="Male">Male</option>
                                        <option  {{ $editdoctor->gender == 'Female' ? "selected" : "" }} value="Female">Female</option>
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
                                    <div class="cal-icon">
                                        <input type="text" name="dob" value="{{$editdoctor->dob}}" class="form-control floating @error('dob') is-invalid @enderror datetimepicker" required>
                                    </div>
                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Speciality <span class="text-danger">*</span></label>
                                    <select  type="text" class="form-control select floating @error('speciality_id ') is-invalid @enderror" name="speciality_id" required>
                                        <option value="0">-- Select Speciality --</option>
                                        @foreach ($department as $Speciality)
                                            <option   {{ $editdoctor->speciality_id == $Speciality->id ? "selected" : "" }}  value="{{$Speciality->id}}">{{$Speciality->sp_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id ')
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
                        <h4 class="card-title">About Me</h4>
                        <div class="form-group mb-0">
                            <label>Biography</label>
                            <textarea class="form-control floating @error('about_me') is-invalid @enderror" name="about_me" rows="5" required> {{$editdoctor->about}}</textarea>
                            @error('about_me')
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
                        <h4 class="card-title">Clinic Info</h4>
                        <div class="row form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Clinic Name</label>
                                    <input type="text" name="clinic_name"  value="{{$editdoctor->doctorclinics->clinic_name}}" class="form-control floating @error('clinic_name') is-invalid @enderror" required>
                                    @error('clinic_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Clinic Address</label>
                                    <input type="text" name="clinic_address" value="{{$editdoctor->doctorclinics->clinic_address}}" class="form-control floating @error('clinic_address') is-invalid @enderror" required>
                                    @error('clinic_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Clinic Images</label>
                                    <input type="file" name="clinic_images[]" id="clinic_images" accept="image/*" multiple class="form-control floating @error('clinic_images') is-invalid @enderror" >
                                    @error('clinic_images')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="upload-wrap" id="imgdiv">
                                    @if ($editdoctor->doctorclinics && $editdoctor->doctorclinics->clinic_images!=null)
                                        @php 
                                            $images = json_decode($editdoctor->doctorclinics->clinic_images,true);
                                            $array = is_array($images) ? $images : [] ;
                                        @endphp
                                        @foreach ($array as $array1)
                                            @php $imageurl = 'storage/ClinicImage/'.$editdoctor->id.'/'.$array1; @endphp
                                            <div class="upload-images">
                                                <img src="{{ url($imageurl)}}" alt="Upload Image">
                                                <a href="{{ route('admin.doctor.clinicimage.delete',['id' => $editdoctor->id,'name'=>$array1])}}" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
											</div>
                                        @endforeach
                                        
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Clinic Info -->

                <!-- Contact Details -->
                <div class="card contact-card">
                    <div class="card-body">
                        <h4 class="card-title">Contact Details</h4>
                        <div class="row form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address Line 1</label>
                                    <input type="text" name="address_line1" value="{{$editdoctor->address_line1}}" class="form-control floating @error('address_line1') is-invalid @enderror" required>
                                    @error('address_line1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address Line 2</label>
                                    <input type="text" name="address_line2" value="{{$editdoctor->address_line2}}" class="form-control floating @error('address_line2') is-invalid @enderror" required>
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
                                            <option  {{ $editdoctor->area_id == $area->id ? "selected" : "" }} value="{{$area->id}}">{{$area->area}}</option>
                                        @endforeach
                                    </select>
                                    @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <select  type="text" class="form-control select floating @error('state') is-invalid @enderror" name="state" id="select_state" required>
                                        <option value="0">-- Select State --</option>
                                        @foreach ($states as $states1)
                                            <option  {{ $editdoctor->state_id == $states1->id ? "selected" : "" }} value="{{$states1->id}}">{{$states1->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <select  type="text" class="form-control select floating @error('city') is-invalid @enderror" name="city" id="select_city" required>
                                        <option value="0">-- Select City --</option>
                                        @isset($selectedcities)
                                            @foreach($selectedcities as $selectedcities1)
                                                <option  {{ $editdoctor->city_id == $selectedcities1->id ? 'selected' : '' }} value="{{ $selectedcities1->id}}">{{ $selectedcities1->name }}</option>
                                            @endforeach
                                        @endisset
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
                                    <label class="control-label">Postal Code/Zipcode</label>
                                    <input type="text" value="{{ $editdoctor->pin_code }}" name="zip" class="form-control floating @error('zip') is-invalid @enderror" required>
                                    @error('zip')
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Pricing</h4>
                        
                        <div class="form-group mb-0">
                            <div id="pricing_select">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="price_free" name="rating_option" class="custom-control-input" value="price_free" {{ $editdoctor->price==0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="price_free">Free</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="price_custom" name="rating_option" value="custom_price" {{ $editdoctor->price > 0 ? 'checked' : '' }} class="custom-control-input">
                                    <label class="custom-control-label" for="price_custom">Custom Price (per hour)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row custom_price_cont" id="custom_price_cont" {{ $editdoctor->price > 0 ? 'style="display: block;"' : 'style="display: none;"' }} >
                            <div class="col-md-4">
                                <input type="number" class="form-control" id="custom_rating_input" name="price" value="{{ $editdoctor->price }}" placeholder="Custom Price">
                                <small class="form-text text-muted">Custom price you can add</small>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /Pricing -->
        
                <!-- Services and Specialization -->
                <div class="card services-card">
                    <div class="card-body">
                        <h4 class="card-title">Services and Specialization</h4>
                        <div class="form-group">
                            <label>Services</label>
                            <input type="text" data-role="tagsinput" class="input-tags form-control floating @error('services') is-invalid @enderror" placeholder="Enter Services" name="services" value="{{$editdoctor->services}}" id="services" required>
                            <small class="form-text text-muted">Note : Type & Press enter to add new services</small>
                            @error('services')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> 
                        <div class="form-group mb-0">
                            <label>Specialization </label>
                            <input class="input-tags form-control floating @error('specialist') is-invalid @enderror" type="text" data-role="tagsinput" placeholder="Enter Specialization" name="specialist" value="{{$editdoctor->specialisations}}"  id="specialist" required>
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
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Education</h4>
                        <div class="education-info">
                            <div class="row form-row education-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    @if (count($editdoctor->doctoreducation)>0)
                                        @foreach ($editdoctor->doctoreducation as $education)
                                            <div class="row form-row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Degree</label>
                                                        <input type="text" name="college_degree[]" value="{{$education->degree}}" class="form-control floating @error('college_degree') is-invalid @enderror " required>
                                                        @error('college_degree')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>College/Institute</label>
                                                        <input type="text" name="college_name[]"  value="{{$education->college}}"  class="form-control floating @error('college_name') is-invalid @enderror" required>
                                                        @error('college_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Year of Completion</label>
                                                        <input type="text" name="college_year[]"  value="{{$education->year}}"  class="form-control floating @error('college_year') is-invalid @enderror yearpicker" required>
                                                        @error('college_year')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-education"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <!-- /Education -->

                <!-- Experience -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Experience</h4>
                        <div class="experience-info">
                            <div class="row form-row experience-cont">
                                <div class="col-12 col-md-10 col-lg-11">
                                    @if (count($editdoctor->doctorexperience)>0)
                                        @foreach ($editdoctor->doctorexperience as $experience)
                                            <div class="row form-row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Hospital Name</label>
                                                        <input type="text" name="hospital_name[]" value="{{$experience->hospital_name}}"  class="form-control floating @error('hospital_name') is-invalid @enderror" required>
                                                        @error('hospital_name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>From</label>
                                                        <input type="text" name="start_from[]" value="{{$experience->start_from}}" class="form-control floating @error('start_from') is-invalid @enderror yearpicker" required>
                                                        @error('start_from')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>To</label>
                                                        <input type="text" name="start_to[]" value="{{$experience->start_to}}" class="form-control floating @error('start_to') is-invalid @enderror yearpicker" required>
                                                        @error('start_to')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Designation</label>
                                                        <input type="text" name="designation[]" value="{{$experience->designation}}"  class="form-control floating @error('designation') is-invalid @enderror" required>
                                                        @error('designation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div> 
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-experience"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <!-- /Experience -->
        
                <!-- Awards -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Awards</h4>
                        <div class="awards-info">
                            @if (count($editdoctor->doctorAwards)>0)
                                @foreach ($editdoctor->doctorAwards as $awards)
                                    <div class="row form-row awards-cont">
                                        <div class="col-12 col-md-5">
                                            <div class="form-group">
                                                <label>Awards</label>
                                                <input type="text" name="award_name[]" value="{{$awards->award}}" class="form-control  floating @error('award_name') is-invalid @enderror" required>
                                                @error('award_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="text" name="award_year[]" value="{{$awards->year}}" class="form-control  floating @error('award_year') is-invalid @enderror yearpicker" required>
                                                @error('award_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> 
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-award"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <!-- /Awards -->
                
                <!-- Memberships -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Memberships</h4>
                        <div class="membership-info">
                            @if (count($editdoctor->doctormembership)>0)
                                @foreach ($editdoctor->doctormembership as $membership)
                                    <div class="row form-row membership-cont">
                                        <div class="col-12 col-md-10 col-lg-5">
                                            <div class="form-group">
                                                <label>Memberships</label>
                                                <input type="text" name="membership[]" value="{{$membership->membership}}"  class="form-control floating @error('membership') is-invalid @enderror" required>
                                                @error('membership')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> 
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-membership"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <!-- /Memberships -->
        
                <!-- Registrations -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Registrations</h4>
                        <div class="registrations-info">
                            @if (count($editdoctor->doctorregistration)>0)
                                @foreach ($editdoctor->doctorregistration as $registration)
                                    <div class="row form-row reg-cont">
                                        <div class="col-12 col-md-5">
                                            <div class="form-group">
                                                <label>Registrations</label>
                                                <input type="text" name="registration_name[]"  value="{{$registration->registration}}" class="form-control floating @error('registration_name') is-invalid @enderror" required>
                                                @error('registration_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> 
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <div class="form-group">
                                                <label>Year</label>
                                                <input type="text" name="registration_year[]" value="{{$registration->year}}" class="form-control floating @error('registration_year') is-invalid @enderror yearpicker " required>
                                                @error('registration_year')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> 
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="add-more">
                            <a href="javascript:void(0);" class="add-reg"><i class="fa fa-plus-circle"></i> Add More</a>
                        </div>
                    </div>
                </div>
                <!-- /Registrations -->
                
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
        
        $(document).ready(function()
        {
            if($('.yearpicker').length > 0) {
                $('.yearpicker').datetimepicker({
                    format: 'YYYY',
                    icons: {
                        up: "fas fa-chevron-up",
                        down: "fas fa-chevron-down",
                        next: 'fas fa-chevron-right',
                        previous: 'fas fa-chevron-left'
                    }
                });
            }

                $('#select_type').change(function()
                {
                    var id = $(this).val();
                    if(id!=0)
                    {
                        alert(id);
                        $.ajax({
                            url : "{{ route( 'admin.doctor.getentity' ) }}",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                state_id: id,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response)
                            {
                                console.log(response);
                                if(response.cities && response.cities.length>0)
                                { 
                                    $("#entity_id").html(''); 
                                    $("#entity_id").append('<option value="0">-- Select City --</option>');
                                    for(var i=0; i<response.cities.length; i++)
                                    {
                                        console.log( response.cities[i].name);
                                            var id = response.cities[i].id;
                                            var name =response.cities[i].name;
                                        $("#entity_id").append('<option value='+id+'>'+name+'</option>'); 
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