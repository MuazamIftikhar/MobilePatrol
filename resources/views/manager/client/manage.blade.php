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
                    <div class="col-lg-12">
                        <!--begin::Mixed Widget 1-->
                        <div class="card card-custom card-stretch gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0  py-5">
                                <h3 class="card-title font-weight-bolder">{{$title}}</h3>
                                <div class="card-toolbar">
                                    <a class="btn btn-primary" href="{{route('create_client')}}">Add Clients</a>
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
                                                <th>Client Email</th>
                                                <th>Phone </th>
                                                <th>Address</th>
                                                <th>Account</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($clients as $g)
                                                   <tr>
                                                       <td>{{$g->client_name}}</td>
                                                       <td>{{$g->client_email}}</td>
                                                       <td>{{$g->client_phone}}</td>
                                                       <td>{{$g->client_address}}</td>
                                                       <td><input {{$g->user->status == 1 ? "checked" : ""}} data-handle-width="70" data-switch="true" onchange="formStatus('{{$g->user_id}}',event)" type="checkbox" data-on-text="Activated"  data-off-text="Disabled" data-on-color="primary" /></td>
                                                       <td>
                                                           <a href="{{route('edit_client',['client_id' => $g->id,'hash' => md5($g->id)])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                           <a href="{{route('client_checkpoints',['client_id' => $g->id,'hash' => md5($g->id)])}}" class="btn btn-primary btn-sm">Checkpoints</a>
                                                       </td>
                                                   </tr>
                                                   @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        {{$clients->links('vendor.pagination.bootstrap-4')}}
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
    <script>
        function formStatus(form_id,event){
            var status = event.target.checked;
            console.log('status '+status);
            $.ajax({
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('change_form_status')}}",
                data: {'form_id':form_id,'status':status},
                dataType: "json",
                success: function (data) {
                    //alert(data.message);
                },
                error: function (data) {

                },
            });
        }
    </script>
@endsection

