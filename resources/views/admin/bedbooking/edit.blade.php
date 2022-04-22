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
                <h3 class="page-title">Bed Edit</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Bed Edit</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row" style="display:block;">
        <form action="{{ route('admin.bedbooking.update',$bed->id) }}" method="post">
                @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Select Hospital <span class="text-danger">*</span></label>
                                    <select class="form-control select floating @error('hospital_id') is-invalid @enderror" name="hospital_id" required>
                                        <option value="0">-- Select Hospital Type --</option>
                                        @forelse ($hospitals as $item)
                                            <option {{ $bed->hospital_id == $item->id ? "selected" : "" }} value="{{$item->id}}">{{$item->hospital_name}}</option>
                                        @empty
                                            <option> No Hospital Available </option>
                                        @endforelse
                                    </select>
                                    @error('hospital_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Select Bed Type <span class="text-danger">*</span></label>
                                    <select class="form-control select floating @error('bed_type_id') is-invalid @enderror" name="bed_type_id" required>
                                        <option value="0">-- Select Bed Type --</option>
                                        @forelse ($bedtype as $item)
                                            <option {{ $bed->bed_type_id == $item->id ? "selected" : "" }} value="{{$item->id}}">{{$item->bed_type}}</option>
                                        @empty
                                            <option> No Bed Type Available </option>
                                        @endforelse
                                    </select>
                                    @error('bed_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                       
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Available Bed <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="aval_bed" value="{{$bed->aval_bed}}" class="form-control floating @error('aval_bed') is-invalid @enderror" required>
                                    @error('aval_bed')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" min="1" name="price" value="{{$bed->price}}" class="form-control floating @error('price') is-invalid @enderror" required>
                                    @error('price')
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
    <script src="{{ asset('js/mapInput.js') }}"></script>

    <script>
    
    </script>
@endpush