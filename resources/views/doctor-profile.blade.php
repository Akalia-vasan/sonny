@extends('layouts.app')

@section('content')
  <div class="content"> 
    <div class="container">

      <!-- Doctor Widget -->
      <div class="card">
        <div class="card-body">
          <div class="doctor-widget">
            <div class="doc-info-left">
              <div class="doctor-img">
                  @if ($doctordata->profile_image)
                    <img class="img-fluid" alt="User Image" src="{{$doctordata->profile_image}}">	
                  @else
                    <img class="img-fluid" alt="User Image" src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}">
                  @endif
              </div>
              <div class="doc-info-cont">
                <h4 class="doc-name">Dr. {{$doctordata->name}} {{$doctordata->l_name}}</h4>
                <p class="doc-speciality">{{$doctordata->email}}</p>
                <p class="doc-department"><img src="{{url($doctordata->getspeciality->sp_image)}}" class="img-fluid" alt="Speciality">{{$doctordata->getspeciality->sp_name}}</p>

                <div class="rating">
                  @for($i=0;$i<$doctordata->getRating->avg('rating');$i++)
                    <i class="fas fa-star filled"></i>
                  @endfor
                  @for($i=$doctordata->getRating->avg('rating');$i<5;$i++)
                    <i class="fas fa-star"></i>
                  @endfor
                  <span class="d-inline-block average-rating">({{$doctordata->getRating->count()}})</span>
                </div>
                <div class="clinic-details">
                  <p class="doc-location"><i class="fas fa-map-marker-alt"></i> {{$doctordata->getarea->area}}</p>
                  <ul class="clinic-gallery">
                    @php
                      $clinicimg = json_decode($doctordata->doctorclinics->clinic_images,true);
                      $clinicimg = is_array($clinicimg)?$clinicimg:[];
                    @endphp
                    @foreach ($clinicimg as $clinicimg1)
                          @php $imgname = 'storage/ClinicImage/'.$doctordata->id.'/'.$clinicimg1; @endphp
                      <li>
                        <a href="{{url($imgname)}}" data-fancybox="gallery">
                          <img src="{{url($imgname)}}" alt="Feature">
                        </a>
                      </li>

                    @endforeach
    
                  </ul>
                </div>
                <div class="clinic-services">
                  @php  
                    $specialization = explode(',',$doctordata->specialisations);
                    $specialization = is_array($specialization)?$specialization:[];
                  @endphp 
                  @foreach ($specialization as $specialization1)
                    <span class="mb-2"> {{$specialization1}} </span>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="doc-info-right">
              <div class="clini-infos">
                <ul>
                  <li><i class="far fa-thumbs-up"></i> {{($doctordata->getRating->avg('rating')*100)/5}}%</li>
                  <li><i class="far fa-comment"></i> {{$doctordata->getRating->count()}} Feedback</li>
                  <li><i class="fas fa-map-marker-alt"></i> {{$doctordata->getarea->area}}</li>
                  <li><i class="far fa-money-bill-alt"></i> ₹ {{$doctordata->price}} per hour </li>
                </ul>
              </div>
              <div class="doctor-action">
                {{-- <a href="javascript:void(0)" class="btn btn-white fav-btn">
                  <i class="far fa-bookmark"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-white msg-btn">
                  <i class="far fa-comment-alt"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#voice_call">
                  <i class="fas fa-phone"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-white call-btn" data-toggle="modal" data-target="#video_call">
                  <i class="fas fa-video"></i>
                </a> --}}
              </div>
              <div class="clinic-booking">
                 <a class="apt-btn" href="{{url('book').'/'.$doctordata->id}}">Book Appointment</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Doctor Widget -->
      
      <!-- Doctor Details Tab -->
      <div class="card">
        <div class="card-body pt-0">
        
          <!-- Tab Menu -->
          <nav class="user-tabs mb-4">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
              <li class="nav-item">
                <a class="nav-link " href="#doc_overview" data-toggle="tab">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#doc_locations" data-toggle="tab">Locations</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="#doc_reviews" data-toggle="tab">Reviews</a>
              </li>
              {{-- <li class="nav-item">
                <a class="nav-link" href="#doc_business_hours" data-toggle="tab">Business Hours</a>
              </li> --}}
            </ul>
          </nav>
          <!-- /Tab Menu -->
          
          <!-- Tab Content -->
          <div class="tab-content pt-0">
          
            <!-- Overview Content -->
            <div role="tabpanel" id="doc_overview" class="tab-pane fade ">
              <div class="row">
                <div class="col-md-12 col-lg-9">
                
                  <!-- About Details -->
                  <div class="widget about-widget">
                    <h4 class="widget-title">About Me</h4>
                    <p>{{ $doctordata->about }}</p>
                  </div>
                  <!-- /About Details -->
                
                  <!-- Education Details -->
                  <div class="widget education-widget">
                    <h4 class="widget-title">Education</h4>
                    <div class="experience-box">
                      <ul class="experience-list">
                        @if (count($doctordata->doctoreducation)>0)
                          @foreach ($doctordata->doctoreducation as $education)
                          
                            <li>
                              <div class="experience-user">
                                <div class="before-circle"></div>
                              </div>
                              <div class="experience-content">
                                <div class="timeline-content">
                                  <a href="javascript:;" class="name">{{$education->college}}</a>
                                  <div>{{$education->degree}}</div>
                                  <span class="time">{{$education->year}} </span>
                                </div>
                              </div>
                            </li>

                          @endforeach
                        @endif
          
                      </ul>
                    </div>
                  </div>
                  <!-- /Education Details -->
              
                  <!-- Experience Details -->
                  <div class="widget experience-widget">
                    <h4 class="widget-title">Work & Experience</h4>
                    <div class="experience-box">
                      <ul class="experience-list">
                        @if (count($doctordata->doctorexperience)>0)
                          @foreach ($doctordata->doctorexperience as $experience)
                            <li>
                              <div class="experience-user">
                                <div class="before-circle"></div>
                              </div>
                              <div class="experience-content">
                                <div class="timeline-content">
                                  <a href="javascript:;" class="name">{{ $experience->hospital_name }}</a>
                                  <span class="time">{{ $experience->start_from }} - {{ $experience->start_to }}</span>
                                  <span class="time">{{ $experience->designation }}</span>
                                </div>
                              </div>
                            </li>
                          @endforeach
                        @endif
                      </ul>
                    </div>
                  </div>
                  <!-- /Experience Details -->
            
                  <!-- Awards Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title">Awards</h4>
                    <div class="experience-box">
                      <ul class="experience-list">
                        @if (count($doctordata->doctorAwards)>0)
                          @foreach ($doctordata->doctorAwards as $awards1)
                            <li>
                              <div class="experience-user">
                                <div class="before-circle"></div>
                              </div>
                              <div class="experience-content">
                                <div class="timeline-content">
                                  <p class="exp-year">{{$awards1->year}}</p>
                                  <h4 class="exp-title">{{$awards1->award}}</h4>
                                </div>
                              </div>
                            </li>
                          @endforeach
                        @endif
              
                      </ul>
                    </div>
                  </div>
                  <!-- /Awards Details -->
                  
                  <!-- Services List -->
                  <div class="service-list">
                    <h4>Services</h4>
                    <ul class="clearfix">
                      @if ($doctordata->services!= null)
                        @foreach (explode(',',$doctordata->services) as $services1)
                          <li>{{$services1}} </li>
                        @endforeach
                      @endif
                    </ul>
                  </div>
                  <!-- /Services List -->
                  
                  <!-- Specializations List -->
                  <div class="service-list">
                    <h4>Specializations</h4>
                    <ul class="clearfix">
                      @if ($doctordata->specialisations!= null)
                        @foreach (explode(',',$doctordata->specialisations) as $specialisations1)
                          <li>{{$specialisations1}} </li>
                        @endforeach
                      @endif	
                    </ul>
                  </div>
                  <!-- /Specializations List -->

                </div>
              </div>
            </div>
            <!-- /Overview Content -->
            
            <!-- Locations Content -->
            <div role="tabpanel" id="doc_locations" class="tab-pane fade">
            
              <!-- Location List -->
              <div class="location-list">
                <div class="row">
                
                  <!-- Clinic Content -->
                  <div class="col-md-6">
                    <div class="clinic-content">
                      <h4 class="clinic-name"><a href="#"> {{ $doctordata->doctorclinics->clinic_name }}</a></h4>
                      <p class="doc-speciality"> {{ $doctordata->specialisations }} </p>
                  
                      <div class="clinic-details mb-0">
                        <h5 class="clinic-direction"> <i class="fas fa-map-marker-alt"></i> {{ $doctordata->doctorclinics->clinic_address }} </h5>
                        <ul>
                          @foreach ($clinicimg as $clinicimg1)
                              @php $imgname = 'storage/ClinicImage/'.$doctordata->id.'/'.$clinicimg1; @endphp
                            <li>
                              <a href="{{url($imgname)}}" data-fancybox="gallery">
                                <img src="{{url($imgname)}}" alt="Feature">
                              </a>
                            </li>

                          @endforeach
                          
                        </ul>
                      </div>
                    </div>
                  </div>
                  <!-- /Clinic Content -->
                  
                  <!-- Clinic Timing -->
                  <div class="col-md-4">
                    <div class="clinic-timing">
                      <div>
                        <p class="timings-days">
                          <span> Mon - Sat </span>
                        </p>
                        <p class="timings-times">
                          <span>10:00 AM - 2:00 PM</span>
                          <span>4:00 PM - 9:00 PM</span>
                        </p>
                      </div>
                      <div>
                      <p class="timings-days">
                        <span>Sun</span>
                      </p>
                      <p class="timings-times">
                        <span>10:00 AM - 2:00 PM</span>
                      </p>
                      </div>
                    </div>
                  </div>
                  <!-- /Clinic Timing -->
                  
                  <div class="col-md-2">
                    <div class="consult-price">
                      ₹ {{$doctordata->price}}
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Location List -->


            </div>
            <!-- /Locations Content -->
            
            <!-- Reviews Content -->
            <div role="tabpanel" id="doc_reviews" class="tab-pane fade show active">
            
              <!-- Review Listing -->
              <div class="widget review-listing">
                <ul class="comments-list">
                  @php $j=1; @endphp
                  @foreach ($doctordata->getRating as $value)
                    <li @if($j!=1 && $j!=2) style="display:none;" class="allshow" @endif>
                      <div class="comment">
                        @if ($value->getUser->user_profile)
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="{{$value->getUser->user_profile}}">
                        @else
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="{{asset('assets/img/patients/patient.jpg')}}">
                        @endif
                        <div class="comment-body">
                          <div class="meta-data">
                            <span class="comment-author"> {{$value->getUser->name}}</span>
                            <span class="comment-date">Reviewed   {{$value->created_at}}</span>
                            <div class="review-count rating">
                              @for($i=0;$i<$value->rating;$i++)
                                <i class="fas fa-star filled"></i>
                              @endfor
                              @for($i=$value->rating;$i<5;$i++)
                                <i class="fas fa-star"></i>
                              @endfor
                              
                            </div>
                          </div>
                          <p class="recommended"><i class="far fa-thumbs-up"></i> {{$value->type}}</p>
                          <p class="comment-content">
                            {{$value->feedback}}
                          </p>   
                        </div>
                      </div>
                    </li>
                  @php $j++; @endphp
                  @endforeach
                  <!-- Comment List -->
            
                  <!-- /Comment List --> 
                </ul>
                
                <!-- Show All -->
                @if (count($doctordata->getRating)>2)
                 <div class="all-feedback text-center">
                    <a href="javascript:void(0)" id="allshow" class="btn btn-primary btn-sm">
                      Show all feedback <strong>( {{count($doctordata->getRating)-2 }})</strong>
                    </a>
                 </div>
                @endif
                <!-- /Show All -->
                
              </div>
              <!-- /Review Listing -->
            @auth
              <div class="write-review">
                <h4>Write a review for <strong>Dr. {{$doctordata->name}} {{$doctordata->l_name}}</strong></h4>
                
                <!-- Write Review Form -->
                <form action="{{route('patient.add_review')}}" method="POST" autocomplete="off">
                  @csrf
                  <input type="hidden" name="doctor_id" value="{{$doctordata->id}}" required>
                  <div class="form-group">
                    <label>Review</label>
                    <div class="star-rating">
                      <input id="star-5" type="radio" name="rating" value="1" required>
                      <label for="star-5" title="5 stars">
                        <i class="active fa fa-star"></i>
                      </label>
                      <input id="star-4" type="radio" name="rating" value="2">
                      <label for="star-4" title="4 stars">
                        <i class="active fa fa-star"></i>
                      </label>
                      <input id="star-3" type="radio" name="rating" value="3">
                      <label for="star-3" title="3 stars">
                        <i class="active fa fa-star"></i>
                      </label>
                      <input id="star-2" type="radio" name="rating" value="4">
                      <label for="star-2" title="2 stars">
                        <i class="active fa fa-star"></i>
                      </label>
                      <input id="star-1" type="radio" name="rating" value="5">
                      <label for="star-1" title="1 star">
                        <i class="active fa fa-star"></i>
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Title of your review</label>
                    <input class="form-control" type="text" required name="type" placeholder="If you could say it in one sentence, what would you say?">
                  </div>
                  <div class="form-group">
                    <label>Your review</label>
                    <textarea id="review_desc" name="feedback" required maxlength="100" class="form-control"></textarea>
                    
                    <div class="d-flex justify-content-between mt-3"><small class="text-muted"><span id="chars">100</span> characters remaining</small></div>
                  </div>
                  <hr>
                  {{-- <div class="form-group">
                    <div class="terms-accept">
                      <div class="custom-checkbox">
                        <input type="checkbox" id="terms_accept">
                        <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
                      </div>
                    </div>
                  </div> --}}
                  <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Add Review</button>
                  </div>
                </form>
                <!-- /Write Review Form -->
                
              </div> 
            @endauth
              <!-- Write Review -->

              <!-- /Write Review -->
        
            </div>
            <!-- /Reviews Content -->
            
            <!-- Business Hours Content -->
            {{-- <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
              <div class="row">
                <div class="col-md-6 offset-md-3">
                
                  <!-- Business Hours Widget -->
                  <div class="widget business-widget">
                    <div class="widget-content">
                      <div class="listing-hours">
                        <div class="listing-day current">
                          <div class="day">Today <span>5 Nov 2019</span></div>
                          <div class="time-items">
                            <span class="open-status"><span class="badge bg-success-light">Open Now</span></span>
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Monday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Tuesday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Wednesday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Thursday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Friday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day">
                          <div class="day">Saturday</div>
                          <div class="time-items">
                            <span class="time">07:00 AM - 09:00 PM</span>
                          </div>
                        </div>
                        <div class="listing-day closed">
                          <div class="day">Sunday</div>
                          <div class="time-items">
                            <span class="time"><span class="badge bg-danger-light">Closed</span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /Business Hours Widget -->
              
                </div>
              </div>
            </div> --}}
            <!-- /Business Hours Content -->
            
          </div>
        </div>
      </div>
      <!-- /Doctor Details Tab -->

    </div>
  </div>
@endsection		
  @push('script')
  <script>
    $( "#allshow" ).click(function() {
      $( "#allshow" ).hide();
      $(".allshow").show();
    });
  </script>
  @endpush