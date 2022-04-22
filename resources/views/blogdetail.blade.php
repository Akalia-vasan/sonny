@extends('layouts.app')

@section('content')
			
	<!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">Blog Details</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->
    
    <!-- Page Content -->
    <div class="content">
        <div class="container">
        
            <div class="row">
                <div class="col-lg-8 col-md-12">
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
                                                    @if($allblog->type =='doctor' && getdoctor($allblog->author)->profile_image!=null)
                                                        <img src="{{getdoctor($allblog->author)->profile_image}}" alt="Post Author">
                                                    @else
                                                        <img src="{{asset('assets/img/doctors/doctor-thumb-01.jpg')}}" alt="Post Author">
                                                    @endif
                                                    @if($allblog->type =='admin')
                                                        <span> By SugoiMed</span>
                                                    @else
                                                        <span>Dr. {{ getdoctor($allblog->author)->name }} {{ getdoctor($allblog->author)->l_name }}</span>
                                                    @endif
                                                     {{-- <span>Dr. {{ getdoctor($allblog->author)->name }} {{ getdoctor($allblog->author)->l_name }}</span> --}}
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
                                                            <span class="blog-author-name">{{$allblogcomment1->name}}</span>
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
                        
                        <div class="card new-comment clearfix">
                            <div class="card-header">
                                <h4 class="card-title">Leave Comment</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('post.comment')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{$allblog->id}}" class="form-control">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Your Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Comments <span class="text-danger">*</span></label>
                                        <textarea rows="4" name="comment" class="form-control" required></textarea>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            
                <!-- Blog Sidebar -->
                <div class="col-lg-4 col-md-12 sidebar-right theiaStickySidebar">

                    <!-- Latest Posts -->
                    <div class="card post-widget">
                        <div class="card-header">
                            <h4 class="card-title">Latest Posts</h4>
                        </div>
                        <div class="card-body">
                            <ul class="latest-posts">
                                @foreach ($latestblog as $latestblog1)  
                                    <li>
                                        <div class="post-thumb">
                                            <a href="{{ route('blogdetail',$latestblog1->id)}}">
                                                <img class="img-fluid" src="{{ url('storage/'.$latestblog1->blog_image) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-info">
                                            <h4>
                                                <a href="{{ route('blogdetail',$latestblog1->id)}}">{{ $latestblog1->blog_title }}</a>
                                            </h4>
                                            <p>{{ Carbon\Carbon::parse($latestblog1->created_at)->format('d M Y') }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- /Latest Posts -->

                    <!-- Categories -->
                    <div class="card category-widget">
                        <div class="card-header">
                            <h4 class="card-title">Blog Categories</h4>
                        </div>
                        <div class="card-body">
                            <ul class="categories">
                                @if(isset($blogcategory))
                                    @foreach ($blogcategory as $blogcategory1)
                                        <li><a href="javascript:;">{{ $blogcategory1->blogcategory->category_name}} <span>({{ $blogcategory1->total }})</span></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- /Categories -->
                    
                </div>
                <!-- /Blog Sidebar -->
                
        </div>
        </div>

    </div>		
    <!-- /Page Content -->
			
@endsection	
@push('script')	
	<script>
		
	</script>  
@endpush     