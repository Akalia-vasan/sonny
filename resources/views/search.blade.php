@extends('layouts.app')

@section('content')
		
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Search</li>
                        </ol>
                    </nav>
                    <input type="hidden" id="city_id" value="@if ($city_id) {{$city_id}} @endif">
                    <input type="hidden" id="special" value="@if ($special) {{$special}} @endif">
                    <h2 class="breadcrumb-title"> <span id="doctor-count"></span> matches found for : <span id="specialities"></span> In @if ($city) {{$city->name}} @else Nan @endif</h2>
                </div>
                <div class="col-md-4 col-12 d-md-block d-none">
                    <div class="sort-by">
                        <span class="sort-title">Sort by</span>
                        <span class="sortby-fliter">
                            <select class="form-control" id="SortBy" onchange="Searcfilter()">
                                <option value="rating" class="sorting">Rating</option>
                                {{-- <option value="" class="sorting">Popular</option> --}}
                                <option value="latest" class="sorting">Latest</option>
                                <option value="free" class="sorting">Free</option>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">
                
                    <!-- Search Filter -->
                    <div class="card search-filter">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Search Filter</h4>
                        </div>
                        <div class="card-body">
                        {{-- <div class="filter-widget">
                            <div class="cal-icon">
                                <input type="text" class="form-control datetimepicker" placeholder="Select Date">
                            </div>			
                        </div> --}}
                        <div class="filter-widget">
                            <h4>Gender</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="radio" name="gender" value="Male" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Male Doctor
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="radio" name="gender" value="Female" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Female Doctor
                                </label>
                            </div>
                        </div>
                        <div class="filter-widget">
                            <h4>Select Specialist</h4>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="speciality" value="1" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Urology
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="speciality" value="2" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Neurology
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="speciality" value="5" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Dentist
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="speciality" value="3" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Orthopedic
                                </label>
                            </div>
                            <div>
                                <label class="custom_check">
                                    <input type="checkbox" name="speciality" value="4" onclick="Searcfilter()">
                                    <span class="checkmark"></span> Cardiologist
                                </label>
                            </div>
                        </div>
                            <div class="btn-search">
                                <button type="button" class="btn btn-block">Search</button>
                            </div>	
                        </div>
                    </div>
                    <!-- /Search Filter -->
                    
                </div>
                
                <div class="col-md-12 col-lg-8 col-xl-9"  id="data_card">
                   
                    {{-- <div class="load-more text-center">
                        <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a>	
                    </div>	 --}}
                </div>
            </div>

        </div>

    </div>
		
@endsection		
  @push('script')
    <script>
        Searcfilter();
        function Searcfilter()
        {
            var numofrecords    = 10;
            var cityID      = $("#city_id").val();  
            var special         = $("#special").val();  
            var gender          = '';
            gender = $('input[name=gender]:checked').val()
            var speciality = new Array();
            $("input:checkbox[name=speciality]:checked").each(function() {
                speciality.push($(this).val());
            });
           // speciality = $('input[name=Rating]:checked').val(); 
            var SortBy          = $("#SortBy").val(); 
            var DataStr         = {_token: "{{ csrf_token() }}",city:cityID,special:special,speciality:speciality,gender:gender,SortBy:SortBy,numofrecords:numofrecords};
           //console.log(DataStr);
           $("#data_card").html(`<div class="card ">
                                    <div class="card-body text-center">
                                        <button class="btn btn-primary" disabled>
                                            <span class="spinner-border spinner-border-sm fa-2x"></span>
                                            &nbsp &nbsp Loading......
                                        </button>
                                    </div>
                                 </div>`);
           $.ajax({
                type: "POST",
                url:  "{{ route( 'search1' ) }}",
                data: DataStr,
                success: function(data) 
                {    
                    $("#doctor-count").html(data.count);    
                    $("#specialities").html(data.specialities);
                    $("#data_card").html(data.record);         
                }
            });  
        }
    </script> 
  @endpush
