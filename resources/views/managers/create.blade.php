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
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0  py-5">
                                <h3 class="card-title font-weight-bolder">Create a manager Account</h3>
                                <div class="card-toolbar">

                                </div>
                            </div>
                            <!--end::Header-->
                            <form method="post" action="{{route('save_manager_account')}}">
                                @csrf
                            <!--begin::Body-->
                                <div class="card-body p-5">
                                    <div>
                                        <div class="form-group">
                                            <label>Manager name</label>
                                            <input type="text" name="name" required
                                                   class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Manager Name" value="{{old('name')}}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Manager email</label>
                                            <input type="email" name="email" required
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="Manager Email" value="{{old('email')}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Manager password</label>
                                            <input type="password" name="password" required
                                                   min="8"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Manager Password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Demo account valid till</label>
                                            <input type="date" name="account_valid_till" required
                                                   class="form-control @error('account_valid_till') is-invalid @enderror"
                                                   placeholder="Manager Email" value="{{old('account_valid_till')}}">
                                            @error('account_valid_till')
                                            <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="checkbox m-0 text-muted font-weight-bold">
                                                <input type="checkbox" name="send_email" />Send credentials via email?
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create demo account</button>
                                </div>
                            </form>
                            <!--end::Body-->
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

