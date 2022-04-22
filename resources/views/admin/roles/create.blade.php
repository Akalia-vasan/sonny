@extends('admin.layouts.admin')


@section('content')

<div class="page-header">
    <div class="row">
        <div class="col-sm-7 col-auto">
            <h3 class="page-title">Create New Role</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Add Role</li>
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
                        <form action="{{ route('admin.roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Name </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
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
                                            <input type="checkbox" name="" id=""  data-id="appointment" class="module">
                                            <label for=""><strong> Appointment : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="1" class="appointment">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="2" class="appointment">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="3" class="appointment">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="4" class="appointment">
                                            <label>Delete</label> <br>
                                        </div>  
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="subadmin" class="module">
                                            <label for=""><strong> Subadmin : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="13" class="subadmin">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="14" class="subadmin">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="15" class="subadmin">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="16" class="subadmin">
                                            <label>Delete</label> <br>
                                        </div> 
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="speciality" class="module">
                                            <label for=""><strong> Speciality : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="5" class="speciality">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="6" class="speciality">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="7" class="speciality">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="8" class="speciality">
                                            <label>Delete</label> <br>
                                        </div> 
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="service" class="module">
                                            <label for=""><strong> Beauty Services : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="9" class="service">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="10" class="service">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="11" class="service">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="12" class="service">
                                            <label>Delete</label> <br>
                                        </div> 
                                    </div> 

                                    <div class="form-group row"> 
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="area" class="module">
                                            <label for=""><strong> Areas : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="17" class="area">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="18" class="area">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="19" class="area">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="20" class="area">
                                            <label>Delete</label> <br>
                                        </div> 

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="labtest" class="module">
                                            <label for=""><strong> Lab Test : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="21" class="labtest">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="22" class="labtest">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="23" class="labtest">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="24" class="labtest">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="entity" class="module">
                                            <label for=""><strong> Entity : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="25" class="entity">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="26" class="entity">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="27" class="entity">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="28" class="entity">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="doctor" class="module">
                                            <label for=""><strong> Doctor : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="29" class="doctor">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="30" class="doctor">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="31" class="doctor">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="32" class="doctor">
                                            <label>Delete</label> <br>
                                        </div>
                                    </div>

                                    <div class="form-group row"> 
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="user" class="module">
                                            <label for=""><strong> User : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="37" class="user">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="38" class="user">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="39" class="user">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="40" class="user">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="coupon" class="module">
                                            <label for=""><strong> Coupon : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="41" class="coupon">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="42" class="coupon">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="43" class="coupon">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="44" class="coupon">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="blogtype" class="module">
                                            <label for=""><strong> Blog Type : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="45" class="blogtype">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="46" class="blogtype">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="47" class="blogtype">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="48" class="blogtype">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="blogs" class="module">
                                            <label for=""><strong> Blog : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="49" class="blogs">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="50" class="blogs">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="51" class="blogs">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="52" class="blogs">
                                            <label>Delete</label> <br>
                                        </div>
                                    </div>


                                    <div class="form-group row"> 
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="role" class="module">
                                            <label for=""><strong> Role & Permission : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="53" class="role">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="54" class="role">
                                            <label>Create</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="55" class="role">
                                            <label>Update</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="56" class="role">
                                            <label>Delete</label> <br>
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="setting" class="module">
                                            <label for=""><strong> Setting : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="57" class="setting">
                                            <label>List</label> <br>
                                            <input type="checkbox" name="permission[]" id="" value="59" class="setting">
                                            <label>Update</label> <br> 
                                        </div>

                                        <div class="col-sm-3 col-sm-offset-2">
                                            <input type="checkbox" name="" id=""  data-id="setting" class="module">
                                            <label for=""><strong> Patient : - </strong></label><br>
                                            <input type="checkbox" name="permission[]" id="" value="33" class="patient">
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
                                                <input type="checkbox" name="permission[]" id="" value="{{$value->id}}" class="name">
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