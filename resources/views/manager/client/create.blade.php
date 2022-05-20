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
                <form method="post" action="{{route('save_client')}}" enctype="multipart/form-data">
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
                                            <a class="btn btn-primary" href="{{route('manage_clients')}}">Manage Clients</a>
                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Body-->
                                    <div class="card-body p-5">
                                        <div class="alert alert-default bg-light-info" role="alert">
                                            <span  class="alert-text"><strong>Note!</strong> Client phone number will be automatically converted to password.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Client Name</label>
                                                    <input type="text" name="client_name" required
                                                           class="form-control @error('client_name') is-invalid @enderror"
                                                           placeholder="Client name" value="{{old('client_name')}}">
                                                    @error('client_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Client Email</label>
                                                    <input type="text" name="client_email" required
                                                           class="form-control @error('client_email') is-invalid @enderror"
                                                           placeholder="Client email" value="{{old('client_email')}}">
                                                    @error('client_email')
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
                                                    <label>Client Phone</label>
                                                    <input type="tel" name="client_phone" required
                                                           class="telephone form-control @error('client_phone') is-invalid @enderror"
                                                           value="{{old('client_phone')}}">
                                                    @error('client_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Client Address</label>
                                                    <input type="text" name="client_address" required
                                                           class="form-control @error('client_address') is-invalid @enderror"
                                                           placeholder="Client Address" value="{{old('client_address')}}">
                                                    @error('client_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Create client</button>
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

