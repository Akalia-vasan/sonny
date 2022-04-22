@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Entity List</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Entities</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.entity.create')}}" class="btn btn-primary float-right mt-2">Add</a>
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
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                   <th>Mobile</th>
                                    <th>Type</th>
                                    <th>Active</th>
                                    <th>Action</th>     
                                </tr>
                            </thead>
                            <tbody >
                                @php $i=1; @endphp
                                @foreach ($alldoctor as $userdata1)
                                <tr>
                                    <td>{{ $i++  }}</td>
                                    <td>{{ $userdata1->name   }}</td>
                                    <td>{{ $userdata1->email   }}</td>
                                   <td>{{ $userdata1->mobile   }}</td>
                                    <td> <span class="label label-success">{{ $userdata1->type   }}</span></td>
                                    <td> 
                                        @if($userdata1->active=='1')
                                            <span class="label label-primary">Active</span>
                                        @else
                                            <span class="label label-default">Inactive</span>
                                        @endif 
                                    </td> 
                                    <td>
                                        <a class="btn btn-sm bg-success-light"  href="{{ route('admin.entity.edit', $userdata1->id)}}">
                                            <i class="fe fe-pencil"></i> 
                                        </a>
                                        <a class="btn btn-sm bg-danger-light demotest1" href="{{ route('admin.entity.delete', $userdata1->id)}}">
                                            <i class="fe fe-trash"></i> 
                                        </a>
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
               