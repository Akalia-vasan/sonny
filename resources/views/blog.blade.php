@extends('layouts.app')

@section('content')
		
        <!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Blog</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Blog</h2>
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
                    
                        <div class="row blog-grid-row">
                            @foreach ($allblog as $allblog1)
                                <div class="col-md-6 col-sm-12">
                                
                                    <!-- Blog Post -->
                                    <div class="blog grid-blog">
                                        <div class="blog-image">
                                            <a href="{{ route('blogdetail',$allblog1->id)}}"><img class="img-fluid" style="max-height:150px;" src="{{ url('storage/'.$allblog1->blog_image) }}" alt="Post Image"></a>
                                        </div>
                                        <div class="blog-content">
                                            <ul class="entry-meta meta-item">
                                                <li>
                                                    <div class="post-author">
                                                        <a href="{{ route('blogdetail',$allblog1->id)}}">
                                                            @if($allblog1->type =='admin')
                                                                <span><i class="fa fa-hospital fa-lg text-primary mr-2" style="color:#09e5ab;"></i> By SugoiMed</span>
                                                            @else
                                                                <span><i class="fa fa-hospital fa-lg  text-primary mr-2" style="color:#09e5ab;"></i> Dr. {{ getdoctor($allblog1->author)->name }} {{ getdoctor($allblog1->author)->l_name }}</span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </li>
                                                <li><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($allblog1->created_at)->format('d M Y') }}</li>
                                            </ul>
                                            <h3 class="blog-title"><a href="{{ route('blogdetail',$allblog1->id)}}">{{$allblog1->blog_title}}</a></h3>
                                            <p class="mb-0">{!! \Illuminate\Support\Str::limit($allblog1->blog_description, 80, $end='.....') !!}</p>
                                        </div>
                                    </div>
                                    <!-- /Blog Post -->
                                    
                                </div>
                            @endforeach

                        </div>
                        
                        <!-- Blog Pagination -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="blog-pagination">
                                    <nav>
                                        @if ($allblog->lastPage() > 1)
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item {{ ($allblog->currentPage() == 1) ? ' disabled' : '' }}">
                                                    <a class="page-link" href="{{ $allblog->url(1) }}" tabindex="-1"><i class="fas fa-angle-double-left"></i></a>
                                                </li>
                                                @for ($i = 1; $i <= $allblog->lastPage(); $i++)
                                                    <li class="page-item {{ ($allblog->currentPage() == $i) ? ' active' : '' }}">
                                                        <a class="page-link" href="{{ $allblog->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ ($allblog->currentPage() == $allblog->lastPage()) ? ' disabled' : '' }}">
                                                    <a class="page-link" href="{{ $allblog->url($allblog->currentPage()+1) }}" ><i class="fas fa-angle-double-right"></i></a>
                                                </li>
                                            </ul>
                                        @endif
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- /Blog Pagination -->
                        
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

                        <!-- Tags -->
                        {{-- <div class="card tags-widget">
                            <div class="card-header">
                                <h4 class="card-title">Tags</h4>
                            </div>
                            <div class="card-body">
                                <ul class="tags">
                                    <li><a href="#" class="tag">Children</a></li>
                                    <li><a href="#" class="tag">Disease</a></li>
                                    <li><a href="#" class="tag">Appointment</a></li>
                                    <li><a href="#" class="tag">Booking</a></li>
                                    <li><a href="#" class="tag">Kids</a></li>
                                    <li><a href="#" class="tag">Health</a></li>
                                    <li><a href="#" class="tag">Family</a></li>
                                    <li><a href="#" class="tag">Tips</a></li>
                                    <li><a href="#" class="tag">Shedule</a></li>
                                    <li><a href="#" class="tag">Treatment</a></li>
                                    <li><a href="#" class="tag">Dr</a></li>
                                    <li><a href="#" class="tag">Clinic</a></li>
                                    <li><a href="#" class="tag">Online</a></li>
                                    <li><a href="#" class="tag">Health Care</a></li>
                                    <li><a href="#" class="tag">Consulting</a></li>
                                    <li><a href="#" class="tag">Doctors</a></li>
                                    <li><a href="#" class="tag">Neurology</a></li>
                                    <li><a href="#" class="tag">Dentists</a></li>
                                    <li><a href="#" class="tag">Specialist</a></li>
                                    <li><a href="#" class="tag">Doccure</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <!-- /Tags -->
                        
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