@extends('doctor.layouts.doctorlayout')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                
                    <!-- Change Password Form -->
                    <form action="{{ route('doctor.update_password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Old Password</label>
                            <input type="password" class="form-control" name="old_password">
                            @error('old_password')
                                <div class="text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                            @error('password')
                                <div class="error text-warning">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                        </div>
                    </form>
                    <!-- /Change Password Form -->
                    
                </div>
            </div>
        </div>
    </div>

@endsection