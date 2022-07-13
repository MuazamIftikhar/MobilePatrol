@foreach($visitor as $s)
    <table class="customerInfo" style="margin-top: -1px;width: 100% !important;  border: 1px solid #E5E5E5; border-collapse: collapse !important">
        <tr>
            <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Site Information</th>
            <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Visitor Information</th>
            <th style="background-color: #10A5F5; color: #ffffff; text-transform: uppercase">Image</th>
        </tr>
        <tr>
            <td style="width: 20%">
                <p style="font-size: 10px"><b>Location</b>: {{$s->client->client_address}}</p>
                <p style="font-size: 10px"><b>Client</b>: {{$s->client->client_name}}</p>
                <p style="font-size: 10px"><b>Guard</b>: {{$s->guards->guard_name}}</p>
                <p style="font-size: 10px"><b>Time</b>: {{$s->local_time}}</p>
                <p style="font-size: 10px"><b>Date</b>: {{$s->local_date}}</p>
            </td>
            <td style="width: 40%">

                <p style="font-size: 10px;text-decoration: underline"><b>Visitor Name:</b></p>
                <p style="font-size: 10px">{{$s->visitor_name}}</p>
                <p style="font-size: 10px; text-decoration: underline"><b>Visitor Purpose:</b></p>
                <p style="font-size: 10px">{{$s->purpose}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Visitor Company</b></p>
                <p style="font-size: 10px">{{$s->company}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Time In</b></p>
                <p style="font-size: 10px">{{$s->local_time_in}}</p>
                <p style="font-size: 10px;text-decoration: underline"><b>Time Out:</b></p>
                <p style="font-size: 10px">{{$s->local_time_out != null ? $s->local_time_out : 'N/A'}}</p>
            </td>
            <td style="width: 40%;padding: 0">
                @if(count($s->visitor_report_images) >= 1)
                    <img src="{{$s->visitor_report_images->first()->images}}" width="280">
                @else
                    <img src="http://localhost/MobilePatrol/public/assets/no-image.jpg" width="280">
                @endif
            </td>
        </tr>
    </table>
@endforeach
