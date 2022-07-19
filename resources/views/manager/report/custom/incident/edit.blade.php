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
                <form method="post" action="{{route('edit_incident_report',['incident_id'=>request()->incident_id,'timezone'=>$timezone])}}"
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
                                                               value="{{$incident->client->client_name}}">
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
                                                               value="{{$incident->guards->guard_name}}">
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
                                                               value="{{$incident->schedule->local_from_date_time}} | {{$incident->schedule->local_to_date_time}}">
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
                                                        <label>Police Called </label>
                                                        <select class="form-control" name="police_called" required>
                                                            <option value="Yes" {{$incident->police_called == "Yes" ? "selected" : ""}}>Yes</option>
                                                            <option value="No"  {{$incident->police_called == "No" ? "selected" : ""}}>No</option>
                                                        </select>
                                                        @error('police_called')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Anyone Arrested</label>
                                                        <input class="form-control" name="anyone_arrested" value="{{$incident->anyone_interested}}">
                                                        @error('guard_id')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Property Damaged</label>
                                                        <input class="form-control" name="property_damaged" value="{{$incident->property_damaged}}">
                                                        @error('property_damaged')
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
                                                        <label>Witness</label>
                                                        <input class="form-control" name="witness" value="{{$incident->witness}}">
                                                        @error('witness')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Nature of Complaints</label>
                                                        <input class="form-control" name="nature_of_complaint" value="{{$incident->nature_of_complaint}}">
                                                        @error('nature_of_complaint')
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
                                                        @error('images')
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
                                                        <label>Date</label>
                                                        <input type="datetime-local"  class="form-control"
                                                               name="date" value="{{$incident->local_date}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">

                                                </div>
                                                <div class="col-lg-4">
                                                    @foreach($incident->incident_report_images as $i)
                                                        <a href="{{$i->images}}"><img src="{{$i->images}}" width="100px"></a> &nbsp; &nbsp;
                                                    @endforeach
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Information</label>
                                                        <textarea class="form-control" name="information"
                                                                  rows="2">{{$incident->information}}</textarea>
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
                                            @if(request()->type == "schedule")
                                            <a href="{{route('reports_by_schedule_incident',['schedule_id'=>$incident->schedule_id,'hash'=>md5($incident->schedule_id)])}}" class="btn btn-default">Back</a>
                                            @elseif(request()->type == "client")
                                            <a href="{{route('reports_by_clients_incident',['client_id'=>$incident->client_id,'hash'=>md5($incident->client_id)])}}" class="btn btn-default">Back</a>
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
