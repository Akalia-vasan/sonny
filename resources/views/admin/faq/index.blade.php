@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>FAQ List</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>FAQ</strong>
            </li>
        </ol>
        
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>FAQ</h5>
                <div class="ibox-tools">
                    <a class="btn btn-sm" style="background-color:#1AB394;" href="{{ route('admin.faq.create') }}"><i class="fa fa-plus text-light"></i></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>FAQ Category Name</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Action</th>     
                            </tr>
                        </thead>
                        <tbody >
                            @php $i=1; @endphp
                            @foreach ($faq as $faq1)
                            <tr>
                                <td>{{ $i++  }}</td>
                                <td>{{ $faq1->name   }}</td>
                                <td>{{ $faq1->question   }}</td>
                                <td>{{ $faq1->answer   }}</td>
                                <td> 
                                    @if($faq1->active=='1')
                                       <span class="label label-primary">Active</span>
                                    @else
                                        <span class="label label-default">Inactive</span>
                                    @endif 
                                </td> 
                                <td>
                                    <a class="btn btn-xs text-light btn-primary"  href="{{ route('admin.faq.edit', $faq1->id)}}"><i class="fa fa-pencil"></i></a>            
                                    <button  class="btn btn-xs btn-success" onclick="mydeletefaq({{$faq1->id}})"><i class="fa fa-trash"></i></button> 
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
   
    function mydeletefaq(id) 
    {
        var id= id;
        var url="{{ url('content/faq')}}"+'/'+id;
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