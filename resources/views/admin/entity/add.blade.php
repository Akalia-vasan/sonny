@extends('admin.layouts.admin')

@section('content')

    <div class="page-header"> 
        <div class="row">
            <div class="col-sm-12"> 
                <h3 class="page-title">Entity Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Entity Add</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <form action="{{ route('admin.entity.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row" >
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Select Role <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <select class="form-control select floating @error('role') is-invalid @enderror" name="role" > 
                                            <option value="0"> -- Select Role-- </option>
                                            <option value="Hospital">Hospital</option>
                                            <option value="Clinic">Clinic</option>
                                            <option value="Lab">Lab</option>
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
                                        <select class="form-control select floating @error('area') is-invalid @enderror" name="area" > 
                                            <option value="0"> -- Select Area-- </option>
                                            @foreach ($area as $row)
                                                <option value="{{$row->id}}">{{$row->area}}</option> 
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
                                        <input type="text" class="form-control" name="name" placeholder="" />
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
                                        <input type="text" class="form-control" name="email" placeholder="" />
                                        @if($errors->has('email'))
                                        <div class="error">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Thumbnail <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="file" class="form-control" name="thumbnail" accept="image/*" placeholder="" />
                                        @if($errors->has('thumbnail'))
                                        <div class="error">{{ $errors->first('thumbnail') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Images <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple placeholder="" />
                                        @if($errors->has('images'))
                                        <div class="error">{{ $errors->first('images') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Mobile <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" name="mobile" placeholder="" />
                                        @if($errors->has('mobile'))
                                        <div class="error">{{ $errors->first('mobile') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <label>Status <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="checkbox" name="status" class="js-switch" checked />
                                        @if($errors->has('status'))
                                        <div class="error">{{ $errors->first('status') }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-3 col-sm-offset-2">
                                        <button class="btn btn-primary btn-md" type="submit">Save</button>
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
