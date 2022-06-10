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

                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Company Details</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <form method="post" action="{{route('save_company_details')}}">
                                        @csrf
                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <input type="hidden" name="form_type" value="company_details_saved">
                                            <div>
                                                <div class="form-group">
                                                    <label>Company name</label>
                                                    <input type="text" name="company_name" required
                                                           class="form-control @error('company_name') is-invalid @enderror"
                                                           placeholder="Company name" value="{{$company_details->company_name ?? ""}}">
                                                    @error('company_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea rows="2" name="company_address" required
                                                           class="form-control @error('company_address') is-invalid @enderror"
                                                              placeholder="Company address">{{$company_details->company_address??""}}</textarea>
                                                    @error('company_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="tel" name="company_phone" required
                                                           class="telephone form-control @error('company_phone') is-invalid @enderror"
                                                           value="{{$company_details->company_phone??""}}" >
                                                    @error('company_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Fax</label>
                                                    <input type="text" name="company_fax" required
                                                           class="form-control @error('company_fax') is-invalid @enderror"
                                                           placeholder="Company fax" value="{{$company_details->company_fax??""}}">
                                                    @error('company_fax')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" name="company_email" required
                                                           class="form-control @error('company_email') is-invalid @enderror"
                                                           placeholder="Company email" value="{{$company_details->company_email??""}}">
                                                    @error('company_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Website</label>
                                                    <input type="text" name="company_website" required
                                                           class="form-control @error('company_email') is-invalid @enderror"
                                                           placeholder="Company website" value="{{$company_details->company_website??""}}">
                                                    @error('company_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Create company information</button>
                                        </div>
                                    </form>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>

                    <div class="col-lg-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Add Logo</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <form method="post" action="{{route('save_company_details')}}" enctype="multipart/form-data">
                                        @csrf
                                        <!--begin::Body-->
                                        <input type="hidden" name="form_type" value="logo_added">
                                        <div class="card-body p-5">
                                            <div>
                                                <div class="form-group">
                                                    <label>Add Logo {{config("app.image_domain")}}</label>
                                                    <input type="file" name="company_logo" required
                                                           class="form-control @error('company_logo') is-invalid @enderror"
                                                           >
                                                    @error('company_logo')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                @if($company_details && $company_details->company_logo)
                                                <div>
                                                    <img src="{{$company_details->company_logo}}" width="150">
                                                </div>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Save Logo</button>
                                        </div>
                                    </form>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Set Clock In/Out Message</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <form method="post" action="{{route('save_company_details')}}">
                                        @csrf
                                        <input type="hidden" name="form_type" value="clock_in_and_out_message">
                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <div>
                                                <div class="form-group">
                                                    <label>Clock in message</label>
                                                    <textarea rows="2" name="company_clock_in_message" required
                                                              class="form-control @error('company_clock_in_message') is-invalid @enderror"
                                                              placeholder="Company clock in message">{{$company_details->company_clock_in_message??""}}</textarea>
                                                    @error('company_clock_in_message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Clock out message</label>
                                                    <textarea rows="2" name="company_clock_out_message" required
                                                              class="form-control @error('company_clock_out_message') is-invalid @enderror"
                                                              placeholder="Company clock out message">{{$company_details->company_clock_out_message??""}}</textarea>
                                                    @error('company_clock_out_message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Create clock in/out message</button>
                                        </div>
                                    </form>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>

                    <div class="col-lg-4">
                        <!--begin::Mixed Widget 1-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Set Timezone</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <form method="post" action="{{route('save_company_details')}}">
                                        @csrf
                                        <input type="hidden" name="form_type" value="time_zone_updated">
                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <div>
                                                <div class="form-group">

                                                    <select name="company_time_zone" required class="select_2 form-control @error('company_time_zone') is-invalid @enderror">
                                                        @foreach($timezones as $t)
                                                        <option {{$company_details? $company_details->company_time_zone == $t['zone'] ? "selected" : "" : "" }} value="{{$t['zone']}}">{{$t['zone']}} ({{$t['GMT_difference']}})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('company_time_zone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update timezone</button>
                                        </div>
                                    </form>
                                    <!--end::Body-->
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0  py-5">
                                        <h3 class="card-title font-weight-bolder">Input phone number for SMS</h3>
                                        <div class="card-toolbar">

                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <form method="post" action="{{route('save_company_details')}}">
                                        @csrf
                                        <input type="hidden" name="form_type" value="phone_number_for_sms_updated">
                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <div>
                                                <div class="form-group">
                                                    <label>Phone number</label>
                                                    <input type="tel" name="company_phone_number_for_sms" required
                                                           class="telephone2 form-control @error('company_phone_number_for_sms') is-invalid @enderror"
                                                           value="{{$company_details->company_phone_number_for_sms??""}}">
                                                    @error('company_phone_number_for_sms')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update SMS phone</button>
                                        </div>
                                    </form>
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
        var input2 = document.querySelector(".telephone2");
        window.intlTelInput(input2, {
            // any initialisation options go here

            utilsScript: "{{URL::asset('assets/phone/js/utils.js?1613236686837')}}"
        });
    </script>
    @endsection

