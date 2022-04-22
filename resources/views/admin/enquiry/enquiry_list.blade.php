@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Enquiry</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Enquiry</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            {{-- <div class="ibox-title">
                <h5>Enquiry</h5>
                <div class="ibox-tools">
                  
                </div>
            </div> --}}
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enquiry as $enquiry1)
                            <tr>
                                <td>{{ $enquiry1->name}}</td>
                                <td>{{ $enquiry1->email}}</td>
                                <td>{{ $enquiry1->mobile}}</td>
                                <td>{{ \Illuminate\Support\Str::limit($enquiry1->comment, $limit = 70, $end = '...') }}</td>
                                <td> 
                                    <a class='btn btn-xs text-light' style='background-color:#1AB394;'  href="{{ route('admin.enquiry.view',['id'=>$enquiry1->id])}}"><i class=' fa fa-eye'></i></a> 
                                    <a class='btn btn-xs demotest text-light bg-success'  href="{{ route('admin.enquiry.delete',['id'=>$enquiry1->id])}}"><i class=' fa fa-trash'></i></a> 
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
$(document).on('click', '.demotest', function() {
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