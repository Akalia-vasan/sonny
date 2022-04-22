@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Add FAQ </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add FAQ </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Add FAQ </h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.faq.store') }}" method="POST">
                            @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Choose FAQ Category </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <select name="category_id" class="chosen-select form-control"  tabindex="-2">
                                                    <option value="0"> -- Select FAQ Category-- </option>
                                                    @foreach($faqcategory as $faqcategory1)
                                                        <option {{ old('category_id') == $faqcategory1->id ? 'selected' : '' }} value="{{ $faqcategory1->id}}">{{ $faqcategory1->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>FAQ Question </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="question" value="{{old('question')}}" />
                                            @if($errors->has('question'))
                                            <div class="error">{{ $errors->first('question') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>FAQ Answer </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="answer" value="{{old('answer')}}" />
                                            @if($errors->has('answer'))
                                            <div class="error">{{ $errors->first('answer') }}</div>
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
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Chosen -->
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    </script>
@endpush
