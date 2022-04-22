@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Area List</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Areas</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.area.create')}}" class="btn btn-primary float-right mt-2">Add</a>
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
                                    <th>Area</th>
                                    <th>Geo Location</th>
                                    {{-- <th>Description Link</th> --}}
                                    <th>Actions</th>  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($area as $area1)
                                    <tr>
                                        <td>{{ $area1->area}}</td>
                                        <td>{{ $area1->location}}</td>
                                        {{-- <td><a href="{{ $area1->link}}" target="blank">{{ $area1->link}}</a></td> --}}
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-sm bg-primary-light" target="blank" href="{{ $area1->link }}">
                                                    <i class="fe fe-eye"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-success-light"  href="{{ route('admin.area.edit',$area1->id)}}">
                                                    <i class="fe fe-pencil"></i> 
                                                </a>
                                                <a class="btn btn-sm bg-danger-light demotest1" href="{{ route('admin.area.delete',$area1->id)}}">
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
               
