@extends('doctor.layouts.doctorlayout')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets1/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/dropzone/dropzone.min.css')}}">
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body custom-edit-service">
                   
                <!-- Add Blog -->
                <form method="post" enctype="multipart/form-data" autocomplete="off" id="update_service" action="{{ route('doctor.blog.store')}}">
                    @csrf

                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Blog Title <span class="text-danger">*</span></label>
                                    <input class="form-control floating @error('blog_title') is-invalid @enderror" type="text" name="blog_title" id="service_title" value="{{old('blog_title')}}">
                                    @error('blog_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select class="form-control floating @error('category_id') is-invalid @enderror" name="category_id" > 
                                        @foreach ($blogcat as $blogcat1)
                                            <option @if(old('category_id') == $blogcat1->id) selected @endif value="{{ $blogcat1->id }}">{{ $blogcat1->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Descriptions <span class="text-danger">*</span></label>
                                    <textarea id="about" class="form-control service-desc floating @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Blog Image <span class="text-danger">*</span></label>
                                    <input class="form-control floating @error('blog_image') is-invalid @enderror" type="file" name="blog_image" id="blog_image" value="{{old('blog_image')}}">
                                    @error('blog_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">	
                                <div id="uploadPreview">
                                    <ul class="upload-wrap">
                                        <li>
                                            <div class=" upload-images">
                                                <img alt="Blog Image" src="{{asset('assets/img/profiles/avatar-17.jpg')}}">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div> --}}
                    <div class="service-fields mb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Video Url </label>
                                    <input class="form-control floating @error('video_url') is-invalid @enderror" type="url" name="video_url" id="video_id" value="{{old('video_url')}}" >
                                    @error('video_url')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
                    </div>
                </form>
                <!-- /Add Blog -->


                </div>
            </div>
        </div>			
    </div>
    
@endsection
@push('script')
    <script src="{{ asset('assets1/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets1/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets1/js/profile-settings.js')}}"></script>

@endpush