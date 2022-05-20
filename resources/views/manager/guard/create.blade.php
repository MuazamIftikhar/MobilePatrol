@extends('layouts.auth')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{$title}}</h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->

                    <!--end::Actions-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">

                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Dashboard-->
                @if (session('message'))
                    <div class="alert alert-{{session('message')['class']}}" role="alert">
                        <span  class="alert-text"><strong>{{strtoupper(session('message')['class'])}}!</strong> {{session('message')['result']}}</span>
                    </div>
                @endif
                <form method="post" action="{{route('save_guard')}}" enctype="multipart/form-data">
                    @csrf
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Body-->
                                    <div class="card-body p-5">
                                        <div class="alert alert-default bg-light-info" role="alert">
                                            <span  class="alert-text"><strong>Note!</strong> Guard phone number will be automatically converted to password.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Guard Name</label>
                                                    <input type="text" name="guard_name" required
                                                           class="form-control @error('guard_name') is-invalid @enderror"
                                                           placeholder="Guard name" value="{{old('guard_name')}}">
                                                    @error('guard_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Guard Email</label>
                                                    <input type="text" name="guard_email" required
                                                           class="form-control @error('guard_email') is-invalid @enderror"
                                                           placeholder="Guard email" value="{{old('guard_email')}}">
                                                    @error('guard_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Guard Phone</label>
                                                    <input type="tel" name="guard_phone" required
                                                           class="telephone form-control @error('guard_phone') is-invalid @enderror"
                                                           value="{{old('guard_phone')}}">
                                                    @error('guard_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Guard Type</label>
                                                    <select class="form-control" name="guard_type" required>
                                                        <option value="1">Regular Guard</option>
                                                        <option value="0">Dispatch Guard</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Per Hour</label>
                                                    <input type="number" name="per_hour" required
                                                           class="form-control @error('per_hour') is-invalid @enderror"
                                                           placeholder="15" value="{{old('per_hour')}}">
                                                    @error('per_hour')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Guard License Information</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-5">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Guard License ID</label>
                                                        <input type="text" name="guard_license_id" required
                                                               class="form-control @error('guard_license_id') is-invalid @enderror"
                                                               placeholder="Guard license ID" value="{{old('guard_license_id')}}">
                                                        @error('guard_license_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Guard License Expiry</label>
                                                        <input type="text" name="guard_license_expiry" required
                                                               class="datepicker_field form-control @error('guard_license_expiry') is-invalid @enderror"
                                                              placeholder="Guard License Expiry" value="{{old('guard_license_expiry')}}">
                                                        @error('guard_license_expiry')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">

                                        </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Guard Documents</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Body-->
                                    <div class="card-body p-5">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Security Guard License <small>(Front)</small></label>
                                                    <input type="file" name="driving_license_image"
                                                           required
                                                           class="form-control @error('driving_license_image') is-invalid @enderror"
                                                    >
                                                    @error('driving_license_image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Photo ID <small>(Front)</small></label>
                                                    <input type="file" name="photo_id_image"
                                                           required
                                                           class=" form-control @error('photo_id_image') is-invalid @enderror"
                                                    >
                                                    @error('photo_id_image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Guard Driving Information</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Body-->
                                    <div class="card-body p-5">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Do you have driving license?</label>
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox checkbox-primary">
                                                            <input type="radio" checked="checked" value="no" class="driving_license" required name="driving_license">No
                                                            <span></span></label>
                                                        <label class="checkbox checkbox-success">
                                                            <input type="radio" value="yes" required class="driving_license" name="driving_license">Yes
                                                            <span></span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Driving License ID</label>
                                                    <input type="text" name="driving_license_id"
                                                           disabled
                                                           class="form-control @error('driving_license_id') is-invalid @enderror"
                                                           placeholder="Driving license ID" value="{{old('driving_license_id')}}">
                                                    @error('driving_license_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Driving License Expiry</label>
                                                    <input type="text" name="driving_license_expiry"
                                                           disabled
                                                           class="datepicker_field form-control @error('driving_license_expiry') is-invalid @enderror"
                                                           placeholder="Guard License Expiry"
                                                    value="{{old('driving_license_expiry')}}">
                                                    @error('driving_license_expiry')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">

                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Guard Availability</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Are you available to work?</label>
                                                            <select class="form-control select_2_custom work_availability" required name="work_availability">
                                                                @foreach($work_available as $w)
                                                                <option>{{$w}}</option>
                                                                    @endforeach
                                                            </select>
                                                        @error('work_availability')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Available Start Date?</label>
                                                        <input type="text" name="available_start_date" required
                                                               class="form-control datepicker_field @error('available_start_date') is-invalid @enderror"
                                                               placeholder="YYYY-MM-DD" value="{{date('Y-m-d')}}">
                                                        @error('available_start_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Shifts</th>
                                                            @foreach($days['days'] as $d)
                                                                <th>{{$d}}</th>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            @foreach($days['morning'] as $x => $d)
                                                                <td>
                                                                    @if($x == 0)
                                                                        {{$d}}
                                                                        @else
                                                                        <input type="checkbox" name="morning[]" value="{{$d}}">
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            @foreach($days['afternoon'] as $x => $d)
                                                                <td>
                                                                    @if($x == 0)
                                                                        {{$d}}
                                                                    @else
                                                                        <input type="checkbox" name="evening[]" value="{{$d}}">
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            @foreach($days['night'] as $x => $d)
                                                                <td>
                                                                    @if($x == 0)
                                                                        {{$d}}
                                                                    @else
                                                                        <input type="checkbox" name="night[]" value="{{$d}}">
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Create guard</button>
                                        </div>

                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                </div>
                </form>
                <!--end::Row-->
                <!--begin::Row-->

                <!--end::Row-->
                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('script')
    <script>
        $(document).on('change','.work_availability',function () {
            var work_availability = $(this).val();
            checkWorkAvailable(work_availability);
        });
        $(document).ready(function () {
            console.log("sss");
            var work_availability = $('.work_availability').val();
            checkWorkAvailable(work_availability);
        });

        function checkWorkAvailable(work_availability) {
            if(work_availability === "Full Time"){
                $('input[name="morning[]"]').prop('disabled', true);
                $('input[name="evening[]"]').prop('disabled', true);
                $('input[name="night[]"]').prop('disabled', true);
                //
                $('input[name="morning[]"]').prop('required', false);
                $('input[name="evening[]"]').prop('required', false);
                $('input[name="night[]"]').prop('required', false);
            }else{
                $('input[name="morning[]"]').prop('disabled', false);
                $('input[name="evening[]"]').prop('disabled', false);
                $('input[name="night[]"]').prop('disabled', false);
                //
                $('input[name="morning[]"]').prop('required', true);
                $('input[name="evening[]"]').prop('required', true);
                $('input[name="night[]"]').prop('required', true);
            }
        }

        //CheckBox Validations
        $(document).on('change','input[name="morning[]"]',function () {
            if($(this).is(':checked')) {
                $('input[name="morning[]"]').prop('required', false);
            } else {
                $('input[name="morning[]"]').prop('required', true);
            }
        });
        $(document).on('change','input[name="evening[]"]',function () {
            if($(this).is(':checked')) {
                $('input[name="evening[]"]').prop('required', false);
            } else {
                $('input[name="evening[]"]').prop('required', true);
            }
        });
        $(document).on('change','input[name="night[]"]',function () {
            if($(this).is(':checked')) {
                $('input[name="night[]"]').prop('required', false);
            } else {
                $('input[name="night[]"]').prop('required', true);
            }
        });

        //class="driving_license"

        $(document).on('change','.driving_license',function () {
            if($(this).is(':checked') && $(this).val() == 'yes') {
                $('input[name="driving_license_id"]').prop('required', true);
                $('input[name="driving_license_id"]').prop('disabled', false);
                $('input[name="driving_license_expiry"]').prop('required', true);
                $('input[name="driving_license_expiry"]').prop('disabled', false);
            } else {
                $('input[name="driving_license_id"]').prop('required', false);
                $('input[name="driving_license_id"]').prop('disabled', true);
                $('input[name="driving_license_expiry"]').prop('required', false);
                $('input[name="driving_license_expiry"]').prop('disabled', true);
            }
        });


        var input2 = document.querySelector(".telephone2");
        window.intlTelInput(input2, {
            // any initialisation options go here

            utilsScript: "{{URL::asset('assets/phone/js/utils.js?1613236686837')}}"
        });
        $('.select_2_custom').select2({
            placeholder: "Select your availability",
            allowClear: true
        });




    </script>
    @endsection

