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
                        <span  class="alert-text"><strong>{{strtoupper(session('message')['class'])}}!</strong> {{session('message')['result']}}</span>
                    </div>
                @endif
                <form method="post" action="{{route('save_incident_report')}}" enctype="multipart/form-data">
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
                                                        <select class="form-control client_id" id="client_id" name="client_id" required>
                                                            <option value="">----SELECT-----</option>
                                                            @foreach($clients as $c)
                                                                <option value="{{$c->id}}">{{$c->client_name}}</option>
                                                            @endforeach
                                                        </select>
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
                                                        <select class="form-control guard_id" id="guard_id" name="guard_id" required>
                                                            <option value="">----SELECT-----</option>
                                                            @foreach($guards as $g)
                                                                <option value="{{$g->id}}">{{$g->guard_name }}</option>
                                                            @endforeach
                                                        </select>
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
                                                        <select class="form-control schedule_id" id="schedule_id" name="schedule_id" required>
                                                           <option value="">----SELECT----</option>
                                                        </select>
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
                                                        <input class="form-control" name="anyone_arrested" >
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
                                                        <input class="form-control" name="property_damaged" >
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
                                                        <input class="form-control" name="witness" >
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
                                                        <input class="form-control" name="nature_of_complaint" >
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
                                                        <input type="file" multiple class="form-control" name="photos[]" >
                                                        @error('images')
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Information</label>
                                                        <textarea class="form-control" name="information" rows="2"></textarea>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $(".client_id,.guard_id").change(function() {
                let client_id = $(".client_id").val();
                let guard_id = $(".guard_id").val();
                $.ajax({
                    type: "post",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{route('get_schedule')}}",
                    data: {client_id:client_id,guard_id:guard_id},
                    dataType: "json",
                    success: function (data) {
                        $('.schedule_id').empty();
                        $('.schedule_id').append($('<option>',
                            {
                                value: "",
                                text: "----SELECT----",
                            }));
                        $.each(data , function (key, value) {
                            console.log(value.local_from_date_time);
                            $('.schedule_id').append($('<option>',
                                {
                                    value: value.id,
                                    text: value.local_from_date_time,
                                }));
                        });
                    },
                });
            });
        });
    </script>
@endsection