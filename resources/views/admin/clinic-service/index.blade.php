@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')


    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Beauty Clinic Services List</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Beauty Clinic Services</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.service.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="dataTables-example table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Services</th>
                                    <th>Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($service as $service1)
                                    <tr>
                                        <td><h6 class="table-avatar">
                                            @if ($service1->service_image)
                                                <img class="avatar-img" src="{{url($service1->service_image)}}" width="100" alt="Speciality"> 
                                            @endif
                                            {{ $service1->service_name}}
                                        </h6></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.service.edit',$service1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-danger-light demotest1" href="{{ route('admin.service.delete',$service1->id)}}">
                                                    <i class="fa fa-trash"></i> 
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
        $(document).ready(function(){
            $('.dataTables-example').DataTable();
        });
    </script>
@endpush
               
