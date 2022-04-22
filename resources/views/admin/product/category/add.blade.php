@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Add Product Category</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add Product Category</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Add Product Category</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.category.store') }}" method="POST">
                            @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Category Name </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="category_name" value="{{old('category_name')}}"  />
                                            @if($errors->has('category_name'))
                                            <div class="error">{{ $errors->first('category_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Status </span></b>
                                        </div>
                                        <div class="col-sm-9 mb-2">
                                            <input type="checkbox" name="status" class="js-switch" checked />
                                            @if($errors->has('status'))
                                                <div class="error">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button class="btn btn-primary btn-md" type="submit">Save</button>
                                        </div>
                                    </div>
                                
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    </script>
@endpush
