@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Center List</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Centers</strong>
            </li>
        </ol>
        
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Centers</h5>
                <div class="ibox-tools">
                    <a class="btn btn-sm" style="background-color:#1AB394;" href="{{ route('admin.center.create') }}"><i class="fa fa-plus text-light"></i></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Center Name</th>
                                <th>Lattitude</th>
                                <th>Longitude</th>
                                <th>Active</th>
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
        ajax: "{{ route('admin.center.get') }}",
        responsive: true,
        order: [[ 2, 'asc' ]],
        columns: [
            {data: "id"},
            {data: "center_name"},
            {data: "lattitude"},
            {data: "longitude"},
            {
                data: "active", 
                render: function(e) {
                    return `${ e==1 ? '<span class="label label-primary">Active</span>' : '<span class="label label-default">Inactive</span>' }`;
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


    function mydeleteCenter(id) 
    {
        // url: 'approve/'+post_id,
        var id= id;
        var url="{{ url('plan/center')}}"+'/'+id;
        // alert(ur);exit();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _token: "{{ csrf_token() }}",
                _method: 'DELETE'
            },
            url: url,
            success: function (data) {
                if(data.status=='1')
                {
                    location.reload();
                }
                if(data.status=='0')
                {
                    location.reload();
                }
            },
            error: (err) => {
                console.log(err);
                swal("Server Error!", "", "error");
            },
        });
     
    }

</script>
@endpush