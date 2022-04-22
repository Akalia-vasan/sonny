@extends('doctor.layouts.doctorlayout')

@section('content')

    <div class="row">
        <div class="col-lg-5 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Account</h3>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <a title="Edit Profile" class="btn btn-primary btn-sm" href="#account_modal" data-toggle="modal"><i class="fas fa-pencil"></i> Edit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-view-bottom">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="info-list">
                                    <div class="title">Bank Name</div>
                                    <div class="text" id="bank_name">{{Auth::user()->bank_name}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-list">
                                    <div class="title">IFSC Code</div>
                                    <div class="text" id="branch_name">{{Auth::user()->ifsc_code}}</div>
                                </div>
                            </div>
                         
                            <div class="col-lg-6 mt-5">
                                <div class="info-list">
                                    <div class="title">Account Number</div>
                                    <div class="text" id="account_no">{{Auth::user()->account}}</div>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-5">
                                <div class="info-list">
                                    <div class="title">Account Name</div>
                                    <div class="text" id="account_name">{{Auth::user()->account_name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="account-card bg-success-light">
                                <span>₹{{$earning}}</span> Earned
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="account-card bg-warning-light">
                                <span>₹{{$requested}}</span> Requested
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="account-card bg-purple-light">
                                <span>₹{{$wallet->amount}}</span> Balance
                            </div>

                        </div>
                        
                        <div class="col-md-12 text-center">
                            <a @if ($requested==0) href="#payment_request_modal" @endif  class="btn btn-primary request_btn" data-toggle="modal">Payment Request</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body pt-0">
                
                    <!-- Tab Menu -->
                    <nav class="user-tabs mb-4">
                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" href="#pat_accounts" data-toggle="tab">Accounts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pat_refundrequest" data-toggle="tab">Doctor Payout Request</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /Tab Menu -->
                    
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
                                                    <th>Patient Name</th>
                                                    <th class="text-center">Amount</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($accounts as $account)
                                                    <tr>
                                                        <td>{{ Carbon\Carbon::parse($account->created_at)->format('d M Y')}} <span class="d-block text-info">{{ Carbon\Carbon::parse($account->created_at)->format('h:i A')}}</span></td>
                                                        <td>
                                                            <h2 class="table-avatar">
                                                                <a href="javascript:;" class="avatar avatar-sm mr-2">
                                                                    @if ($account->getuserbooked->profile_image)
                                                                        <img class="avatar-img rounded-circle" src="{{$account->getuserbooked->profile_image}}" alt="User Image">
                                                                    @else
                                                                        <img class="avatar-img rounded-circle" src="{{asset('assets/img/patients/patient.jpg')}}" alt="User Image">   
                                                                    @endif
                                                                </a>
                                                                <a href="javascript:;">{{$account->getuserbooked->name}} </a>
                                                            </h2>
                                                        </td>
                                                        <td class="text-center">₹ {{$account->price}}</td>
                                                        <td><span class="badge badge-pill bg-success-light">Paid</span></td>
                                                        {{-- <td class="text-right">
                                                            <div class="table-action">
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                                    <i class="far fa-eye"></i> View
                                                                </a>
                                                                
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-success-light">
                                                                    <i class="fas fa-check"></i> Accept
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </a>
                                                            </div>
                                                        </td> --}}
                                                    </tr> 
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Accounts Tab -->
                        
                        <!-- Refund Request Tab -->
                        <div class="tab-pane fade" id="pat_refundrequest">
                            <div class="card card-table mb-0">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    {{-- <th>Patient Name</th> --}}
                                                    <th class="text-center">Amount</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($payout as $row)
                                                    <tr>
                                                        <td>{{ Carbon\Carbon::parse($row->created_at)->format('d M Y')}} <span class="d-block text-info">{{ Carbon\Carbon::parse($row->created_at)->format('h:i A')}}</span></td>
                                                        {{-- <td>
                                                            <h2 class="table-avatar">
                                                                <a href="patient-profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient.jpg" alt="User Image"></a>
                                                                <a href="patient-profile.html">Richard Wilson <span>#PT0016</span></a>
                                                            </h2>
                                                        </td> --}}
                                                        <td class="text-center">₹{{$row->amount}}</td>
                                                        <td>
                                                            @if ($row->status==0)
                                                                <span class="badge badge-pill bg-danger-light">Pending</span>
                                                            @else  
                                                                <span class="badge badge-pill bg-success-light">Paid</span>
                                                            @endif
                                                            
                                                        </td>
                                                        {{-- <td class="text-right">
                                                            <div class="table-action">
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-info-light">
                                                                    <i class="far fa-eye"></i> View
                                                                </a>
                                                                
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-success-light">
                                                                    <i class="fas fa-check"></i> Accept
                                                                </a>
                                                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </a>
                                                            </div>
                                                        </td> --}}
                                                    </tr>   
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Refund Request Tab -->
                            
                    </div>
                    <!-- Tab Content -->
                    
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade custom-modal" id="payment_request_modal" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Payment Request</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('doctor.account.payout_request')}}" id="payment_request_form" method="post">
                    @csrf
                    <input type="hidden" name="payment_type" id="payment_type" value="1">
                    <div class="form-group">
                        <label>Request Amount</label>
                        <input type="number" name="amount" id="request_amount" class="form-control" required max="{{$wallet->amount}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        <span class="help-block"></span>
                    </div>
                    {{-- <div class="form-group">
                        <label>Description (Optional)</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                        <span class="help-block"></span>
                    </div> --}}
                
            </div>
            <div class="modal-footer text-center">
                <button type="submit" id="request_btn" class="btn btn-primary">Request</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- /Payment Request Moodal -->

<!-- Account Details Modal-->
<div class="modal fade custom-modal" id="account_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Account Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('doctor.account.update')}}" id="accounts_form" method="post">
                   @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Bank Name</label>
                                <input type="text" name="bank_name" required class="form-control bank_name" value="{{Auth::user()->bank_name}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" required class="form-control branch_name" value="{{Auth::user()->ifsc_code}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Account Number</label>
                                <input type="text" name="account" required class="form-control account_no" value="{{Auth::user()->account}}">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Account Name</label>
                                <input type="text" name="account_name" required class="form-control acc_name" value="{{Auth::user()->account_name}}">
                                <span class="help-block"></span>
                            </div>
                        </div> 
                    </div>
                
            </div>
            <div class="modal-footer text-center">
                <button type="submit" id="acc_btn" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
@push('script')



@endpush