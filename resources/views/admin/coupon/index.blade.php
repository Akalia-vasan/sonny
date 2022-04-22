@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Coupons</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Coupons</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.coupon.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="coupon-datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Coupon Code</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Value</th>
                                    <th>Max Uses</th>
                                    <th>Total Used</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allcoupon as $allcoupon1)
                                
                                    <tr>
                                        <td>{{$allcoupon1->code }}</td>
                                        
                                        <td>{{$allcoupon1->valid_from}}</td>
                                        <td>{{$allcoupon1->valid_to}}</td>
                                        
                                        <td>{{$allcoupon1->value }}</td>
                                        <td>{{$allcoupon1->max_uses }}</td>
                                        <td>{{$allcoupon1->used }}</td>
                                        <td>{{Str::limit($allcoupon1->description, 20, $end='...') }}</td>
                                        
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.coupon.edit',$allcoupon1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-danger-light @if($allcoupon1->used == 0) demotest1 @else  demotest2  @endif " href="{{ route('admin.coupon.delete',$allcoupon1->id)}}">
                                                    <i class="fe fe-trash"></i> 
                                                </a>
                                            </div>
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

        $(document).ready(function()
        {
            $('.coupon-datatable').DataTable();
        });

        $(document).on('click', '.demotest1', function() 
        {
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

        $(document).on('click', '.demotest2', function() 
        {
            event.preventDefault();
            swal({
            title: "This Coupon Already in Use.",
            type: "warning",
            });
        });


    </script>
@endpush