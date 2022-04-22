@extends('doctor.layouts.doctorlayout')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="widget review-listing">
                <ul class="comments-list">
                  @php $j=1; @endphp
                  @foreach ($rating as $value)
                    <li 
                    {{-- @if($j!=1 && $j!=2) style="display:none;" class="allshow" @endif --}}
                    >
                      <div class="comment">
                        @if ($value->getUser->user_profile)
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="{{$value->getUser->user_profile}}">
                        @else
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="{{asset('assets/img/patients/patient.jpg')}}">
                        @endif
                        <div class="comment-body">
                          <div class="meta-data">
                            <span class="comment-author"> {{$value->getUser->name}}</span>
                            <span class="comment-date">Reviewed   {{$value->created_at}}</span>
                            <div class="review-count rating">
                              @for($i=0;$i<$value->rating;$i++)
                                <i class="fas fa-star filled"></i>
                              @endfor
                              @for($i=$value->rating;$i<5;$i++)
                                <i class="fas fa-star"></i>
                              @endfor
                              
                            </div>
                          </div>
                          <p class="recommended"><i class="far fa-thumbs-up"></i> {{$value->type}}</p>
                          <p class="comment-content">
                            {{$value->feedback}}
                          </p>   
                        </div>
                      </div>
                    </li>
                  {{-- @php $j++; @endphp --}}
                  @endforeach
                  <!-- Comment List -->
            
                  <!-- /Comment List --> 
                </ul>
                
                <!-- Show All -->
                {{-- @if (count($rating)>2)
                 <div class="all-feedback text-center">
                    <a href="javascript:void(0)" id="allshow" class="btn btn-primary btn-sm">
                      Show all feedback <strong>( {{count($rating)-2 }})</strong>
                    </a>
                 </div>
                @endif --}}
                <!-- /Show All -->
                
              </div>
        </div>
    </div>
@endsection
@push('script')

    <script>
      

    </script>

@endpush