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
                    <div class="col-lg-12">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0  py-5">
                                <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                <div class="card-toolbar">
                                    <a class="btn btn-primary" href="{{route('generate_schedule_attendance_pdf',['guard_id'=>request()->guard_id,
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
                                            <th>Guard Name</th>
                                            <th>Guard Email</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($attendance as $g)
                                            <tr>
                                                <td>{{$g->guards->guard_name}}</td>
                                                <td>{{$g->guards->guard_email}}</td>
                                                <td>{{$g->local_time_in}}</td>
                                                <td>{{$g->local_time_out}}</td>
                                                <td>
                                                    <a href="{{route('edit_timing',['id' => $g->id,'hash' => md5($g->id)])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-1x"></i></a>
                                                    <a href="{{route('delete_timing',['id' => $g->id,'hash' => md5($g->id)])}}" id="kt_sweetalert_demo_5" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-1x"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-right">
                                    {{$attendance->links('vendor.pagination.bootstrap-4')}}
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
    <script>

        $("#kt_sweetalert_demo_5").click(function (e) {
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "<i class='la la-headphones'></i> I am game!",
                showCancelButton: true,
                cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-default"
                }
            });
        });
    </script>
@endsection
