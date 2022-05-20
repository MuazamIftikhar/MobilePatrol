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
                <form method="post" action="{{route('save_mobile_patrol_report',['mobile_patrol_id'=>$mobile_patrol_id])}}" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Mixed Widget 1-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <!--begin::Header-->
                                        <div class="card-header border-0  py-5">
                                            <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                        </div>
                                        <!--end::Header-->

                                        <!--begin::Body-->
                                        <div class="card-body p-5">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Guard</label>
                                                        <select class="form-control" name="guard_id" required>
                                                            @foreach($guards as $g)
                                                                <option value="{{$g->id}}">{{$g->guard_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('guard_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="text" name="date" class="form-control" id="kt">
                                                        <input type="hidden" name="timezone" id="timezone" value="{{$timezone}}">
                                                        @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Information</label>
                                                        <textarea class="form-control" name="information" rows="5"></textarea>
                                                        @error('information')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Create Mobile Patrol Report</button>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Mixed Widget 1-->
                        </div>

                    </div>
                </form>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var timezone=$('.timezone').val();
            moment.tz.setDefault(timezone);
            var setDate = moment();
            $('#kt').val(setDate.format('YYYY-MM-DD hh:mm'));
            $("#kt").datetimepicker({
            });
        });
    </script>
@endsection