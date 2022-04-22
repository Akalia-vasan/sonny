@extends('doctor.layouts.doctorlayout')

@push('style')
    {{-- <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-12 col">
                            <a href="{{ route('doctor.blog.create')}}" class="btn btn-primary float-right mt-2 mb-2">Add</a>
                        </div>
                    </div>
                    
                    <!-- Tab Content -->
                    <div class="tab-content pt-0">
                        
                        <!-- Accounts Tab -->
                        <div id="pat_accounts" class="tab-pane fade show active">
                            <div class="card card-table mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Blog Title</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allblog as $allblog1)
                                                    <tr>
                                                        <td>{{ Carbon\Carbon::parse($allblog1->created_at)->format('d M Y') }} <span class="d-block text-info">{{ Carbon\Carbon::parse($allblog1->created_at)->format('H:i A') }}</span></td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="{{route('doctor.blog.show',$allblog1->id)}}" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="{{ url('storage/'.$allblog1->blog_image) }}" alt="User Image"></a>
                                                                <a href="{{route('doctor.blog.show',$allblog1->id)}}">{{$allblog1->blog_title}} </a>
                                                            </h2>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="table-action">
                                                                <a href="{{route('doctor.blog.show',$allblog1->id)}}" class="btn btn-sm bg-info-light">
                                                                    <i class="far fa-eye"></i> View
                                                                </a>
                                                                
                                                                <a href="{{route('doctor.blog.edit',$allblog1->id)}}" class="btn btn-sm bg-success-light">
                                                                    <i class="fas fa-pencil"></i> Edit
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Accounts Tab -->
                            
                    </div>
                    <!-- Tab Content -->
                    
                </div>
            </div>
        </div>
    </div>
        
    <!-- Page Header -->
    {{-- <div class="page-header">
        <div class="row">
            <div class="col-sm-5 col">
                <a href="{{ route('doctor.blog.create')}}" class="btn btn-primary float-right mt-2">Add</a>
            </div>
        </div>
    </div> --}}
    <!-- /Page Header -->
    
     {{-- <div class="row">
        <div class="col-sm-12">
            
                <!-- Blog -->
                <div class="row blog-grid-row">
                    @foreach ($allblog as $allblog1)
            
                        <div class="col-md-6 col-xl-4 col-sm-12">
                        
                            <!-- Blog Post -->
                            <div class="blog grid-blog">
                                <div class="blog-image">
                                    <a href="{{route('admin.blog.comment',$allblog1->id)}}"><img class="img-fluid" src="{{ url('storage/'.$allblog1->blog_image) }}" alt="Post Image"></a>
                                </div>
                                <div class="blog-content">
                                    <ul class="entry-meta meta-item">
                                        <li>
                                            <div class="post-author">
                                                <a href="{{route('admin.blog.comment',$allblog1->id)}}">
                                                    @if($allblog1->type =='admin')
                                                        <span><i class="fa fa-hospital text-primary" style="color:#09e5ab;"></i> By Hospirent</span>
                                                    @else
                                                        <span><i class="fa fa-hospital text-primary" style="color:#09e5ab;"></i> Dr. Ruby Perrin</span>
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
                                        <a href="javascript:void(0);" class="text-danger demotest1" ><i class="fa fa-trash"></i> Inactive</a>
                                        <form action="{{ route('admin.blog.destroy',$allblog1->id) }}" method="post" id="form_submit_destroy" >
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
    </div> --}}
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
                // event.preventDefault();
                // const url = $(this).attr('href');
                // console.log(url);
                //     swal({
                //         title: "Are you sure?",
                //         text: "Your will not be able to recover this record!",
                //         type: "warning",
                //         showCancelButton: true,
                //         confirmButtonColor: "#DD6B55",
                //         confirmButtonText: "Delete",
                //         cancelButtonText: "Cancel",
                //         closeOnConfirm: false,
                //         closeOnCancel: false },
                //     function (isConfirm) {
                //         if (isConfirm) {
                            $('#form_submit_destroy').submit();
                    //         swal("Deleted!", "Your record has been deleted.", "success");
                    //     } else {
                    //         swal("Cancelled", "Your record is safe.", "error");
                    //     }
                    // });
            });

    </script>
@endpush