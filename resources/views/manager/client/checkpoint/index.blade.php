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

                <!--begin::Row-->
                <div class="row">

                    <div class="col-lg-4">
                        <form method="post" action="{{route('create_qr_checkpoint')}}" enctype="multipart/form-data">
                            @csrf
                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Create QR</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->

                                    <!--begin::Body-->
                                    <div class="card-body p-5">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Checkpoint Name (QR)</label>
                                                    <input type="hidden" name="client_id" value="{{request()->client_id}}">
                                                    <input type="text" name="qr_code" required
                                                           class="form-control @error('qr_code') is-invalid @enderror"
                                                           placeholder="Checkpoint Name" value="{{old('qr_code')}}">
                                                    @error('qr_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Create QR</button>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                        </form>
                    </div>

                    <div class="col-lg-8">
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
                                        <div class="table-responsive">
                                            <table class="table table-separate table-head-custom kt_datatable">
                                                <thead>
                                                <tr>
                                                    <th>Checkpoint Name</th>
                                                    <th>QR Code</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($checkpoints as $g)
                                                    <tr>
                                                        <td>{{$g->checkpoint_name}}</td>
                                                        <td>{{$g->qr_code}}</td>
                                                      <td>
                                                            <a href="{{route('print.qrcode.single',['id' => $g->id,'hash' => md5($g->id)])}}" class="btn btn-warning btn-sm">Print</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="float-right">
                                            {{$checkpoints->links('vendor.pagination.bootstrap-4')}}
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                </div>

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

