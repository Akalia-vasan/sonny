@extends('doctor.layouts.doctorlayout')

@push('style')
@endpush
@section('content')
      <!-- Page Content -->

      <div class="content">
        <div class="container">
        
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-view">
                        <div class="blog blog-single-post">
                            <div class="blog-image">
                                <a href="javascript:void(0);"><img alt="" src="{{ url('storage/'.$allblog->blog_image) }}" class="img-fluid"></a>
                            </div>
                            <h3 class="blog-title">{{ $allblog->blog_title}}</h3>
                            <div class="blog-info clearfix">
                                <div class="post-left">
                                    <ul>
                                        <li>
                                            <div class="post-author">
                                                <a href="javascript:;">
                                                    @if(Auth::user()->profile_image!= null)
                                                        <img src="{{Auth::user()->profile_image}}" alt="Post Author">
                                                    @else
                                                        <img src="{{asset('assets/img/profiles/avatar-01.jpg')}}" alt="Post Author">
                                                    @endif
                                                    
                                                    <span>Dr. {{ getdoctor($allblog->author)->name }} {{ getdoctor($allblog->author)->l_name }}</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li><i class="far fa-calendar"></i>{{ Carbon\Carbon::parse($allblog->created_at)->format('d M Y') }}</li>
                                        <li><i class="far fa-comments"></i>{{count($allblogcomment)}} Comments</li>
                                        <li><i class="fa fa-tags"></i>{{ $allblog->blogcategory->category_name }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="blog-content">
                                <p class="text-justify">{{ $allblog->blog_description}}</p>
                                @if($allblog->video_url!=null)
                                    <iframe width="100%" height="315"
                                        src="{{ $allblog->video_url }}">
                                    </iframe>
                                @endif
                            </div>
                        </div>
                    
                        <div class="card blog-comments clearfix">
                            <div class="card-header">
                                <h4 class="card-title">Comments ({{count($allblogcomment)}})</h4>
                            </div>
                            <div class="card-body pb-0">
                                @if(count($allblogcomment)>0)
                                    <ul class="comments-list">
                                        @foreach($allblogcomment as $allblogcomment1)
                                            <li>
                                                <div class="comment">
                                                    <div class="comment-author">
                                                        <i class="avatar fa fa-user fa-2x mt-3 ml-3" style="color:#0De0fe;"></i>
                                                    </div>
                                                    <div class="comment-block">
                                                        <span class="comment-by">
                                                            <span class="blog-author-name" >{{$allblogcomment1->name}}</span>
                                                        </span>
                                                        <p>{{$allblogcomment1->comment}}</p>
                                                        <p class="blog-date">{{ Carbon\Carbon::parse($allblogcomment1->created_at)->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No Comments</p>
                                @endif
                        </div>
                        </div>
                        
                    </div>
                </div>
            
                
        </div>
        </div>

    </div>		
    <!-- /Page Content -->
    
@endsection
@push('script')

@endpush