@extends('doctor.layouts.doctorlayout')
<link rel="stylesheet" href="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css" />
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Schedule Timings</h4>
                <div class="profile-box">
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">   
                                <label>Timing Slot Duration</label>
                                <select class="select form-control" id="selected_time">
                                    <option value="20" selected="selected">20 mins</option>
                                    <option value="30">30 mins</option>  
                                    <option value="45">45 mins</option>
                                    <option value="60">1 Hour</option>
                                </select>
                            </div>
                        </div>

                    </div>     
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card schedule-widget mb-0">
                            
                                <!-- Schedule Header -->
                                <div class="schedule-header">
                                <input type="hidden" id="selected_day" value="monday">
                                    <!-- Schedule Nav -->
                                    <div class="schedule-nav">
                                        <ul class="nav nav-tabs nav-justified">
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='sunday') active @endif" onclick="chageday('sunday')" data-toggle="tab" href="#slot_sunday">Sunday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='monday') active @endif @if(old('day')=='') active @endif" onclick="chageday('monday')" data-toggle="tab" href="#slot_monday">Monday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='tuesday') active @endif" onclick="chageday('tuesday')" data-toggle="tab" href="#slot_tuesday">Tuesday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='wednesday') active @endif" onclick="chageday('wednesday')" data-toggle="tab" href="#slot_wednesday">Wednesday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='thursday') active @endif" onclick="chageday('thursday')" data-toggle="tab" href="#slot_thursday">Thursday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='friday') active @endif" onclick="chageday('friday')" data-toggle="tab" href="#slot_friday">Friday</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link @if(old('day')=='saturday') active @endif" onclick="chageday('saturday')" data-toggle="tab" href="#slot_saturday">Saturday</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- /Schedule Nav -->
                                    
                                </div>
                                <!-- /Schedule Header -->
                                
                                <!-- Schedule Content -->
                                <div class="tab-content schedule-cont">
                                
                                    <!-- Sunday Slot -->
                                    <div id="slot_sunday" class="tab-pane fade @if(old('day')=='sunday') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='sunday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">                                                  
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='sunday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Sunday Slot -->

                                    <!-- Monday Slot -->
                                    <div id="slot_monday" class="tab-pane fade @if(old('day')=='monday') show active @endif @if(old('day')=='') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='monday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='monday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Monday Slot -->

                                    <!-- Tuesday Slot -->
                                    <div id="slot_tuesday" class="tab-pane fade @if(old('day')=='tuesday') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='tuesday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='tuesday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Tuesday Slot -->

                                    <!-- Wednesday Slot -->
                                    <div id="slot_wednesday" class="tab-pane fade @if(old('day')=='wednesday') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='wednesday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='wednesday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Wednesday Slot -->

                                    <!-- Thursday Slot -->
                                    <div id="slot_thursday" class="tab-pane fade @if(old('day')=='thursday') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='thursday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='thursday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Thursday Slot -->

                                    <!-- Friday Slot -->
                                    <div id="slot_friday" class="tab-pane fade @if(old('day')=='friday') show active @endif">
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='friday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='friday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach 
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Friday Slot -->

                                    <!-- Saturday Slot -->
                                    <div id="slot_saturday" class="tab-pane fade @if(old('day')=='saturday') show active @endif">
                                        @if(old('day')=='saturday') 
                                        <span style="color:red">{{$errors}}</span>
                                        @endif
                                        <h4 class="card-title d-flex justify-content-between">
                                            <span>Time Slots</span> 
                                            @php $count=0; @endphp 
                                            @foreach ($schedule as $value)
                                                @if ($value->day=='saturday')
                                                   @php $count++; @endphp 
                                                @endif
                                            @endforeach
                                            @if ($count>0)
                                                    <a class="edit-link" href="javascript:void(0)" onclick="edit()"></i> Edit</a>
                                                </h4>
                                                <div class="doc-times">
                                                    @foreach ($schedule as $value)
                                                        @if ($value->day=='saturday')
                                                            <div class="doc-slot-list">
                                                                {{$value->session_name}}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                    <a class="edit-link" href="javascript:void(0)" onclick="add()"></i> Add Slot</a> 
                                                </h4>
                                                <p class="text-muted mb-0">Not Available</p> 
                                            @endif
                                    </div>
                                    <!-- /Saturday Slot -->

                                </div>
                                <!-- /Schedule Content -->
                                
                            </div>
                           
                        </div>
                     
                    </div>
                    <h4 class="card-title mt-5">
                        Note: - Two Time Slot Timing Can't Be same.
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>


    {{-- <form action="{{route('doctor.update_social_link')}}" method="POST" enctype="multipart/form-data">
        @csrf
    	<div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Facebook URL</label>
                    <input type="text" name="facebook" value="{{Auth::user()->facebook}}" class="form-control floating @error('facebook') is-invalid @enderror">
                    @error('facebook')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Twitter URL</label>
                    <input type="text" name="twitter" value="{{Auth::user()->twitter}}" class="form-control floating @error('twitter') is-invalid @enderror">
                    @error('twitter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Instagram URL</label>
                    <input type="text" name="instagram" value="{{Auth::user()->instagram}}" class="form-control floating @error('instagram') is-invalid @enderror">
                    @error('instagram')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Pinterest URL</label>
                    <input type="text" name="pinterest" value="{{Auth::user()->pinterest}}" class="form-control floating @error('pinterest') is-invalid @enderror">
                    @error('pinterest')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Linkedin URL</label>
                    <input type="text" name="linkedin" value="{{Auth::user()->linkedin}}" class="form-control floating @error('linkedin') is-invalid @enderror">
                    @error('linkedin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="form-group">
                    <label>Youtube URL</label>
                    <input type="text" name="youtube" value="{{Auth::user()->youtube}}" class="form-control floating @error('youtube') is-invalid @enderror">
                    @error('youtube')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="submit-section submit-btn-bottom">
            <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
        </div>
    </form> --}}
  



    
@endsection
<div class="modal fade custom-modal" id="add_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('doctor.schedule-timing')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="time" name="time">
                    <input type="hidden" class="day" name="day">
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10">
                                <div class="row form-row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input type="text" class="form-control" name="start_time[]" value="{{ old('start_time') }}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input type="text" class="form-control" name="end_time[]"  value="{{ old('end_time') }}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <br><br>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Time Slot Modal -->

<!-- Edit Time Slot Modal -->
<div class="modal fade custom-modal" id="edit_time_slot">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Time Slots</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('doctor.update-schedule-timing')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="time" name="time">
                    <input type="hidden" class="day" name="day">
                    <div class="hours-info">
                        <div class="row form-row hours-cont">
                            <div class="col-12 col-md-10" id="editBox">
                            </div>
                        </div>

                    </div>
                    <br><br>
                    <div class="add-more mb-3">
                        <a href="javascript:void(0);" class="add-hours"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <br><br>
                    <div class="submit-section text-center">
                        <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                    </div>
                    <br><br>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')

<script src="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <script> 
     function add(){
         $('.time').val($('#selected_time').val());
         $('.day').val($('#selected_day').val());
         $('#add_time_slot').modal('show');
     } 

     function edit(){
         $('.time').val($('#selected_time').val());
         $('.day').val($('#selected_day').val());
         var day = $('.day').val();
         var a = @json($schedule);
         $('#editBox').append(`<div class="col-12 text-center col-md-4"><label class="d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash">Clear All</a></div>`);
        for(var i=0;i<a.length;i++){
            if( a[i].day == day){
                $('#editBox').append(`
                    <div class="row form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="start_time[]"  value="${a[i].start_time}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div> 
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>End Time</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" class="form-control" name="end_time[]"  value="${a[i].end_time}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div> 
                        </div>
                    </div>`);
                  
            }
        }
        $(".clockpicker").clockpicker();
        $('#edit_time_slot').modal('show');
     } 

     function chageday(day){
        $('#selected_day').val(day);
     } 

     $(".clockpicker").clockpicker();
    </script>

@endpush