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
                <form method="post" action="{{route('edit_visitor_report',['visitor_report_id'=>$visitor->id,'admin_id'=>$visitor->admin_id])}}"
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
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Client</label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$visitor->client->client_name}}">
                                                        @error('client_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Guard</label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$visitor->guards->guard_name}}">
                                                        @error('guard_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Schedule </label>
                                                        <input type="text" readonly="readonly" class="form-control"
                                                               value="{{$visitor->schedule->local_from_date_time}} | {{$visitor->schedule->local_to_date_time}}">
                                                        @error('date')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Visitor Name</label>
                                                        <input type="text" name="visitor_name" class="form-control" value="{{$visitor->visitor_name}}" required>
                                                        @error('visitor_name')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Purpose</label>
                                                        <input class="form-control" name="purpose" value="{{$visitor->purpose}}"  required>
                                                        @error('purpose')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Company</label>
                                                        <input class="form-control" name="company" value="{{$visitor->company}}">
                                                        @error('company')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Time In</label>
                                                        <input type="datetime-local" name="time_in" class="form-control" value="{{date('Y-m-d\TH:i:s', strtotime($visitor->local_time_in))}}" required>
                                                        @error('visitor_name')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
{{--                                                {{date('c', $visitor->local_time_in)}}--}}
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Time Out</label>
                                                        <input type="datetime-local" class="form-control" name="time_out" value="{{date('Y-m-d\TH:i:s', strtotime($visitor->local_time_out))}}" required>
                                                        @error('time_out')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Images</label>
                                                        <input type="file" multiple class="form-control"
                                                               name="photos[]">
                                                        <br>
                                                        @foreach($visitor->visitor_report_images as $i)
                                                            <a href="{{$i->images}}"><img src="{{$i->images}}" width="100px"></a> &nbsp; &nbsp;
                                                        @endforeach
                                                        @error('images')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            @if(request()->type == "schedule")
                                                <a href="{{route('reports_by_schedule_visitor',['schedule_id'=>$visitor->schedule_id,'hash'=>md5($visitor->schedule_id)])}}" class="btn btn-default">Back</a>
                                            @elseif(request()->type == "client")
                                                <a href="{{route('reports_by_clients_visitor',['client_id'=>$visitor->client_id,'hash'=>md5($visitor->client_id)])}}" class="btn btn-default">Back</a>
                                            @endif
                                            <button type="submit" class="btn btn-primary">{{$title}}
                                            </button>
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
