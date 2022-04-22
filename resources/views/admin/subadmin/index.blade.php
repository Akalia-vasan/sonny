@extends('admin.layouts.admin')

@push('style')
@endpush

@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-sm-7 col-auto">
            <h3 class="page-title">Sub Admin List</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Sub Admin List</li>
            </ul>
        </div>
        <div class="col-sm-5 col">
            <a href="{{ route('admin.subadmin.create')}}" class="btn btn-primary float-right mt-2">Add</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>     
                            </tr>
                        </thead>
                        <tbody >
                            @php $i=1; @endphp
                            @foreach ($subadmins as $subadmins1)
                            <tr>
                                <td>{{ $i++  }}</td>
                                <td>{{ $subadmins1->name }}</td>
                                <td>{{ $subadmins1->email }}</td>
                                <td>{{ $subadmins1->type }}</td>
                                <td>
                                    <a class="btn btn-xs text-light btn-primary"  href="{{ route('admin.subadmin.edit', $subadmins1->id)}}"><i class="fa fa-pencil"></i></a>            
                                    <a class="btn btn-sm bg-danger-light demotest1" href="javascript:;">
                                        <i class="fe fe-trash"></i> 
                                    </a>
                                    <form action="{{ route('admin.subadmin.destroy',$subadmins1->id) }}" method="post" id="form_submit_destroy" >
                                        @csrf	
                                        @method('DELETE')
                                        
                                    </form>
                                </td>
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
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
        
        $(document).ready(function(){
            $('.dataTables-example').DataTable();
        });

        $(document).on('click', '.demotest1', function() {
            event.preventDefault();
            const url = $(this).attr('href');
            console.log(url);
                swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this role!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#form_submit_destroy').submit();
                        swal("Deleted!", "Your record has been deleted.", "success");
                    } else {
                        swal("Cancelled", "Your record is safe.", "error");
                    }
                });
        });

    </script>
@endpush