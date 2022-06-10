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
                                <form method="get"  action="{{route('shift_report')}}" >
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Guard</label>
                                                <select class="form-control" name="guard_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($guard as $g)
                                                        <option value="{{$g->id}}">{{$g->guard_name}}</option>
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
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="table-responsive">
                                    <table class="table table-separate table-head-custom kt_datatable">
                                        <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>shift Date</th>
                                            <th>Guard Name</th>
                                            <th>Time</th>
                                            <th>Reports</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($shifts as $s)
                                            <tr>
                                                <td>{{$s->client->client_name}}</td>
                                                <td>{{$s->only_date}}</td>
                                                <td>{{$s->guards->guard_name}}</td>
                                                <td>{{$s->local_from_date_time}} - {{$s->local_to_date_time}}</td>
                                                <td>
                                                    <a href="{{route('reports_by_schedule_incident',['schedule_id' => $s->id,'hash' => md5($s->id)])}}" class="btn btn-sm btn-primary">Incident Report</a>
                                                    <a href="{{route('daily_reports_by_schedule',['schedule_id' => $s->id,'hash' => md5($s->id)])}}" class="btn btn-success btn-sm">Daily Report</a>
                                                    <a href="{{route('reports_by_schedule_visitor',['schedule_id' => $s->id,'hash' => md5($s->id)])}}" class="btn btn-danger btn-sm">Visitor Report</a>
                                                    <a href="{{route('reports_by_schedule_attendance',['schedule_id' => $s->id,'hash' => md5($s->id)])}}" class="btn btn-warning btn-sm">Attendance Report</a>
                                                    <a href="#" class="btn btn-secondary btn-sm">QR Report</a>
                                                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2"
                                                       data-toggle="dropdown" aria-expanded="false"> <span
                                                                class="svg-icon svg-icon-md">
                                                            <i class="la la-bars"></i>
                                                        </span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="display: none;">
                                                        <ul class="navi flex-column navi-hover py-2">
                                                            <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                                                Forms:</li>
                                                            <li class="navi-item">
                                                                @foreach($form as $f)
                                                                    <a href="{{route('reports_by_clients_forms',['form_id' => $f->id])}}" class="navi-link">
                                                                    <span class="navi-icon">
                                                                        <i class=" menu-bullet-dot"></i>
                                                                    </span>
                                                                        <span class="navi-text">{{$f->name}}</span>
                                                                    </a>
                                                                @endforeach
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    {{$shifts->links('vendor.pagination.bootstrap-4')}}
                                </div>
                            </div>

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
@section('script')

@endsection

