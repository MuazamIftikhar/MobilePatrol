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
                </div>
                <div class="d-flex align-items-center">

                </div>
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
                        <span class="alert-text"><strong>{{strtoupper(session('message')['class'])}}
                                !</strong> {{session('message')['result']}}</span>
                    </div>
            @endif
            <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8 ">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom card-stretch gutter-b">
                            <div class="card-body p-5">
                                <form method="get"  action="{{route('qr_reports_by_schedule',['schedule_id'=>$schedule->id,'hash'=>md5($schedule->id)])}}" >
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Guard</label>
                                                <select class="form-control" name="guard_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($guard as $c)
                                                        <option value="{{$c->id}}">{{$c->guard_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input type="date" name="from" required
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>To Date</label>
                                                <input type="date" name="to" required
                                                       class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success form-control mt-8">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0  py-5">
                                <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                <div class="card-toolbar">
                                    {{--<a class="btn btn-primary" href="{{route('generate_schedule_attendance_pdf',['guard_id'=>request()->guard_id,--}}
                                    {{--'from'=>request()->from,'to'=>request()->to,'schedule_id'=>$schedule->id])}}">Export Pdf</a>--}}
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="table-responsive">
                                    <table class="table table-separate table-head-custom kt_datatable">
                                        <thead>
                                        <tr>
                                            <th>Guard Name</th>
                                            <th>Guard Email</th>
                                            <th>Time In</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($check_point as $c)
                                            <tr>
                                                <td>{{$c->guards->guard_name}}</td>
                                                <td>{{$c->guards->guard_email}}</td>
                                                <td>{{$c->checkpoint->checkpoint_name}}</td>
                                                <td>{{$c->type}}</td>
                                                <td>{{$c->date}}</td>
                                                <td>
                                                    <a href="{{route('edit_timing',['id' => $c->id,'hash' => md5($c->id)])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-1x"></i></a>
                                                    <a href="{{route('delete_timing',['id' => $c->id,'hash' => md5($c->id)])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-1x"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    {{$check_point->links('vendor.pagination.bootstrap-4')}}
                                </div>
                            </div>

                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 1-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('script')
@endsection