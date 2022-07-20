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
                @foreach($attendance as $a)
                <form method="post" action="{{route('edit_guard_attendance')}}" enctype="multipart/form-data">
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
                                            <div class="card-toolbar">

                                            </div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body p-5">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Time In</label>
                                                        <input type="text" name="time_in" required
                                                               class="form-control  @error('time_in') is-invalid @enderror"
                                                               value="{{$a->local_time_in}}" id="kt_1">
                                                        <input value="{{$a->id}}" name="id" type="hidden">
                                                        <input type="hidden" name="timezone" id="timezone" value="{{$timezone}}">
                                                        @error('time_in')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Time In</label>
                                                        <input type="text" name="time_out" required
                                                               class="form-control @error('time_out') is-invalid @enderror"
                                                               value="{{$a->local_time_out}}" id="kt">
                                                        @error('time_out')
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
                                                        <label>Client</label>
                                                        <select class="form-control" name="client_id" required>
                                                            @foreach($client as $c)
                                                                <option value="{{$c->id}}"  >{{$c->client_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                    <!--end::Body-->
                                </div>
                            </div>
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>

                </form>
                @endforeach
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
            $("#kt_1").datetimepicker({
            });
            $("#kt").datetimepicker({
            });

        });
    </script>
@endsection

