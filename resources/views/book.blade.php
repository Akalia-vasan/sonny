@extends('layouts.app')

  @section('content')
      <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking</li>
                  </ol>
                </nav>
                <h2 class="breadcrumb-title">Booking</h2>
              </div>
            </div>
          </div>
        </div>
        <!-- /Breadcrumb -->
        
        <!-- Page Content -->
        <div class="content">
          <div class="container">
          
            <div class="row">
              <div class="col-12">
              
                <div class="card">
                  <div class="card-body">
                    <div class="booking-doc-info">
                      <a href="{{url('doctor-profile',$doctor->id)}}" class="booking-doc-img">
                        @if($doctor->profile_image !=null)
                          <img src="{{$doctor->profile_image}}" alt="Doctor Image">
                        @else
                          <img src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Doctor Image">
                        @endif
                      </a>
                      <div class="booking-info">
                        <h4><a href="{{url('doctor-profile',$doctor->id)}}">Dr. {{$doctor->name}} {{$doctor->l_name}}</a></h4>
                        <div class="rating">
                          @for($i=0;$i<$doctor->getRating->avg('rating');$i++)
                            <i class="fas fa-star filled"></i>
                          @endfor
                          @for($i=$doctor->getRating->avg('rating');$i<5;$i++)
                            <i class="fas fa-star"></i>
                          @endfor
                          <span class="d-inline-block average-rating">({{$doctor->getRating->count()}})</span>
                        </div>
                        <p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> @if($doctor->state_id != null) {{ $doctor->getstate->name.' , ' }} @endif  {{$doctor->getcountry->name}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-4 col-md-6">
                    <h4 class="mb-1">{{ Carbon\Carbon::now()->format('d F Y')}}</h4>
                    <p class="text-muted">{{ Carbon\Carbon::now()->format('l')}}</p>
                  </div>
                </div>
                
                
                <div class="row">
                  
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Select Slot 
                          <span class="text-danger">
                              @if(Session::has('error'))
                                ({{ Session::get('error')}})
                              @endif
                          </span>
                        </h4>
                      </div>
                      <div class="card-body ">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                          <li class="nav-item">
                            <a class="nav-link text-uppercase active" href="#bottom-justified-tab1" data-toggle="tab">
                                <span>{{ Carbon\Carbon::now()->format('D')}}</span><br/>
                                <span class="slot-date">{{ Carbon\Carbon::now()->format('d M Y')}} </span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-uppercase" href="#bottom-justified-tab2" data-toggle="tab">
                                <span>{{ Carbon\Carbon::now()->adddays(+1)->format('D')}}</span><br/>
                                <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+1)->format('d M Y')}} </span>  
                              </a>
                            </li>
                          <li class="nav-item">
                            <a class="nav-link text-uppercase" href="#bottom-justified-tab3" data-toggle="tab">
                              <span>{{ Carbon\Carbon::now()->adddays(+2)->format('D')}}</span><br/>
                              <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+2)->format('d M Y')}} </span> 
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-uppercase" href="#bottom-justified-tab4" data-toggle="tab">
                              <span>{{ Carbon\Carbon::now()->adddays(+3)->format('D')}}</span><br/>
                              <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+3)->format('d M Y')}} </span> 
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-uppercase" href="#bottom-justified-tab5" data-toggle="tab">
                              <span>{{ Carbon\Carbon::now()->adddays(+4)->format('D')}}</span><br/>
                              <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+4)->format('d M Y')}} </span> 
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-uppercase" href="#bottom-justified-tab6" data-toggle="tab">
                              <span>{{ Carbon\Carbon::now()->adddays(+5)->format('D')}}</span><br/>
                              <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+5)->format('d M Y')}} </span> 
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link text-uppercase" href="#bottom-justified-tab7" data-toggle="tab">
                              <span>{{ Carbon\Carbon::now()->adddays(+6)->format('D')}}</span><br/>
                              <span class="slot-date">{{ Carbon\Carbon::now()->adddays(+6)->format('d M Y')}} </span> 
                            </a>
                          </li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane show active" id="bottom-justified-tab1">
                              <!-- Time Slot -->
                              <div class="time-slot">
                                <ul class="clearfix">
                                  @php $allslots = slots(0,$doctor->id); @endphp
                                  @if(count($allslots)>0)
                                    @foreach ($allslots as $allslots1) 
                                      {{-- @if (\Carbon\Carbon::parse($allslots1->start_time)->format('h:i A')<\Carbon\Carbon::now()->format('h:i A')) --}}
                                        <li class="mt-1" >
                                          <a class="timing" id="sel{{$allslots1->id}}" href="javascript:;"  @if ($allslots1->is_booked==1) style="background-color:#ff5454;color:white;" title="Slot Already Booked"  onclick="booked()" @else onclick="book({{$allslots1->id}})" @endif>
                                            <span>{{ Carbon\Carbon::parse($allslots1->start_time)->format('h:i A') }}</span>
                                          </a>
                                        </li> 
                                      {{-- @endif   --}}
                                    @endforeach
                                  @else
                                    <li class="mt-1">
                                        <span>No Slot Available</span>
                                    </li>
                                  @endif
                                </ul>
                              </div>
                              <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab2">
                                  <!-- Time Slot -->
                                  <div class="time-slot">
                                    <ul class="clearfix">
                                      @php $alltab2 = slots(1,$doctor->id); @endphp
                                      @if(count($alltab2)>0)
                                        @foreach ($alltab2 as $alltab22)                                        
                                          <li class="mt-1" >
                                            <a class="timing" id="sel{{$alltab22->id}}" href="javascript:;"  @if ($alltab22->is_booked==1) style="background-color:#ff5454;color:white;"  title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab22->id}})" @endif>
                                              <span>{{ Carbon\Carbon::parse($alltab22->start_time)->format('h:i A') }}</span>
                                            </a>
                                          </li> 
                                        @endforeach
                                      @else
                                        <li class="mt-1">
                                            <span>No Slot Available</span>
                                        </li>
                                      @endif
                                    </ul>
                                  </div>
                                  <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab3">
                                <!-- Time Slot -->
                                <div class="time-slot">
                                  <ul class="clearfix">
                                    @php $alltab3 = slots(2,$doctor->id); @endphp
                                    @if(count($alltab3)>0)
                                      @foreach ($alltab3 as $alltab33)
                                        
                                        <li class="mt-1" >
                                          <a class="timing" id="sel{{$alltab33->id}}" href="javascript:;"  @if ($alltab33->is_booked==1) style="background-color:#ff5454;color:white;"  title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab33->id}})" @endif>
                                            <span>{{ Carbon\Carbon::parse($alltab33->start_time)->format('h:i A') }}</span>
                                          </a>
                                        </li> 
                                        
                                      @endforeach
                                    @else
                                      <li class="mt-1">
                                          <span>No Slot Available</span>
                                      </li>
                                    @endif
                                  </ul>
                                </div>
                                <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab4">
                            <!-- Time Slot -->
                            <div class="time-slot">
                              <ul class="clearfix">
                                @php $alltab4 = slots(3,$doctor->id); @endphp
                                @if(count($alltab4)>0)
                                  @foreach ($alltab4 as $alltab44)
                                    
                                    <li class="mt-1" >
                                      <a class="timing" href="javascript:;" id="sel{{$alltab44->id}}"  @if ($alltab44->is_booked==1) style="background-color:#ff5454;color:white;"  title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab44->id}})" @endif>
                                        <span>{{ Carbon\Carbon::parse($alltab44->start_time)->format('h:i A') }}</span>
                                      </a>
                                    </li> 
                                    
                                  @endforeach
                                @else
                                  <li class="mt-1">
                                      <span>No Slot Available</span>
                                  </li>
                                @endif
                              </ul>
                            </div>
                            <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab5">
                            <!-- Time Slot -->
                            <div class="time-slot">
                              <ul class="clearfix">
                                @php $alltab5 = slots(4,$doctor->id); @endphp
                                @if(count($alltab5)>0)
                                  @foreach ($alltab5 as $alltab55)
                                    
                                    <li class="mt-1" >
                                      <a class="timing" href="javascript:;" id="sel{{$alltab55->id}}" @if ($alltab55->is_booked==1) style="background-color:#ff5454;color:white;"  title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab55->id}})" @endif>
                                        <span>{{ Carbon\Carbon::parse($alltab55->start_time)->format('h:i A') }}</span>
                                      </a>
                                    </li> 
                                    
                                  @endforeach
                                @else
                                  <li class="mt-1">
                                      <span>No Slot Available</span>
                                  </li>
                                @endif
                              </ul>
                            </div>
                            <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab6">
                            <!-- Time Slot -->
                            <div class="time-slot">
                              <ul class="clearfix">
                                @php $alltab6 = slots(5,$doctor->id); @endphp
                                @if(count($alltab6)>0)
                                  @foreach ($alltab6 as $alltab66)
                                    
                                    <li class="mt-1" >
                                      <a class="timing" href="javascript:;"  id="sel{{$alltab66->id}}"  @if ($alltab66->is_booked==1) style="background-color:#ff5454;color:white;"  title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab66->id}})" @endif>
                                        <span>{{ Carbon\Carbon::parse($alltab66->start_time)->format('h:i A') }}</span>
                                      </a>
                                    </li> 
                                    
                                  @endforeach
                                @else
                                  <li class="mt-1">
                                      <span>No Slot Available</span>
                                  </li>
                                @endif
                              </ul>
                            </div>
                            <!-- /Time Slot -->
                          </div>
                          <div class="tab-pane" id="bottom-justified-tab7">
                              <!-- Time Slot -->
                            <div class="time-slot">
                              <ul class="clearfix">
                                @php $alltab7 = slots(6,$doctor->id); @endphp
                                @if(count($alltab7)>0)
                                  @foreach ($alltab7 as $alltab77)
                                    
                                    <li class="mt-1" >
                                      <a class="timing" href="javascript:;" id="sel{{$alltab77->id}}"    @if ($alltab77->is_booked==1) style="background-color:#ff5454;color:white;" title="Slot Already Booked" onclick="booked()" @else onclick="book({{$alltab77->id}})" @endif>
                                        <span>{{ Carbon\Carbon::parse($alltab77->start_time)->format('h:i A') }}</span>
                                      </a>
                                    </li> 
                                    
                                  @endforeach
                                @else
                                  <li class="mt-1">
                                      <span>No Slot Available</span>
                                  </li>
                                @endif
                              </ul>
                            </div>
                            <!-- /Time Slot -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <form action="{{route('patient.checkout')}}" method="POST">
                  @csrf
                  <!-- Submit Section -->
                  <div class="submit-section proceed-btn text-right">
                    <input type="hidden" id="slot_id" name="slot_id" readonly />
                    <input type="hidden" value="{{$doctor->id}}" name="doctor_id" readonly/>
                    <button  class="btn btn-primary submit-btn">Proceed to Pay</button>
                  </div>
                  <!-- /Submit Section -->
                </form>
              </div>
            </div>
          </div>

        </div>		
        <!-- /Page Content -->
  @endsection		
  @push('script')
    <script>
          function booked(){
            alert('session booked');
          }

          function book(id){
            // alert(id);
            $('#slot_id').val(id);   
            $('.selected').removeClass('selected');
            $('#sel'+id).addClass('selected');

          }
    </script>
  @endpush