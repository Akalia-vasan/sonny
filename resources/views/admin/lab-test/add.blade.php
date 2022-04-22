@extends('admin.layouts.admin')

@section('content') 

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12"> 
                <h3 class="page-title">Lab Test Add</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Lab Test Add</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row" style="display:block;">
        <form action="{{ route('admin.lab_test.store') }}" method="post" enctype="multipart/form-data">
            @csrf					
            <div class="col-12">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-body">
                        <div class="row form-row">
            
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>Lab Test Name <span class="text-danger">*</span></label>
                                    <input type="text" name="test_name" value="{{old('test_name')}}" class="form-control floating @error('test_name') is-invalid @enderror" required>
                                    @error('test_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </div>
                            </div>

                            <div class="submit-section submit-btn-bottom">
                                <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /Basic Information -->

            </div>
        </form>
    </div>

@endsection
@push('script')
    
    <script>

        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#ff3e6c' });

        function myFunction3(id)
        {
            let el = $('#password');

            if(el.hasClass('fa-eye-slash'))
            {
                el.removeClass('fa-eye-slash');
                el.addClass('fa-eye');
                $('#'+id).attr('type', 'text');
            }
            else
            {
                el.removeClass('fa-eye');
                el.addClass('fa-eye-slash');
                $('#'+id).attr('type', 'password');
            }
        }
    </script>

@endpush


