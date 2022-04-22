@extends('admin.layouts.admin')
@push('style')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush
@section('content')

<div class="page-header">
        <div class="row">
            <div class="col-sm-7 col-auto">
                <h3 class="page-title">List of Nurse Booking</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Nurse Booking</li>
                </ul>
            </div>
            <div class="col-sm-5 col">
                <!-- <a href="{{ route('admin.doctor.create')}}" class="btn btn-primary float-right mt-2">Add</a> -->
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="nurse_datatable table table-hover table-center mb-0">
						  <thead>
						    <tr>
						            <th>User Name</th>
                                    <th>User Mobile</th>
                                    <th>Nurse Service Type</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Actions</th>
						    </tr>
						  </thead>
						  <tbody id="dynamic_body">

						 @foreach($data as $row) 	
						    <tr row_id="{{$row->id}}" status="{{$row->status}}">
								<td>{{$row->user_name}}</td>
								<td>{{$row->user_mobile}}</td>
								<td>{{$row->nurse_type}}</td>
								<td>{{$row->location}}</td>
								@if($row->status ==0)
								<td>Pending</td>
								@elseif($row->status ==1)
								<td>Processing</td>
								@elseif($row->status ==2)
								<td>Confirm</td>
								@elseif($row->status ==3)
								<td>Rejected</td>
								@elseif($row->status ==4)
								<td>Cancelled</td>
								@elseif($row->status ==5)
								<td>Completed</td>
								@endif
								<td>
                                    <div class="actions">

                                        <a class="btn btn-sm bg-primary-light" href="#"
                                        data-toggle="modal" data-target="#nurse_model">
                                            <i class="fe fe-eye"></i> 
                                        </a>

                                        <a class="btn btn-sm bg-danger-light demotest1" href="
                                        	{{ url('admin/delete_nurse_booking_order/'.$row->id)}}">
                                            <i class="fe fe-trash"></i> 
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
    </div>

    <!-- Modal -->
<div class="modal fade" id="nurse_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="{{route('admin.update_nurse_booking_status')}}">	
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Nurse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="col-md-12" style="display: flex;align-items: baseline;">
					<div class="col-md-2">Status</div>
					<div class="col-md-10">
					<select class="form-control" name="status" id="change_sts">
						<option value="0">Pending</option>
						<option value="1">Processing</option>
						<option value="2">Confirm</option>
						<option value="3">Rejected</option>
						<option value="4">Cancelled</option>
						<option value="5">Completed</option>
					</select>
				</div>
				</div>
				<input type="hidden" name="booking_id" id="booking_id">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Done</button>
      </div>
    </div>
</form>

  </div>
</div>
@endsection

@push('script')
     <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
   $(document).ready(function(){
            $('.nurse_datatable').DataTable();
        });

	$(document).ready(function(){
	     $('body').on('click','#dynamic_body tr',function(){
	     	let id = $(this).attr('row_id');
	     	let sts = $(this).attr('status');
            $('#booking_id').val(id);
            $('#change_sts').val(sts);
	     });
	});
</script>
@endpush

