@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit FAQ Category</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit FAQ Category</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit FAQ Category</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.faqcategory.update',$faqcategory->id) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" class="form-control" name="id" value="{{ $faqcategory->id}}" />
                                 

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>FAQ Name </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="name" value="{{ $faqcategory->name}}" />
                                            @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Status </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="checkbox" name="status" class="js-switch" @if($faqcategory->status == '1') checked @endif />
                                            @if($errors->has('status'))
                                            <div class="error">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button class="btn btn-primary btn-md" type="submit">Update</button>
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

