@extends('doctor.layouts.doctorlayout')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{route('doctor.update_social_link')}}" method="POST" enctype="multipart/form-data">
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
            </form>
        </div>
    </div>
@endsection
@push('script')

    <script>
      

    </script>

@endpush