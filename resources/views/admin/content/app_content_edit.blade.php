@extends('admin.layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Edit App Content</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Edit App Content</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    @if($keydata=='privacy_policy')
        @if($privacy_policy)
            <div class="row">
                <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Privacy & Policy</h5>
                            </div>
                            <div class="ibox-content">
                                <form action="{{ route('admin.appcontent.app_update') }}" method="POST">
                                    @csrf
                                
                                    <div class="form-group row">
                                        <div class="col-sm-5  text-center col-sm-offset-2">
                                            <label><b><span>Heading</span></b></label>
                                        </div>
                                        <div class="col-sm-6 text-center col-sm-offset-2">
                                        <label> <b><span>Content</span></b></label>
                                        </div>
                                        <div class="col-sm-1 col-sm-offset-2">
                                        
                                        </div>
                                            
                                            
                                            
                                                @foreach($privacy_policy as $privacy_policy1)
                                                <div class="col-sm-5 mb-2">
                                                    <input type="hidden" value="{{ $privacy_policy1->id}}" name="id[]"/>
                                                    <input type="hidden" value="{{ $privacy_policy1->key}}" name="key[]"/>
                                                    <textarea  class="form-control" name="heading[]" >{{ $privacy_policy1->heading}}</textarea>
                                                        @if($errors->has('heading'))
                                                            <div class="error">{{ $errors->first('heading') }}</div>
                                                        @endif
                                                    
                                                </div>
                                                <div class="col-sm-6 mb-2">
                                                    <textarea  class="form-control" name="content[]" >{{ $privacy_policy1->content}}</textarea>
                                                        @if($errors->has('content'))
                                                            <div class="error">{{ $errors->first('content') }}</div>
                                                        @endif
                                                </div>
                                                <div class="col-sm-1 mb-2 text-center mt-3">
                                                    <a href="{{ route('admin.appcontent.delete',['id'=>$privacy_policy1->id])}}" class="btn btn-xs btn-outline-primary"><i class="fa fa-minus"></i></a>
                                                </div>
                                                @endforeach
                                    </div>
                                    
                                    <div class="form-group row ml-2">
                                        <div class="col-sm-offset-2 text-right">
                                            <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        @endif
    @endif
    @if($keydata=='term_condition')
        @if($term_condition)
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Term & Condition</h5>
                        </div>
                        <div class="ibox-content">
                            <form action="{{ route('admin.appcontent.app_update') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-5 col-sm-offset-2 text-center">
                                        <label><b><span>Heading</span></b></label>
                                    </div>
                                    <div class="col-sm-6 col-sm-offset-2 text-center">
                                       <label> <b><span>Content</span></b></label>
                                    </div>
                                    <div class="col-sm-1 col-sm-offset-2">
                                     </div>
                                   
                                        
                                        
                                        
                                            @foreach($term_condition as $term_condition1)
                                            <div class="col-sm-5 mb-2">
                                                <input type="hidden" value="{{ $term_condition1->id}}" name="id[]"/>
                                                <input type="hidden" value="{{ $term_condition1->key}}" name="key[]"/>
                                                <textarea  class="form-control" name="heading[]" >{{ $term_condition1->heading}}</textarea>
                                                    @if($errors->has('heading'))
                                                        <div class="error">{{ $errors->first('heading') }}</div>
                                                    @endif
                                                
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <textarea  class="form-control" name="content[]" >{{ $term_condition1->content}}</textarea>
                                                    @if($errors->has('content'))
                                                        <div class="error">{{ $errors->first('content') }}</div>
                                                    @endif
                                            </div>
                                            <div class="col-sm-1 mb-2 text-center mt-3">
                                                <a href="{{ route('admin.appcontent.delete',['id'=>$term_condition1->id])}}" class="btn btn-xs btn-outline-primary"><i class="fa fa-minus"></i></a>
                                            </div>
                                            @endforeach
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    </div>
                                </div>

                            </form>
                            
                        
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if($keydata=='disclaimer')
        @if($disclaimer)
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Disclaimer</h5>
                        </div>
                        <div class="ibox-content">
                            <form action="{{ route('admin.appcontent.app_update') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-5 col-sm-offset-2 text-center">
                                        <label><b><span>Heading</span></b></label>
                                    </div>
                                    <div class="col-sm-6 col-sm-offset-2 text-center">
                                       <label> <b><span>Content</span></b></label>
                                    </div>
                                    <div class="col-sm-1 col-sm-offset-2">
                                     </div>
                                   
                                        
                                        
                                        
                                            @foreach($disclaimer as $disclaimer1)
                                            <div class="col-sm-5 mb-2">
                                                <input type="hidden" value="{{ $disclaimer1->id}}" name="id[]"/>
                                                <input type="hidden" value="{{ $disclaimer1->key}}" name="key[]"/>
                                                <textarea  class="form-control" name="heading[]" >{{ $disclaimer1->heading}}</textarea>
                                                    @if($errors->has('heading'))
                                                        <div class="error">{{ $errors->first('heading') }}</div>
                                                    @endif
                                                
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <textarea  class="form-control" name="content[]" >{{ $disclaimer1->content}}</textarea>
                                                    @if($errors->has('content'))
                                                        <div class="error">{{ $errors->first('content') }}</div>
                                                    @endif
                                            </div>
                                            <div class="col-sm-1 mb-2 text-center mt-3">
                                                <a href="{{ route('admin.appcontent.delete',['id'=>$disclaimer1->id])}}" class="btn btn-xs btn-outline-primary"><i class="fa fa-minus"></i></a>
                                            </div>
                                            @endforeach
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    </div>
                                </div>

                            </form>
                            
                        
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

@endsection

@push('script')
@endpush