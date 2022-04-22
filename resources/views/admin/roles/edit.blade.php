@extends('admin.layouts.admin')


@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Edit Role</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a class="btn btn-primary float-right mt-2" href="{{ route('admin.roles.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">
                            <form action="{{ route('admin.roles.update',$role->id) }}" method="POST">
                                @csrf	
                                @method('PUT')	
                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <b><span>Name </span></b>
                                    </div>
                                    <div class="col-sm-8 mb-2">
                                        <input type="text" class="form-control" name="name" value="{{ $role->name }}" />
                                        @if($errors->has('name'))
                                        <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <b><span>Permissions : </span></b>
                                    </div>
                                    <div class="col-sm-10 mb-2">
                                        <div class="form-group row"> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(1, $rolePermissions) && in_array(2, $rolePermissions) && in_array(3, $rolePermissions) && in_array(4, $rolePermissions))  checked @else @endif  data-id="appointment" class="module">
                                                <label for=""><strong> Appointment : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(1, $rolePermissions))  checked @else @endif id="" value="1" class="appointment">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(2, $rolePermissions))  checked @else @endif id="" value="2" class="appointment">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(3, $rolePermissions))  checked @else @endif id="" value="3" class="appointment">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(4, $rolePermissions))  checked @else @endif id="" value="4" class="appointment">
                                                <label>Delete</label> <br>
                                            </div>  
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(13, $rolePermissions) && in_array(14, $rolePermissions) && in_array(15, $rolePermissions) && in_array(16, $rolePermissions))  checked @else @endif  data-id="subadmin" class="module">
                                                <label for=""><strong> Subadmin : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(13, $rolePermissions))  checked @else @endif id="" value="13" class="subadmin">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(14, $rolePermissions))  checked @else @endif id="" value="14" class="subadmin">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(15, $rolePermissions))  checked @else @endif id="" value="15" class="subadmin">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(16, $rolePermissions))  checked @else @endif id="" value="16" class="subadmin">
                                                <label>Delete</label> <br>
                                            </div> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(5, $rolePermissions) && in_array(6, $rolePermissions) && in_array(7, $rolePermissions) && in_array(8, $rolePermissions))  checked @else @endif  data-id="speciality" class="module">
                                                <label for=""><strong> Speciality : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(5, $rolePermissions))  checked @else @endif id="" value="5" class="speciality">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(6, $rolePermissions))  checked @else @endif id="" value="6" class="speciality">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(7, $rolePermissions))  checked @else @endif id="" value="7" class="speciality">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(8, $rolePermissions))  checked @else @endif id="" value="8" class="speciality">
                                                <label>Delete</label> <br>
                                            </div> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(9, $rolePermissions) && in_array(10, $rolePermissions) && in_array(11, $rolePermissions) && in_array(12, $rolePermissions))  checked @else @endif data-id="service" class="module">
                                                <label for=""><strong> Beauty Services : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(9, $rolePermissions))  checked @else @endif id="" value="9" class="service">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(10, $rolePermissions))  checked @else @endif id="" value="10" class="service">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(11, $rolePermissions))  checked @else @endif id="" value="11" class="service">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(12, $rolePermissions))  checked @else @endif id="" value="12" class="service">
                                                <label>Delete</label> <br>
                                            </div> 
                                        </div> 
    
                                        <div class="form-group row"> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id=""  @if(in_array(17, $rolePermissions) && in_array(18, $rolePermissions) && in_array(19, $rolePermissions) && in_array(20, $rolePermissions))  checked @else @endif data-id="area" class="module">
                                                <label for=""><strong> Areas : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(17, $rolePermissions))  checked @else @endif id="" value="17" class="area">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(18, $rolePermissions))  checked @else @endif id="" value="18" class="area">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(19, $rolePermissions))  checked @else @endif id="" value="19" class="area">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(20, $rolePermissions))  checked @else @endif id="" value="20" class="area">
                                                <label>Delete</label> <br>
                                            </div> 
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(21, $rolePermissions) && in_array(22, $rolePermissions) && in_array(23, $rolePermissions) && in_array(24, $rolePermissions))  checked @else @endif  data-id="labtest" class="module">
                                                <label for=""><strong> Lab Test : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(21, $rolePermissions))  checked @else @endif id="" value="21" class="labtest">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(22, $rolePermissions))  checked @else @endif id="" value="22" class="labtest">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(23, $rolePermissions))  checked @else @endif id="" value="23" class="labtest">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(24, $rolePermissions))  checked @else @endif id="" value="24" class="labtest">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(25, $rolePermissions) && in_array(26, $rolePermissions) && in_array(27, $rolePermissions) && in_array(28, $rolePermissions))  checked @else @endif data-id="entity" class="module">
                                                <label for=""><strong> Entity : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(25, $rolePermissions))  checked @else @endif  id="" value="25" class="entity">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(26, $rolePermissions))  checked @else @endif id="" value="26" class="entity">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(27, $rolePermissions))  checked @else @endif id="" value="27" class="entity">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(28, $rolePermissions))  checked @else @endif id="" value="28" class="entity">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id=""  @if(in_array(29, $rolePermissions) && in_array(30, $rolePermissions) && in_array(31, $rolePermissions) && in_array(32, $rolePermissions))  checked @else @endif data-id="doctor" class="module">
                                                <label for=""><strong> Doctor : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(29, $rolePermissions))  checked @else @endif id="" value="29" class="doctor">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(30, $rolePermissions))  checked @else @endif value="30" class="doctor">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(31, $rolePermissions))  checked @else @endif value="31" class="doctor">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(32, $rolePermissions))  checked @else @endif value="32" class="doctor">
                                                <label>Delete</label> <br>
                                            </div>
                                        </div>
    
                                        <div class="form-group row"> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(37, $rolePermissions) && in_array(38, $rolePermissions) && in_array(39, $rolePermissions) && in_array(40, $rolePermissions))  checked @else @endif data-id="user" class="module">
                                                <label for=""><strong> User : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(37, $rolePermissions))  checked @else @endif value="37" class="user">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(38, $rolePermissions))  checked @else @endif value="38" class="user">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(39, $rolePermissions))  checked @else @endif value="39" class="user">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(40, $rolePermissions))  checked @else @endif value="40" class="user">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(41, $rolePermissions) && in_array(42, $rolePermissions) && in_array(43, $rolePermissions) && in_array(44, $rolePermissions))  checked @else @endif  data-id="coupon" class="module">
                                                <label for=""><strong> Coupon : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(41, $rolePermissions))  checked @else @endif id="" value="41" class="coupon">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(42, $rolePermissions))  checked @else @endif id="" value="42" class="coupon">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(43, $rolePermissions))  checked @else @endif id="" value="43" class="coupon">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(44, $rolePermissions))  checked @else @endif id="" value="44" class="coupon">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id=""  @if(in_array(45, $rolePermissions) && in_array(46, $rolePermissions) && in_array(47, $rolePermissions) && in_array(48, $rolePermissions))  checked @else @endif  data-id="blogtype" class="module">
                                                <label for=""><strong> Blog Type : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(45, $rolePermissions))  checked @else @endif value="45" class="blogtype">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(46, $rolePermissions))  checked @else @endif value="46" class="blogtype">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(47, $rolePermissions))  checked @else @endif value="47" class="blogtype">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(48, $rolePermissions))  checked @else @endif value="48" class="blogtype">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(49, $rolePermissions) && in_array(50, $rolePermissions) && in_array(51, $rolePermissions) && in_array(52, $rolePermissions))  checked @else @endif data-id="blogs" class="module">
                                                <label for=""><strong> Blog : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(49, $rolePermissions))  checked @else @endif id="" value="49" class="blogs">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(50, $rolePermissions))  checked @else @endif id="" value="50" class="blogs">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(51, $rolePermissions))  checked @else @endif id="" value="51" class="blogs">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(52, $rolePermissions))  checked @else @endif id="" value="52" class="blogs">
                                                <label>Delete</label> <br>
                                            </div>
                                        </div>
    
    
                                        <div class="form-group row"> 
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id="" @if(in_array(53, $rolePermissions) && in_array(54, $rolePermissions) && in_array(55, $rolePermissions) && in_array(56, $rolePermissions))  checked @else @endif data-id="role" class="module">
                                                <label for=""><strong> Role & Permission : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" @if(in_array(53, $rolePermissions))  checked @else @endif id="" value="53" class="role">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(54, $rolePermissions))  checked @else @endif id="" value="54" class="role">
                                                <label>Create</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(55, $rolePermissions))  checked @else @endif id="" value="55" class="role">
                                                <label>Update</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(56, $rolePermissions))  checked @else @endif id="" value="56" class="role">
                                                <label>Delete</label> <br>
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id=""  @if(in_array(57, $rolePermissions) && in_array(59, $rolePermissions))  checked @else @endif data-id="setting" class="module">
                                                <label for=""><strong> Setting : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(57, $rolePermissions))  checked @else @endif value="57" class="setting">
                                                <label>List</label> <br>
                                                <input type="checkbox" name="permission[]" @if(in_array(59, $rolePermissions))  checked @else @endif id="" value="59" class="setting">
                                                <label>Update</label> <br> 
                                            </div>
    
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <input type="checkbox" name="" id=""  @if(in_array(33, $rolePermissions))  checked @else @endif data-id="setting" class="module">
                                                <label for=""><strong> Patient : - </strong></label><br>
                                                <input type="checkbox" name="permission[]" id="" @if(in_array(33, $rolePermissions))  checked @else @endif value="33" class="patient">
                                                <label>List</label> <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <b><span>Permissions : </span></b>
                                    </div>
                                    <div class="col-sm-10 mb-2">
                                        <div class="form-group row">                                         
                                            @foreach($permission as $value)
                                                <div class="col-sm-3 col-sm-offset-2">
                                                    <input type="checkbox" @if(in_array($value->id, $rolePermissions))  checked @else @endif name="permission[]" id="" value="{{$value->id}}" class="name">
                                                    <label>{{ $value->name }} </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}
                                
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
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        $('.module').on('click',function(){
            $("."+$(this).attr('data-id')).prop('checked',$(this).is(":checked"));
        });
        $(document).ready(function(){
            $('.dataTables-example').DataTable();
        });

     
    </script>
@endpush