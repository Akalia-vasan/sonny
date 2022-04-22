@extends('admin.layouts.admin')

@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
{{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
{{-- <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>User List</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>User</strong>
            </li>
        </ol>
         
    </div>
</div> --}}

    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Patient</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.user.add')}}" class="btn btn-primary float-right mt-2">Add</a>
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
                                    <th>Mobile</th>
                                    <th>Status</th> 
                                    <th>Action</th>     
                                </tr>
                            </thead>
                            <tbody >
    
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

    let t = $('.dataTables-example').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.user.get') }}",
        responsive: true,
        order: [[ 2, 'asc' ]],
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "email"},
            {data: "mobile"},
            {
                data: "active", 
                render: function(e) {
                    return `${ e==1 ? '<span class="label label-primary">Active</span>' : '<span class="label label-danger">Block</span>' }`;
                }
            },
            {data: 'action', name: 'action'},           
        ],
    });

    t.on('order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            t.cell(cell).invalidate('dom');
        } );
    }).draw();
});

$(document).on('click', '.demotest1', function() {
                event.preventDefault();
                const url = $(this).attr('href');
                console.log(url);
                    swal({
                        title: "Are you sure?",
                        text: "Your will not be able to recover this record!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = url;
                            swal("Deleted!", "Your record has been deleted.", "success");
                        } else {
                            swal("Cancelled", "Your record is safe.", "error");
                        }
                    });
            });
</script>
@endpush