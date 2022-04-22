@extends('admin.layouts.admin')

@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-sm-12"> 
            <h3 class="page-title">Edit Sub Admin</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Sub Admin</li>
            </ul>
        </div>
    </div>
</div>

<div class="row" style="display:block;">
    <form action="{{ route('admin.subadmin.update',$subadmins->id) }}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}					
        <div class="col-12">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-body">
                    <div class="row form-row">
        
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ $subadmins->name}}" class="form-control floating @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email" value="{{ $subadmins->email}}" placeholder="" />
                                @if($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif 
                            </div>
                        </div>

                        <div class="col-8 col-md-8">
                            <div class="form-group">
                                <label>Profile Image <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="image" accept="image/*" placeholder="" />
                                @if($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                @endif   
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <img src="{{$subadmins->image}}" class="img-fluid ml-3" style="width:100px;" alt="">
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-prepend"> 
                                        <button onclick="myFunction2('password')" type="button" class="btn btn-primary"><i id="pass" class="fa fa-eye-slash"></i></button>
                                    </span>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Fill if you want to change password or leave it blank" /> 
                                </div>
                                @if($errors->has('password'))
                                    <div class="error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Assign Role <span class="text-danger">*</span></label>
                                <select name="role" class=" form-control" tabindex="-1" >
                                    <option value="0"> -- Select Role-- </option>
                                    @foreach ($allrole as $allroles)
                                        <option @if($subadmins->type==$allroles->name) selected @endif value="{{ $allroles->name}}">{{ $allroles->name }}</option>   
                                    @endforeach
                                </select>
                                @if($errors->has('role'))
                                    <div class="error">{{ $errors->first('role') }}</div>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*     </span></label>
                                &nbsp &nbsp &nbsp &nbsp<input type="checkbox" name="status" class="js-switch" @if($subadmins->status == '1') checked @endif />
                                @if($errors->has('status'))
                                    <div class="error">{{ $errors->first('status') }}</div>
                                @endif
                            </div>
                        </div> --}}

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
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script>

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#007BFF' });

        $(document).ready(function()
        {
            $('.chosen-select').chosen({width: "100%"});
        });

        function myFunction2(id)
        {
            let el = $('#pass');

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

