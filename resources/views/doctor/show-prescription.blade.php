@extends('doctor.layouts.layout2')

@section('content')
<form action="{{route('doctor.store.prescription')}}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Prescription Detail</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="biller-info">
                        <h4 class="d-block">Dr. {{$prescription->getdoctor->name}} {{$prescription->getdoctor->l_name}}</h4>
                        <span class="d-block text-sm text-muted">{{$prescription->getdoctor->getspeciality->sp_name}}</span>
                        <span class="d-block text-sm text-muted">{{$prescription->getdoctor->getcity->name}}, {{$prescription->getdoctor->getcountry->name}}</span>
                    </div>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <div class="billing-info">
                        <h4 class="d-block">{{ \Carbon\Carbon::parse($prescription->date)->format('d M Y')}}</h4>
                        {{-- <span class="d-block text-muted">#INV0001</span> --}}
                    </div>
                </div>
            </div>
            
            <!-- Add Item -->
            {{-- <div class="add-more-item text-right">
                <a class="add-more-prescription" href="javascript:void(0);"><i class="fas fa-plus-circle"></i> Add Item</a>
            </div> --}}
            <!-- /Add Item -->
            {{-- <input type="hidden" name="user_id" value="{{ $patient_id}}">
            <input  type="hidden" name="doctor_id" value="{{ Auth::user()->id}}"> --}}
            <!-- Prescription Item -->
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center">
                            <thead>
                                <tr>
                                    <th style="min-width: 200px">Name</th>
                                    <th style="min-width: 80px;">Quantity</th>
                                    <th style="min-width: 80px">Days</th>
                                    <th style="min-width: 100px;">Time</th>
                                    <th style="min-width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody class="add-prescription">
                                @foreach ($prescription->getdetail as $row)
                                    <tr>
                                        <td><input type="text" disabled value="{{$row->medicine}}" name="medicine[]" class="form-control"></td>
                                        <td><input type="text" disabled value="{{$row->quantity}}" name="qty[]" class="form-control"></td>
                                        <td><input type="text" disabled value="{{$row->days}}" name="day[]" class="form-control"></td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label"> Morning <br>
                                                    <select name="morning[]" id="" class="form-check-input" disabled>
                                                        <option @if ($row->morning==0) selected @endif value="0">No</option>
                                                        <option @if ($row->morning==1) selected @endif value="1" >Yes</option>
                                                    </select>
                                                    {{-- <input type="text" name="morning[]"  class="form-check-input floating @error("morning") is-invalid @enderror">  --}}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label"> Afternoon <br>
                                                    <select name="afternon[]" id="" class="form-check-input " disabled>
                                                        <option @if ($row->afternoon==0) selected @endif  value="0">No</option>
                                                        <option @if ($row->afternoon==1) selected @endif  value="1">Yes</option>
                                                    </select>
                                                    {{-- <input type="checkbox" name="afternon[]"  class="form-check-input floating @error("afternon") is-invalid @enderror"> Afternoon --}}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label"> Evening <br>
                                                    <select name="evening[]" id="" class="form-check-input " disabled>
                                                        <option @if ($row->evening==0) selected @endif  value="0">No</option>
                                                        <option @if ($row->evening==1) selected @endif  value="1">Yes</option>
                                                    </select>
                                                    {{-- <input type="checkbox" name="evening[]"  class="form-check-input floating @error("evening") is-invalid @enderror"> Evening --}}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label"> Night <br>
                                                    <select name="night[]" id="" class="form-check-input " disabled>
                                                        <option @if ($row->night==0) selected @endif  value="0" >No</option>
                                                        <option @if ($row->night==1) selected @endif  value="1">Yes</option>
                                                    </select>
                                                    {{-- <input type="checkbox" name="night[]" class="form-check-input floating @error("night") is-invalid @enderror"> Night --}}
                                                </label>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <a href="#" class="btn bg-danger-light trash"><i class="far fa-trash-alt"></i></a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Prescription Item -->
            
            <!-- Signature -->
            {{-- <div class="row">
                <div class="col-md-12 text-right">
                    <div class="signature-wrap">
                        <div class="signature">
                            Click here to sign
                        </div>
                        <div class="sign-name">
                            <p class="mb-0">( Dr. Darren Elder )</p>
                            <span class="text-muted">Signature</span>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- /Signature -->
            
            <!-- Submit Section -->
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        <button type="reset" class="btn btn-secondary submit-btn">Clear</button>
                    </div>
                </div>
            </div> --}}
            <!-- /Submit Section -->
            
        </div>
    </div>
</form>
@endsection

@push('script')

@endpush