@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>App Content </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>App Content </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                {{-- <h5>App content</h5> --}}
                <div class="ibox-tools">
                    <a class="btn btn-sm" style="background-color:#1AB394;" href="{{ route('admin.appcontent.app_add') }}"><i class="fa fa-plus text-light"></i></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Heading</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                                @if(isset($privacy_policy))
                                    <tr>
                                        <td>Privacy & Policy</td>
                                        <td>{!! \Illuminate\Support\Str::limit($privacy_policy[0]->heading, 50, $end='.....') !!}</td>
                                        <td>{!! \Illuminate\Support\Str::limit($privacy_policy[0]->content, 80, $end='.....') !!}</td>
                                        <td> <a class='btn btn-xs text-light btn-primary' href="{{ route('admin.appcontent.edit.app',['id'=>'privacy_policy'])}}"><i class=' fa fa-pencil'></i></a> </td>
                                    </tr>
                                @endif
                           
                            
                                @if(isset($term_condition))
                                    <tr>
                                        <td>Term & Condition</td>
                                        <td>{!! \Illuminate\Support\Str::limit($term_condition[0]->heading, 50, $end='.....') !!}</td>
                                        <td>{!! \Illuminate\Support\Str::limit($term_condition[0]->content, 80, $end='.....') !!}</td>
                                        <td> <a class='btn btn-xs text-light btn-primary' href="{{ route('admin.appcontent.edit.app',['id'=>'term_condition'])}}"><i class=' fa fa-pencil'></i></a> </td>
                                    </tr>
                                @endif

                                @if(isset($disclaimer))
                                    <tr>
                                        <td>Disclaimer</td>
                                        <td>{!! \Illuminate\Support\Str::limit($disclaimer[0]->heading, 50, $end='.....') !!}</td>
                                        <td>{!! \Illuminate\Support\Str::limit($disclaimer[0]->content, 80, $end='.....') !!}</td>
                                        <td> <a class='btn btn-xs text-light btn-primary'  href="{{ route('admin.appcontent.edit.app',['id'=>'disclaimer'])}}"><i class=' fa fa-pencil'></i></a> </td>
                                    </tr>
                                @endif
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

<script>

$(document).ready(function(){
    $('.dataTables-example').DataTable();
});

</script>
@endpush


