@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit FAQ </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit FAQ </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Edit FAQ </h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.faq.update',$faq->id) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <input type="hidden" class="form-control" name="id" value="{{ $faq->id}}" />
                                 
                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Choose FAQ Category </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <select name="category_id" class="chosen-select form-control"  tabindex="-2">
                                                    <option value="0"> -- Select FAQ Category-- </option>
                                                    @foreach($faqcategory as $faqcategory1)
                                                        <option  @if($faq->category_id == $faqcategory1->id) selected @endif  value="{{ $faqcategory1->id}}">{{ $faqcategory1->name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>FAQ Question</span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="question"  value="{{ $faq->question }}"/>
                                            @if($errors->has('question'))
                                            <div class="error">{{ $errors->first('question') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>FAQ Answer</span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="text" class="form-control" name="answer"  value="{{ $faq->answer }}"/>
                                            @if($errors->has('answer'))
                                            <div class="error">{{ $errors->first('answer') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <b><span>Status </span></b>
                                        </div>
                                        <div class="col-sm-8 mb-2">
                                            <input type="checkbox" name="status" class="js-switch" @if($faq->active == '1') checked @endif />
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
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
    </script>
@endpush

