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
                <form method="post" action="{{route('save_incident_report',['schedule_id'=>request()->schedule_id,'timezone'=>$timezone])}}"
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
                                                               value="{{$schedule->client->client_name}}">
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
                                                               value="{{$schedule->guards->guard_name}}">
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
                                                               value="{{$schedule->local_from_date_time}} | {{$schedule->local_to_date_time}}">
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
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
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
                                                        <input class="form-control" name="anyone_arrested">
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
                                                        <input class="form-control" name="property_damaged">
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
                                                        <input class="form-control" name="witness">
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
                                                        <input class="form-control" name="nature_of_complaint">
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
                                                        <input type="datetime-local"  class="form-control" name="date">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Information</label>
                                                        <textarea class="form-control" name="information"
                                                                  rows="2"></textarea>
                                                        @error('instructions')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{route('reports_by_schedule_incident',['schedule_id'=>request()->schedule_id,'hash'=>md5(request()->schedule_id)])}}" class="btn btn-default">Back</a>
                                            <button type="submit" class="btn btn-primary">Create Incident Report</button>
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
