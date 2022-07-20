@foreach($daily_report as $d)
    <table class="customerInfo" style="margin-top: -1px;width: 100% !important;
                border: 1px solid #E5E5E5; border-collapse: collapse !important">
        <tr>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Information</th>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Daily Report</th>
            <th style="background-color: #f2f2f2; color: #808080; text-transform: uppercase">Image</th>
        </tr>
        <tr>
            <td style="width: 20%">
                <p style="font-size: 10px"><b>Location</b>: {{$d->client->client_address}}</p>
                <p style="font-size: 10px"><b>Client</b>: {{$d->client->client_name}}</p>
                <p style="font-size: 10px"><b>Guard</b>: {{$d->guards->guard_name}}</p>
                <p style="font-size: 10px"><b>Time</b>: {{$d->local_time}}</p>
                <p style="font-size: 10px"><b>Date</b>: {{$d->local_date}}</p>
            </td>
            <td style="width: 40%">
                <p style="font-size: 10px;text-decoration: underline"><b>Information:</b></p>
                <p style="font-size: 10px">{{$d->description}} </p>
            </td>
            <td style="width: 40%;padding: 0">
                @if(count($d->daily_report_images) >= 1)
                    <img src="{{$d->daily_report_images->first()->images}}" width="280">
                @else
                    <img src="http://localhost/MobilePatrol/public/assets/no-image.jpg" width="280">
                @endif
            </td>
        </tr>
    </table>
@endforeach
