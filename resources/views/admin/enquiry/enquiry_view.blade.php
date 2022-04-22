@extends('admin.layouts.admin')

@push('style')
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Enquiry</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Enquiry Details</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        @if($enquiry)
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-bar-chart">

                                <div class="row">
                                    <div class="col-md-2"><b>Name </b></div>
                                    <div class="col-md-10"> {{ $enquiry->name}}</div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><b>Email  </b></div>
                                    <div class="col-md-10"> {{ $enquiry->email}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><b>Mobile  </b></div>
                                    <div class="col-md-10"> {{ $enquiry->mobile}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><b>Comment </b></div>
                                    <div class="col-md-10"> {{ $enquiry->comment}}</div>
                                </div>                                      
                            </div>
                        </div>
                </div>
            </div>
        </div>

        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Reply</h5>
                    </div>
                    <div class="ibox-content">
                        @if($enquiry->reply)
                        <div class="row">
                            <div class="col-md-2"><b>Your Reply </b></div>
                            <div class="col-md-10"> {{ $enquiry->reply}}</div>
                        </div>
                    @else
                        <form action="{{ route('admin.enquiry.reply')}}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $enquiry->id}}" name="id"/>
                            <input type="hidden" value="{{ $enquiry->email}}" name="email"/>
                            <input type="hidden" value="New enquiry from User" name="subject"/>
                    
                            <div class="form-group row">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <b><span>Send Your Reply</span></b>
                                </div>
                                <div class="col-sm-10 mb-2">
                                    <textarea  class="form-control" rows="5" name="reply" >{{ $enquiry->reply}}</textarea>
                                    @if($errors->has('reply'))
                                        <div class="error">{{ $errors->first('reply') }}</div>
                                    @endif
                                </div>
                        
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-reply"></i> Send</button>
                                </div>
                            </div>
                        </form>
                    @endif
                        
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        var ckEditor = document.getElementById('ckEditor');
        if (ckEditor != undefined && ckEditor != null) {
            CKEDITOR.replace('ckEditor', {
                language: 'en',
                filebrowserBrowseUrl: 'path',
                removeButtons: 'Save',
                allowedContent: true,
            });
        }
    </script>
@endpush