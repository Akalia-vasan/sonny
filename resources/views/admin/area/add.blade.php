@extends('admin.layouts.admin')

@section('content') 

    <div class="page-header"> 
        <div class="row">
            <div class="col-sm-12">  
                <h3 class="page-title">Area Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Area Add</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row" style="display:block;">
        <form action="{{ route('admin.area.store') }}" method="post" enctype="multipart/form-data">
            @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Area Name <span class="text-danger">*</span></label>
                                    <input type="text" name="area" value="{{old('area')}}" class="form-control floating @error('area') is-invalid @enderror" required>
                                    @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Description Link <span class="text-danger">*</span></label>
                                    <input type="text" name="link" value="" class="form-control floating @error('link') is-invalid @enderror" required>
                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <input type="text" name="location" id="address-input" value="{{ old('location') }}" class="form-control map-input floating @error('location') is-invalid @enderror" required>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>

                                <div class="form-group">
                                    <label>Lattitude <span class="text-danger">*</span></label>
                                    <input type="text" name="address_latitude" id="address-latitude" value="{{ old('address_latitude') }}" class="form-control floating @error('address_latitude') is-invalid @enderror" readonly required>
                                    @error('address_latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>

                                <div class="form-group">
                                    <label>Longitude <span class="text-danger">*</span></label>
                                    <input type="text" name="address_longitude" id="address-longitude" value="{{ old('address_longitude') }}" class="form-control floating @error('address_longitude') is-invalid @enderror" readonly required>
                                    @error('address_longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                                
                            </div>
                            <div class="col-md-5">
                                <div id="address-map-container" style="width:100%;height:300px; ">
                                    <div style="width: 100%; height: 100%" id="address-map"></div>
                                </div>
                            </div>

                            <div class="submit-section submit-btn-bottom">
                                <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /Basic Information -->

            </div>
        </form>
    </div>

@endsection
@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="{{ asset('js/mapInput.js') }}"></script>
    <script>

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#ff3e6c' });

        function myFunction3(id)
        {
            let el = $('#password');

            if(el.hasClass('fa-eye-slash'))
            {
                el.removeClass('fa-eye-slash');
                el.addClass('fa-eye');
                $('#'+id).attr('type', 'text');
            }
            else
            {
                el.removeClass('fa-eye');
                el.addClass('fa-eye-slash');
                $('#'+id).attr('type', 'password');
            }
        }
    </script>

@endpush


