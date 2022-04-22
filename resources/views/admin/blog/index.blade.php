@extends('admin.layouts.admin')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">Blog</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Blog</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <a href="{{ route('admin.blog.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
     <div class="row">
        <div class="col-sm-12">
                    
                <div class="row mb-5">
                    <div class="col">
                        <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('admin.blog.index')}}">Acitive Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.blog.pending')}}">Pending Blog</a>
                            </li>
                        </ul>
                    </div>
                </div>
            
                <!-- Blog -->
                <div class="row blog-grid-row">
                    @foreach ($allblog as $allblog1)
            
                        <div class="col-md-6 col-xl-4 col-sm-12">
                        
                            <!-- Blog Post -->
                            <div class="blog grid-blog">
                                <div class="blog-image">
                                    <a href="{{route('admin.blog.comment',$allblog1->id)}}"><img class="img-fluid" style="max-height:200px;" src="{{ url('storage/'.$allblog1->blog_image) }}" alt="Post Image"></a>
                                </div>
                                <div class="blog-content">
                                    <ul class="entry-meta meta-item">
                                        <li>
                                            <div class="post-author">
                                                <a href="{{route('admin.blog.comment',$allblog1->id)}}">
                                                    @if($allblog1->type =='admin')
                                                        <span><i class="fa fa-hospital text-primary" style="color:#09e5ab;"></i> By Hospirent</span>
                                                    @else
                                                        <span><i class="fa fa-hospital text-primary" style="color:#09e5ab;"></i> Dr. {{ getdoctor($allblog1->author)->name }} {{ getdoctor($allblog1->author)->l_name }}</span>
                                                    @endif
                                                </a>
                                            </div>
                                        </li>
                                        <li><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($allblog1->created_at)->format('d M Y') }}</li>
                                    </ul>
                                    <h3 class="blog-title"><a href="{{route('admin.blog.comment',$allblog1->id)}}">{{ $allblog1->blog_title }}</a></h3>
                                    <p class="mb-0">{!! \Illuminate\Support\Str::limit($allblog1->blog_description, 80, $end='.....') !!}</p>
                                </div>
                                <div class="row pt-3">
                                    <div class="col"><a href="{{ route('admin.blog.edit',$allblog1->id)}}" class="text-success"><i class="fa fa-pencil"></i> Edit</a></div>
                                                                                                
                                    <div class="col text-right">
                                        <a href="javascript:void(0);" class="text-danger demotest1" data-id="{{$allblog1->id}}"><i class="fa fa-trash"></i> Inactive</a>
                                        <form action="{{ route('admin.blog.destroy',$allblog1->id) }}" method="post" id="form_submit_destroy{{$allblog1->id}}" >
                                            @csrf	
                                            @method('DELETE')
                                            
                                        </form>
                                    </div>
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
                <!-- /Blog -->
        </div>			
    </div>
@endsection
@push('script')
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>

        $(document).ready(function(){
            $('.doctor-datatable').DataTable();
        });

        $(document).on('click', '.demotest1', function() {
            var id = $(this).attr('data-id');
            $('#form_submit_destroy'+id).submit();
        });

    </script>
@endpush