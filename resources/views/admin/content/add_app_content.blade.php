@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Add App Content</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Add App Content</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Add App Content</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.appcontent.app_store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Page Name </span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <select class="form-control m-b" value="{{ old('key') }}" name="key">
                                        <option value="">--Select--</option>
                                        <option value="privacy_policy">Privacy & Policy</option>
                                        <option value="term_condition">Term & Condition</option>
                                        <option value="disclaimer"> Disclaimer</option>
                                    </select>
                                    @if($errors->has('key'))
                                    <div class="error">{{ $errors->first('key') }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row fieldGroup">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Add Page Content</span></b>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <textarea  class="form-control" name="heading[]" placeholder="Enter App Heading"></textarea>
                                            @if($errors->has('heading'))
                                                <div class="error">{{ $errors->first('heading') }}</div>
                                            @endif
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <textarea  class="form-control" name="content[]"  placeholder="Enter App content"></textarea>
                                            @if($errors->has('content'))
                                                <div class="error">{{ $errors->first('content') }}</div>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-1 col-sm-offset-2 mt-3 text-center">
                                    <a href="javascript:void(0)" class="btn btn-xs btn-outline-success addMore"><i class="fa fa-plus"></i></a>
                                         
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button class="btn btn-primary btn-md" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="form-group row fieldGroupCopy" style="display: none;">
                            <div class="row">
                            <div class="col-sm-2 col-sm-offset-2">
                                <b style="display:none;"><span>Add Page Content</span></b>
                            </div>
                            <div class="col-sm-8 mb-2">
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <textarea class="form-control" name="heading[]" placeholder="Enter App Heading"></textarea>
                                        @if($errors->has('heading'))
                                        <div class="error">{{ $errors->first('heading') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <textarea  class="form-control" name="content[]" placeholder="Enter App content"></textarea>
                                        @if($errors->has('content'))
                                        <div class="error">{{ $errors->first('content') }}</div>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-1 col-sm-offset-2 mt-3 text-center">
                                <a href="javascript:void(0)" class="btn btn-xs btn-outline-danger remove"><i class="fa fa-minus"></i></a>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
        $(document).ready(function(){
            //group add limit
            var maxGroup = 50;
            
            //add more fields group
            $(".addMore").click(function(){
                if($('body').find('.fieldGroup').length < maxGroup){
                    var fieldHTML = '<div class="form-group fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
                    $('body').find('.fieldGroup:last').after(fieldHTML);
                }else{
                    alert('Maximum '+maxGroup+' groups are allowed.');
                }
            });
            
            //remove fields group
            $("body").on("click",".remove",function(){ 
                $(this).parents(".fieldGroup").remove();
            });
        });
  </script>
@endpush
