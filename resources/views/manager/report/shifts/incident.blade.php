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
                    <div class="col-lg-12">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0  py-5">
                                <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                <div class="card-toolbar">
                                    <a class="btn btn-secondary" href="{{route('create_incident_report',['schedule_id'=>$schedule->id,
                                    'hash'=>md5($schedule->id)])}}">Add Report</a>&nbsp;
                                    <a class="btn btn-primary" href="{{route('generate_schedule_incident_report_pdf',['guard_id'=>request()->guard_id,
                                                'from'=>request()->from,'to'=>request()->to,'schedule_id'=>$schedule->id])}}">Export Pdf</a>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-5">
                                <div class="table-responsive">
                                    <table class="table table-separate table-head-custom kt_datatable">
                                        <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Guard Name</th>
                                            <th>Nature Of Complaints</th>
                                            <th>Police Called</th>
                                            <th>Anyone Arrested</th>
                                            <th>Property Damaged</th>
                                            <th>Witness</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($incident as $s)
                                            <tr>
                                                <td>{{$s->client->client_name}}</td>
                                                <td>{{$s->guards->guard_name}}</td>
                                                <td>{{$s->nature_of_complaint}}</td>
                                                <td>{{$s->police_called}}</td>
                                                <td>{{$s->anyone_interested}}</td>
                                                <td>{{$s->property_damaged}}</td>
                                                <td>{{$s->witness}}</td>
                                                <td>
                                                    <a href="{{route('update_incident_report',['incident_id' => $s->id,'hash' => md5($s->id)])}}"
                                                       class="btn btn-warning btn-sm"><i class="fa fa-edit fa-1x"></i></a>
                                                    <a href="{{route('delete_timing',['id' => $s->id,'hash' => md5($s->id)])}}"
                                                       class="btn btn-danger btn-sm"><i class="fa fa-trash fa-1x"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    {{$incident->links('vendor.pagination.bootstrap-4')}}
                                </div>
                            </div>
                        </div>
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