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
                <form method="post" action="{{route('edit_qr_report',['checkpoint_hitory_id'=>$checkpoint_history->id,'hash'=>md5($checkpoint_history->id),'timezone'=>$timezone])}}"
                      enctype="multipart/form-data">
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
                                        <div class="card-body p-5">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Client</label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$checkpoint_history->client->client_name}}">
                                                        @error('client_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Guard</label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$checkpoint_history->guards->guard_name}}">
                                                        @error('guard_id')
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
                                                        <label>Schedule </label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$checkpoint_history->schedule->local_from_date_time}} | {{$checkpoint_history->schedule->local_to_date_time}}">
                                                        @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Check Point</label>
                                                        <select class="form-control" name="checkpoint_id">
                                                            <option value="">---Select---</option>
                                                            @foreach($checkpoint as $c)
                                                                <option value="{{$c->id}}" {{$c->id == $checkpoint_history->checkpoint_id ? "selected" : ""}}>{{$c->checkpoint_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('photos')
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
                                                        <label>Type </label>
                                                        <input type="text" class="form-control" name="type" value="{{$checkpoint_history->type}}">
                                                        @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="datetime-local"  class="form-control"
                                                                name="date" value="{{$checkpoint_history->local_date_time}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            @if(request()->type == "schedule")
                                                <a href="{{route('qr_reports_by_schedule',['schedule_id'=>$checkpoint_history->schedule_id,'hash'=>md5($checkpoint_history->schedule_id)])}}" class="btn btn-default">Back</a>
                                            @elseif(request()->type == "client")
                                                <a href="{{route('qr_reports_by_clients',['client_id'=>$checkpoint_history->client_id,'hash'=>md5($checkpoint_history->client_id)])}}" class="btn btn-default">Back</a>
                                            @endif
                                            <button type="submit" class="btn btn-primary">{{$title}}</button>
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
@endsection
