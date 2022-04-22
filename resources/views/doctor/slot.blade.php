@extends('doctor.layouts.doctorlayout')

@section('content')
{{-- 
{{$slots}} --}}
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Schedule Timings</h4>
                <div class="profile-box">
                    <div class="row">
                        <div class="col-sm-6 col-12 avail-time">
                            <div class="mb-3">
                                <div class="schedule-calendar-col justify-content-start">
                                    <form action="{{route('doctor.filter-slot-timing')}}" method="POST" class="d-flex flex-wrap">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Date:</span> 
                                        </div>
                                        @csrf
                                        <div class="mr-3"> 
                                            <input type="date" class="form-control" name="schedule_date"  id="schedule_date" value="{{$date}}" min="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                                        </div>
                                        <div class="search-time-mobile">
                                            <input type="submit" name="submit"  value="Search" class="btn btn-primary h-100">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- @if ($count==0) --}}
                            <div class="col-sm-6 col-12 avail-time text-right">
                                <form action="{{route('doctor.slot-timing-create')}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary h-100">Create Slot </button>
                                </form>
                            </div>  
                        {{-- @endif --}}
                    </div>
                    <div class="row">
                        @php $i=1; @endphp
                        @foreach ($sessions as $session)                          
                            <div class="col-lg-12">
                                <h3 class="h3 text-center book-btn2 mt-3 px-5 py-1 mx-3 rounded"> Session {{$i}}</h3>
                                <div class="text-center mt-3">
                                    <h4 class="h4 mb-2">Start Time </h4>
                                    <span class="h4 btn btn-outline-primary"><b> {{$session->start_time}}</b></span>
                                </div>
                                <div class="token-slot mt-2">
                                    @foreach ($slots as $slot) 
                                        @if ($slot->session_id==$session->id)
                                            <div class="form-check-inline visits mr-0">
                                                <label class="visit-btns">
                                                    <input type="checkbox" class="form-check-input slot{{$slot->id}}" @if ($slot->is_active==1) checked @endif autocomplete="off">
                                                    <span class="visit-rsn" data-toggle="tooltip" @if ($slot->is_booked==1) style="background-color:#ff5454;" onclick="booked({{$slot->id}})" @else onclick="disabled({{$slot->id}})" @endif title="{{Carbon\Carbon::parse($slot->start_time)->format('h:i A')}}">{{Carbon\Carbon::parse($slot->start_time)->format('h:i A')}}</span>
                                                </label>
                                            </div>
                                        @endif                                     
                                    @endforeach
                                </div>
                            </div>
                        @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
                {{-- <div class="text-center">
                    <button class="btn btn-primary">Save</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script> 

    function booked(id){
        swal.fire({
            title: "This Slot Already Booked.",
            type: "warning",
        });
     } 

     function disabled(id){
        swal.fire({
            title: "Are you sure?",
            text: "Your Slot Status will be changed!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Change Status",
            cancelButtonText: "Cancel",
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : "{{ route( 'doctor.update_slot' ) }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        slot_id: id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response)
                    {
                        // $(".slot"+id).addClass(''); 
                        swal.fire({
                            title: response.title,
                            text: response.text,
                            icon: response.type,
                            confirmButtonColor: "#DD6B55",
                        });
                    },
                    error: (err) => {
                        console.log(err);
                        swal("Error!", "", "error");
                    },
                });
            }else{
                // if($('.slot'+id).attr('checked')==false){
                //     $('.slot'+id).attr('checked', true); 
                // }else{
                //     $('.slot'+id).attr('checked', false);
                // }
                location.reload();
            }
        });
     }

     function add(){
         $('.time').val($('#selected_time').val());
         $('.day').val($('#selected_day').val());
         $('#add_time_slot').modal('show');
     } 



     function chageday(day){
        $('#selected_day').val(day);
     } 

    
    </script>

@endpush