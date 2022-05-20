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
                                <form method="get"  action="{{route('manage_mobile_patrol')}}" >
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Client</label>
                                                <select class="form-control" name="client_id" required>
                                                    <option value="">Select</option>
                                                    @foreach($client as $c)
                                                        <option value="{{$c->id}}">{{$c->client_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input type="date" name="from_date"
                                                       class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>To Date</label>
                                                <input type="date" name="to_date"
                                                       class="form-control" required>
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
                                    <a class="btn btn-primary" href="{{route('generate_attendance_pdf',['guard_id'=>request()->guard_id,'from'=>request()->from,'to'=>request()->to])}}">Export Pdf</a>
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
                                            <th>Client Name</th>
                                            <th>Instructions</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mobile_patrol as $p)
                                            <tr>
                                                <td>{{$p->guards ? $p->guards->guard_name : 'N/A'}}</td>
                                                <td>{{$p->client->client_name}}</td>
                                                <td>{{$p->instructions}}</td>
                                                @if($p->status == 1)
                                                <td><button type="button" class="btn btn-warning">Pending</button></td>
                                                @elseif($p->status == 2)
                                                    <td> <button type="button" class="btn btn-success">Completed</button></td>
                                                @else
                                                    <td> <button type="button" class="btn btn-danger">Deleted</button></td>
                                                @endif
                                                <td>
                                                    <a href="{{route('edit_mobile_patrol',['mobile_patrol_id' => $p->id,'hash' => md5($p->id)])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    <a href="{{route('delete_mobile_patrol',['mobile_patrol_id' => $p->id,'hash' => md5($p->id)])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    <a href="{{route('view_mobile_patrol_reports',['mobile_patrol_id' => $p->id,'hash' => md5($p->id)])}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    {{$mobile_patrol->links('vendor.pagination.bootstrap-4')}}
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

