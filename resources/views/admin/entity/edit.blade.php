@extends('admin.layouts.admin')

@section('content')

    <div class="page-header"> 
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Entity Edit</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Entity Edit</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <form action="{{ route('admin.entity.update',$editentity->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row" >
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Select Role <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control floating @error('role') is-invalid @enderror" name="role" > 
                                            <option value="0"> -- Select Role-- </option>
                                            <option @if ($editentity->type=='Hospital') selected @endif value="Hospital">Hospital</option>
                                            <option @if ($editentity->type=='Clinic') selected @endif value="Clinic">Clinic</option>
                                            <option @if ($editentity->type=='Lab') selected @endif value="Lab">Lab</option>
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" >
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Select Area <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control floating @error('area') is-invalid @enderror" name="area" > 
                                            <option value="0"> -- Select Area-- </option>
                                            @foreach ($area as $row)
                                                <option @if ($editentity->area_id==$row->id) selected @endif value="{{$row->id}}">{{$row->area}}</option> 
                                            @endforeach 
                                        </select>
                                        @error('area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Name <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="hidden" class="form-control" name="id" value="{{ $editentity->id}}" />
                                        <input type="text" class="form-control" name="name" value="{{ $editentity->name}}" />
                                        @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Email <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" name="email" value="{{ $editentity->email}}" />
                                        @if($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Mobile <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" name="mobile" value="{{ $editentity->mobile}}" />
                                        @if($errors->has('mobile'))
                                        <div class="error">{{ $errors->first('mobile') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Thumbnail <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <input type="file" class="form-control" name="thumbnail" accept="image/*" placeholder="" />
                                        @if($errors->has('thumbnail'))
                                        <div class="error">{{ $errors->first('thumbnail') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 mb-2">
                                        <img src="{{$editentity->thumbnail}}" class="img-fluid " style="max-width:100px;" lt="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Images <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-10 mb-2">
                                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple placeholder="" />
                                        @if($errors->has('images'))
                                        <div class="error">{{ $errors->first('images') }}</div>
                                        @endif
                                   
                                        <div class="upload-wrap" id="imgdiv">
                                            @if ($editentity->images)
                                                @php 
                                                    $images = json_decode($editentity->images);
                                                    $array = is_array($images) ? $images : [] ;
                                                @endphp
                                                @foreach ($array as $array1)
                                                    @php $imageurl = 'storage/EntityImages/'.$array1; @endphp
                                                    <div class="upload-images">
                                                        <img src="{{ url($imageurl)}}" class="img-fluid" alt="Upload Image">
                                                        <a href="{{ route('admin.entity.image.delete',['id' => $editentity->id,'img'=>$array1])}}" class="btn btn-icon btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                                    </div>
                                                @endforeach
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Status <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="checkbox" name="status" class="js-switch" @if($editentity->active == '1') checked @endif />
                                        @if($errors->has('status'))
                                        <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-3 col-sm-offset-2">
                                        <button class="btn btn-primary btn-md" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>

    </div>

@endsection

@push('script')
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script>
        $('.chosen-select').chosen({width: "100%"});
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#00d0f1' });
    </script>
@endpush
